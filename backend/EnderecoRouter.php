<?php

require "../vendor/autoload.php";

use App\Controller\EnderecoController;

$enderecoController = new EnderecoController();

$body = json_decode(file_get_contents('php://input'), true);
$id = isset($_GET['id']) ? $_GET['id'] : null;
$userId = isset($_GET['userId']) ? $_GET['userId'] : null;
switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $resultado = $enderecoController->createEndereco($body);
        echo json_encode(['status'=>$resultado]);
    break;
    case "GET":
        if ($id){
            $resultado = $enderecoController->getEnderecoById($id);
            if ($resultado) {
                echo json_encode(["status"=>true,"endereco"=>$resultado[0]]);
            } else {
                echo json_encode(["status"=>false]);
            }
        } else if ($userId) {
            $resultado = $enderecoController->getEnderecoListByUserId($userId);
            echo json_encode(["enderecos"=>$resultado]);
        } else {
            $resultado = $enderecoController->getEnderecoList();
            echo json_encode(["enderecos"=>$resultado]); 
        }
    break;
    case "PUT":
        $resultado = $enderecoController->updateEndereco($body, $id);
        echo json_encode(['status'=>$resultado]);
    break;
    case "DELETE":
        $resultado = $enderecoController->deleteEndereco($id);
        echo json_encode(['status'=>$resultado]);
    break;  
}