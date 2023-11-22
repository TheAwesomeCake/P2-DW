<?php

require "../vendor/autoload.php";

use App\Controller\VendaController;

$vendaController = new VendaController();

$body = json_decode(file_get_contents('php://input'), true);
$id = isset($_GET['id']) ? $_GET['id'] : null;
$userId = isset($_GET['userId']) ? $_GET['userId'] : null;
$produtoId = isset($_GET['produtoId']) ? $_GET['produtoId'] : null;
switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $resultado = $vendaController->createVenda($body);
        echo json_encode(['status'=>$resultado]);
    break;
    case "GET":
        if ($id){
            $resultado = $vendaController->getVendaById($id);
            if ($resultado) {
                echo json_encode(["status"=>true,"venda"=>$resultado[0]]);
            } else {
                echo json_encode(["status"=>false]);
            }
        } else if ($userId) {
            $resultado = $vendaController->getVendaListByUserId($userId);
            echo json_encode(["vendas"=>$resultado]);
        } else if ($produtoId) {
            $resultado = $vendaController->getVendaListByProdutoId($produtoId);
            echo json_encode(["vendas"=>$resultado]);
        } else {
            $resultado = $vendaController->getVendaList();
            echo json_encode(["vendas"=>$resultado]); 
        }
    break;
    case "PUT":
        $resultado = $vendaController->updateVenda($body, $id);
        echo json_encode(['status'=>$resultado]);
    break;
    case "DELETE":
        $resultado = $vendaController->deleteVenda($id);
        echo json_encode(['status'=>$resultado]);
    break;  
}