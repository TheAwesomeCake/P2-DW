<?php

require "../vendor/autoload.php";

use App\Controller\ProdutoController;

$produtoController = new ProdutoController();

$body = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id'] : '';
switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $resultado = $produtoController->createProduto($body);
        echo json_encode(['status'=>$resultado]);
    break;
    case "GET":
        if(!$id){
            $resultado = $produtoController->getProdutoList();
            echo json_encode(["produtos"=>$resultado]);
        } else {
            $resultado = $produtoController->getProdutoById($id);
            if ($resultado) {
              echo json_encode(["status"=>true,"produto"=>$resultado[0]]);
            } else {
              echo json_encode(["status"=>false]);
            }
        }
       
    break;
    case "PUT":
        $resultado = $produtoController->updateProduto($body, $id);
        echo json_encode(['status'=>$resultado]);
    break;
    case "DELETE":
        $resultado = $produtoController->deleteProduto($id);
        echo json_encode(['status'=>$resultado]);
    break;  
}