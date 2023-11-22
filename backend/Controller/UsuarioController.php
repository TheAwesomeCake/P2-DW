<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\Endereco;
use App\Model\Usuario;
use App\Controller\EnderecoController;

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
    public function getUserList(){
        $user = $this->db->select('users');
        
        return  $user;
    }
    public function getUserIdadeList() {
        $idadeList = $this->db->select('idades');
        return $idadeList; 
    }
    public function getUserById($id){
        $user = $this->db->select('users',['id'=>$id]);
        
        return  $user;
    }
    public function createUser($data){
        $this->usuario->setNome($data['nome']);
        $this->usuario->setEmail($data['email']);
        $this->usuario->setDataNascimento($data['dataNascimento']);
        $this->usuario->setSenha($data['senha']);

        if ($this->db->insert('users',
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
        if($this->db->update('users', $newData, ['id'=>$id])){
            return true;
        }
        return false;
    }
    public function deleteUser($id){
        if($this->db->delete('users', ['id'=>$id])){
            return true;
        }
        return false;
        
    }
}
?>
