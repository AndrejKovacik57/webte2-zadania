<?php
require_once 'PHPGangsta/GoogleAuthenticator.php';
session_start();
/* @var $conn*/
require_once 'config.php';

$stmt = $conn->prepare("select secret from accounts where id =  :id");
$stmt->bindParam(':id', $_SESSION['account_id']);
$stmt->execute();
$secret = $stmt->fetch();

$ga = new PHPGangsta_GoogleAuthenticator();

if (isset($_POST['code'])){

    $checkResult = $ga->verifyCode($secret['secret'], $_POST['code']);
    if ($checkResult) {

        $stmt = $conn->prepare("INSERT INTO logins (account_id, type)
            VALUES (:account_id, 'classic')");
        $stmt->bindParam(':account_id', $_SESSION['account_id'], PDO::PARAM_INT);
        $stmt->execute();

        header('Location: dashboard.php');
    } else {
        echo 'FAILED';
    }
}
?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.css">
    <title>zadanie3</title>
</head>
<body>
<div class="container-sm text-center mt-5" style="max-width: 400px">
    <form action="check.php" method="POST">
        <div class="">
            <h3 class=" mb-3">Google Authentication</h3>
        </div>
        <div class="form-floating">
            <input type="number" name="code" class="form-control form-control-lg" id="code" placeholder="12345" required>
            <label for="code" class="form-label">code</label>
        </div>
        <div class="mt-3">
            <input type="submit" class="btn btn-primary" value="Authenticate">
        </div>
        <div class="mt-3">
            <a href="logout.php" class="btn btn-secondary ">Logout</a>
        </div>
    </form>
</div>

</body>
</html>
