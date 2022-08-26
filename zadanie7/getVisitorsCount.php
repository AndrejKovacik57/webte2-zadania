<?php
header('Content-type: application/json; charset=utf-8');
if (isset($_GET['maxHodina']) && isset($_GET['minHodina'])) {

    try {
        /* @var $conn */
        require_once 'config.php';

        $stmt = $conn->prepare('SELECT COUNT(*) FROM(SELECT location FROM pristupy WHERE HOUR(local_time) BETWEEN :minHour AND :maxHour GROUP BY location)t');
        $stmt->bindParam(':maxHour', $_GET['maxHodina']);
        $stmt->bindParam(':minHour', $_GET['minHodina']);
        $stmt->execute();
        $result = $stmt->fetch();
        echo $result[0];

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

