<?php

header('Content-Type: application/json; charset=utf-8');
if (isset($_GET['krajina'])) {
    try {
        /* @var $conn */
        require_once 'config.php';
        $stmt = $conn->prepare('SELECT location FROM pristupy WHERE country=:country AND local_time BETWEEN CURDATE() AND CURDATE() + INTERVAL 1 DAY GROUP BY location');
        $stmt->bindParam(':country', $_GET['krajina']);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        echo json_encode($result);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}