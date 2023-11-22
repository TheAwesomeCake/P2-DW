<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\Endereco;
use App\Model\Usuario;
use App\Controller\EnderecoController;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Cryptonita\Crypto;
use PDO;

class UsuarioController {

    private $db;
    private $usuario;
    private $endereco;
    private $enderecoController;

    public function __construct() {
        $this->db = new Model();
        $this->usuario = new Usuario();
        $this->endereco = new Endereco();
        $this->enderecoController = new EnderecoController();
    }
    public function validarToken($token){
        $key = '9b426114868f4e2179612445148c4985429e5138758ffeed5eeac1d1976e7443';
        $algoritimo = 'HS256';
        try {
            $decoded = JWT::decode($token, new Key($key, $algoritimo));
            $permissoes = $decoded->telas;
            if($_SERVER['SERVER_NAME']==$decoded->aud){
                return ['status' => true, 'message' => 'Token válido!', 'telas'=>$permissoes];
            }else{
                return ['status' => false, 'message' => 'Token inválido! Motivo: dominio invalido' ];
            }
        } catch(Exception $e) {
            return ['status' => false, 'message' => 'Token inválido! Motivo: ' . $e->getMessage()];
        }
    }
    
    public function login($data) {
        $email = $data['email'];
        $senha = $data['senha'];
        $lembrar = $data['lembrar'];
        $condicoes = ['email'=>$email];
        $resultado = $this->db->select('usuario', $condicoes);
        $checado=$lembrar? 60*12 : 3;
        if (!$resultado) {
            return ['status' => false, 'message' => 'Usuário não encontrado.'];
        }
        if (!password_verify($senha, $resultado[0]['senha'])) {
            return ['status' => false, 'message' => 'Senha incorreta.'];
        }
        $permissoes = $this->db->getPermissoesByPerfil($resultado[0]['perfil_id']);
        $key = '9b426114868f4e2179612445148c4985429e5138758ffeed5eeac1d1976e7443';
        $local=$_SERVER['HTTP_HOST'];
        $nome=$_SERVER['SERVER_NAME'];
        $algoritimo='HS256';
            $payload = [
                "iss" =>  $local,
                "aud" =>  $nome,
                "iat" => time(),
                "exp" => time() + (60 * $checado),  
                "sub" => $email,
                'telas'=>$permissoes
            ];
            
            $jwt = JWT::encode($payload, $key, $algoritimo);
        return ['status' => true, 'message' => 'Login bem-sucedido!','token'=>$jwt,'telas'=>$permissoes];
    }
    public function getUserList(){
        $user = $this->db->select('usuario');
        
        return  $user;
    }
    public function getUserIdadeList() {
        $idadeList = $this->db->select('idades');
        return $idadeList; 
    }
    public function getUserById($id){
        $user = $this->db->select('usuario',['id'=>$id]);
        
        return  $user;
    }
    public function createUser($data){
        $this->usuario->setNome($data['nome']);
        $this->usuario->setEmail($data['email']);
        $this->usuario->setDataNascimento($data['dataNascimento']);
        $this->usuario->setSenha($data['senha']);

        if ($this->db->insert('usuario',
            [
                'nome'=>$this->usuario->getNome(),
                'email'=>$this->usuario->getEmail(),
                'data_nascimento'=>$this->usuario->getDataNascimento(),
                'senha'=>$this->usuario->getSenha() 
        ])) {
            $iduser=$this->db->getLastInsertId();
            $data['iduser'] = $iduser;
            
            $this->enderecoController->createEndereco($data);
            return true;
        } else {
            return false;
        }
    }
    public function updateUser($newData, $id){
        if($this->db->update('usuario', $newData, ['id'=>$id])){
            return true;
        }
        return false;
    }
    public function deleteUser($id){
        if($this->db->delete('usuario', ['id'=>$id])){
            return true;
        }
        return false;
        
    }
}
?>
