<?php
header('Content-Type: application/json; charset=utf-8');
if($_SERVER['REQUEST_METHOD'] == "GET") {
    try{
        /* @var $conn*/
        require_once 'config.php';
        $stmt = $conn->prepare('SELECT country, country_code FROM pristupy WHERE local_time BETWEEN CURDATE() AND CURDATE() + INTERVAL 1 DAY GROUP BY country, country_code');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        echo json_encode($result);

    }catch (PDOException $e){
        echo "Error: ".$e->getMessage();
    }
}