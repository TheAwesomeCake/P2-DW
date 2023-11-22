<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\Endereco;

class EnderecoController {

    private $db;
    private $endereco;

    public function __construct() {
        $this->db = new Model();
        $this->endereco = new Endereco();
    }
    public function getEnderecoList(){
        $produto = $this->db->select('endereco');
        return  $produto;
    }
    public function getEnderecoListByUserId($userId) {
        $enderecoList = $this->db->select('endereco', ['iduser'=>$userId]);
        return $enderecoList;
    }
    public function getEnderecoById($id){
        $produto = $this->db->select('endereco',['id'=>$id]);
        return  $produto;
    }

    public function createEndereco($data){
        $this->endereco->setCep($data['cep']);
        $this->endereco->setRua($data['rua']);
        $this->endereco->setBairro($data['bairro']);
        $this->endereco->setCidade($data['cidade']);
        $this->endereco->setuf($data['uf']);
        $this->endereco->setIduser($data['iduser']);
        
        if($this->db->insert('endereco', [
            'cep'=>$this->endereco->getCep(),
            'rua'=>$this->endereco->getRua(),
            'bairro'=>$this->endereco->getBairro(),
            'cidade'=>$this->endereco->getCidade(),
            'uf'=>$this->endereco->getUf(),
            'iduser'=>$this->endereco->getIduser()
            
        ])){
            return true;
        }
        return false;
    }
    public function updateEndereco($newData, $id){
        if($this->db->update('endereco', $newData, ['id'=>$id])){
            return true;
        }
        return false;
    }
    public function deleteEndereco($id){
        if($this->db->delete('endereco', ['id'=>$id])){
            return true; 
        }
        return false;
        
    }
}