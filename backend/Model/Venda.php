<?php
namespace App\Model;
class Venda {
    private $id;
    private $data_registro;
    private $id_usuario;
    private $id_produto;

    public function __construct() {
      
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDataRegistro() {
        return $this->data_registro;
    }
    public function setDataRegistro($data_registro) {
        $this->data_registro = $data_registro;
    }
    public function getIdUsuario() {
        return $this->id_usuario;
    }
    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    public function setIdProduto($id_produto) {
        $this->id_produto = $id_produto;
    }
    public function getIdProduto() {
        return $this->id_produto;
    }
}
