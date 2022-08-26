<?php
header('Content-Type: application/json; cahrset=utf-8');
$data = json_decode(file_get_contents('php://input'), true);

require_once 'MyPdo.php';
//    require_once 'Word.php';
//    require_once 'Translation.php';

if (isset($data)) {

    try{
        //separatny script
        $myPdo = new MyPDO('mysql:host=localhost;dbname=zadanie2','xkovacika1','NpbYgx2Su7VcfM6');

        $stmt = $myPdo->prepare(
            'delete from words where id =:id'
        );
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->execute();

        $result = ['deleted' => true, 'message' => 'Deleted successfully'];
        echo json_encode($result);

    }catch (PDOException $e){
        $result = ['deleted' => false, 'message' => "Error: ".$e->getMessage()];
        echo json_encode($result);
    }
}

