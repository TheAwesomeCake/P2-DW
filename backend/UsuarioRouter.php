<?php

require "../vendor/autoload.php";

use App\Controller\UsuarioController;

$usuarioController = new UsuarioController();

$body = json_decode(file_get_contents('php://input'), true);
$id=isset($_GET['id'])?$_GET['id']:'';
switch($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        $resultado = $usuarioController->createUser($body);
        echo json_encode(['status'=>$resultado]);
    break;
    case "GET":
        if (!$id){
            $resultado = $usuarioController->getUserList();
            echo json_encode(["usuarios"=>$resultado]);
        } else {
            $resultado = $usuarioController->getUserById($id);
            if ($resultado == true) {
                echo json_encode(["status"=>true,"usuario"=>$resultado[0]]);
            } else {
                echo json_encode(["status"=>false]);
            }
        }   
    break;
    case "PUT":
        $resultado = $usuarioController->updateUser($body, $id);
        echo json_encode(['status'=>$resultado]);
    break;
    case "DELETE":
        $resultado = $usuarioController->deleteUser($id);
        echo json_encode(['status'=>$resultado]);
    break;  
}