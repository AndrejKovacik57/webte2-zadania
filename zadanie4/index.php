<?php
require_once 'eat.php';
require_once 'fiitFood.php';
require_once 'delikanti.php';
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Zadanie 4</title>
</head>
<body>

<div class="container-sm text-center mt-5">

    <div class=" btn-group" role="group">
        <button class="btn btn-primary" value="0">Pondelok</button>
        <button class="btn btn-primary" value="1">Utorok</button>
        <button class="btn btn-primary " value="2">Streda</button>
        <button class="btn btn-primary " value="3">Stvrtok</button>
        <button class="btn btn-primary " value="4">Piatok</button>
        <button class="btn btn-primary " value="5">Sobota</button>
        <button class="btn btn-primary " value="6">Nedela</button>
    </div>

    <div class="row mt-5">
        <h1 id="menu-day" class="text-start text-primary"></h1>
        <ul id="obedove-menu" class="list-unstyled "></ul>
    </div>

</div>
<script src="javascript.js"></script>
</body>
</html>
