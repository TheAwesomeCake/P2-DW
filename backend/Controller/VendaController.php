<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\Venda;

class VendaController {

    private $db;
    private $venda;
    public function __construct() {
        $this->db = new Model();
        $this->venda = new Venda();
    }
    public function getVendaList(){
        $vendaList = $this->db->select('venda');
        
        return  $vendaList;
    }
    public function getVendaListByUser() {
        $vendaList = $this->db->select('VendasPorUsuario');

        return $vendaList;
    }
    public function getVendaListByUserId($userId) {
        $vendaList = $this->db->select('venda', ['id_usuario'=>$userId]);
        
        return $vendaList;
    }
    public function getVendaListByProdutoId($produtoId) {
        $vendaList = $this->db->select('venda', ['id_produto'=>$produtoId]);
        
        return $vendaList;
    }
    public function getVendaById($id){
        $venda = $this->db->select('venda',['id'=>$id]);
        
        return  $venda;
    }
    public function createVenda($data){
        if($this->db->insert('venda', $data)){
            return true;
        }
        return false;
    }
    public function updateVenda($newData, $id) {
        if($this->db->update('venda', $newData, ['id'=>$id])){
            return true;
        }
        return false;
    }
    public function deleteVenda($id){
        if($this->db->delete('venda', ['id'=>$id])){
            return true;
        }
        return false;
        
    }
}
