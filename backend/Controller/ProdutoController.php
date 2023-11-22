<?php

namespace App\Controller;

use App\Model\Model;

class ProdutoController {

    private $db;

    public function __construct() {
        $this->db = new Model();
    }
    public function getProdutoList(){
        $product = $this->db->select('produto');
        
        return  $product;
    }
    public function getProdutoById($id){
        $product = $this->db->select('produto',['id'=>$id]);
        
        return  $product;
    }
    public function createProduto($data){
        if($this->db->insert('produto', $data)){
            return true;
        }
        return false;
    }
    public function updateProduto($newData, $id) {
        if($this->db->update('produto', $newData, ['id'=>$id])){
            return true;
        }
        return false;
    }
    public function deleteProduto($id){
        if($this->db->delete('produto', ['id'=>$id])){
            return true;
        }
        return false;
        
    }
}
