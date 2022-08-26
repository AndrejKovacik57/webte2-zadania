<?php

header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        /* @var $conn */
        require_once 'config.php';
        $stmt = $conn->prepare('SELECT lat,lon FROM pristupy GROUP BY lat,lon');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        echo json_encode($result);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}