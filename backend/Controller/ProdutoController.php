<?php

namespace App\Controller;

use App\Model\Model;

class ProdutoController {

    private $db;

    public function __construct() {
        $this->db = new Model();
    }
    public function getProdutoList(){
        $product = $this->db->select('produtos');
        
        return  $product;
    }
    public function getProdutoById($id){
        $product = $this->db->select('produtos',['id'=>$id]);
        
        return  $product;
    }
    public function createProduto($data){
        if($this->db->insert('produtos', $data)){
            return true;
        }
        return false;
    }
    public function updateProduto($newData, $id) {
        if($this->db->update('produtos', $newData, ['id'=>$id])){
            return true;
        }
        return false;
    }
    public function deleteProduto($id){
        if($this->db->delete('produtos', ['id'=>$id])){
            return true;
        }
        return false;
        
    }
}
