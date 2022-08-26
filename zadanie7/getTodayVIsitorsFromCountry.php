<?php
header('Content-type: application/json; charset=utf-8');
if (isset($_GET['krajina'])) {
    try {
        /* @var $conn*/
        require_once 'config.php';
        $stmt = $conn->prepare('SELECT COUNT(*) FROM (SELECT location FROM pristupy WHERE country=:country AND local_time >= CURDATE() AND local_time < CURDATE() + INTERVAL 1 DAY GROUP BY location)t');
        $stmt->bindParam(':country', $_GET['krajina']);
        $stmt->execute();
        $result = $stmt->fetch();
        echo $result[0];


    }catch (PDOException $e){
        echo "Error: ".$e->getMessage();
    }
}
