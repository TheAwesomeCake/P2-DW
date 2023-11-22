<?php
require "../vendor/autoload.php";
use App\Controller\UsuarioController;
use App\Controller\VendaController;

$usuarioController = new UsuarioController();
$vendaController = new VendaController();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: * ' );
header('Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-cache, no-store, must-revalidate');

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$httpMethod = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'), true);
$id = isset($_GET['userId']) ? $_GET['userId'] : null;

switch($url) {
    case '/backend/idades':
        switch($httpMethod) {
            case 'GET':
                $idadeList = $usuarioController->getUserIdadeList();
                if (is_array($idadeList)) {
                    echo json_encode(["status"=>true, "idades"=>$idadeList]);
                } else {
                    echo json_encode(["status"=>false]);
                    exit;
                }
            break;
        }
    break;
    case '/backend/VendasPorUsuario':
        switch($httpMethod) {
            case 'GET':
                $vendaList = $vendaController->getVendaListByUser();
                if (is_array($vendaList)) {
                    echo json_encode(["status"=>true, "vendas"=>$vendaList]);
                } else {
                    echo json_encode(["status"=>false]);
                    exit;
                }
            break;
        }
    break;
    case '/backend/login':
        switch($httpMethod) {
            case "POST":
                $resultado = $usuarioController->login($body);
                if(!$resultado['status']){
                    echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message']]);
                    exit;
                }
                echo json_encode(['status' => $resultado['status'], 'message' => $resultado['message'],'token'=>$resultado['token']]);
            break;
            case "GET":
                $headers = getallheaders();
                $token = $headers['authorization'] ?? null;
                $validationResponse = $usuarioController->validarToken($token);
                if ($token === null || !$validationResponse['status']) {
                    echo json_encode($validationResponse);
                    exit;
                }
                echo json_encode($validationResponse);
            break;
        }
    break;
}
?>