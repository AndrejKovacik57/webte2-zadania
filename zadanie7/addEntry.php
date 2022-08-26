<?php
header('Content-Type: application/json; charset=utf-8');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    try{
        /* @var $conn*/
        require_once 'config.php';
        $stmt = $conn->prepare('INSERT INTO pristupy (location, country, country_code, capital, lat, lon, local_time) VALUES (:location, :country, :country_code, :capital, :lat, :lon, :local_time)');
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':country', $data['country']);
        $stmt->bindParam(':country_code', $data['countryCode']);
        $stmt->bindParam(':capital', $data['capital']);
        $stmt->bindParam(':lat', $data['lat']);
        $stmt->bindParam(':lon', $data['lon']);
        $stmt->bindParam(':local_time', $data['localTime']);
        $stmt->execute();

    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

