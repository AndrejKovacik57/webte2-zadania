<?php
require_once 'PHPGangsta/GoogleAuthenticator.php';
session_start();
/* @var $conn*/
require_once 'config.php';


$ga = new PHPGangsta_GoogleAuthenticator();
$secret = $ga->createSecret();
$qrCodeUrl = $ga->getQRCodeGoogleUrl('zadanie3 '. $_SESSION['email'], $secret);

$stmt = $conn->prepare("update accounts set secret = :secret where id = :id");
$stmt->bindParam(':id', $_SESSION['account_id'], PDO::PARAM_INT);
$stmt->bindParam(':secret', $secret);
$stmt->execute();

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
    <div>
        <h3 class=" mb-3">Google Authentication setup</h3>
    </div>
    <div class="mt-3">
        <img src="<?php echo $qrCodeUrl;?>" alt="">
    </div>
    <div class="mt-3">
        <a href="check.php" class="btn btn-primary ">Nascenoval som! <br> prihlas ma</a>
    </div>
</div>

</body>
</html>

