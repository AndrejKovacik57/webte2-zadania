<?php
require_once 'Inventor.php';
require_once 'Api.php';
header('Content-Type: application/json; charset=utf-8');
//if(isset($_POST['_method']))
//    if (strcmp($_POST['_method'], 'PUT') == 0){
//        $_SERVER['REQUEST_METHOD']='PUT';
//    }
if(isset($_GET['_method']))
    if (strcmp($_GET['_method'], 'DELETE') == 0){
        $_SERVER['REQUEST_METHOD']='DELETE';
    }
//echo '<pre>';
switch ($_SERVER['REQUEST_METHOD']) {

    case "POST":
//        header("HTTP/1.1 201 OK");
        $data = json_decode(file_get_contents('php://input'), true);
        if($data['description'] && $data['invention_description']){
            echo json_encode(Api::createInventor($data));
        }else if(!$data['description'] && $data['invention_description']){
            echo json_encode(Api::createInvention($data));
        }else if ($_POST['description'] && $_POST['invention_description']){
            echo json_encode(Api::createInventor($_POST));
        }else if(!$_POST['description'] && $_POST['invention_description']){
            echo json_encode(Api::createInvention($_POST));
        }
        break;

    case "DELETE":
        $id = $_GET['id'];
        echo json_encode(Api::deleteById($id));

        break;
    case "GET":
//        header("HTTP/1.1 200 OK");
        $id = $_GET['id'];
        $surname = $_GET['surname'];
        $century = $_GET['century'];
        $year = $_GET['year'];
        if($id){
            echo json_encode(Api::findWithInventions($id));
        }
        else if($surname){
            echo json_encode(Api::searchBySurnname($surname));
        }else if($century){
            echo json_encode(Api::searchByCentury($century));
        }else if($year){
            echo json_encode(Api::whatHappendInAYear($year));
        }
        else {
            echo json_encode(Api::getAll());
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data){
            echo json_encode(Api::updateInventor($data));
        }else if($_POST['description']){
            echo json_encode(Api::updateInventor($_POST));
        }

        break;

}

//echo '</pre>';