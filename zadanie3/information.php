<?php
session_start();
/* @var $conn*/
require_once 'config.php';

$stmt = $conn->prepare("select count(account_id) as login_counter from logins where account_id = :account_id");
$stmt->bindParam(':account_id', $_SESSION['account_id']);
$stmt->execute();
$userLoginNum = $stmt->fetch();

$stmt = $conn->prepare("select type from accounts where id = :id");
$stmt->bindParam(':id', $_SESSION['account_id']);
$stmt->execute();
$userType = $stmt->fetch();

$stmt = $conn->prepare("select count(account_id) as login_counter from logins where type = 'classic'");
$stmt->execute();
$classicLoginsAll = $stmt->fetch();

$stmt = $conn->prepare("select count(account_id) as login_counter from logins where type = 'google'");
$stmt->execute();
$googleLoginsAll = $stmt->fetch();

?>
<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bootstrap.css">
    <title>Zadanie3</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
    <div class="container-fluid">
        <a class="h1 navbar-brand" href="dashboard.php">Zadanie 3</a>
        <div class="collapse navbar-collapse" >
            <div class="navbar-nav ">
                <a class="nav-link text-light" href="information.php">Information</a>
                <a class="nav-link text-light" href="logout.php">Logout</a>
            </div>
        </div>
        <h5 class="text-center">Logged as "<?php echo $_SESSION['name']; ?>"</h5>
    </div>
</nav>
<div class="container-sm text-center mt-5" style="max-width: 400px">
    <div class="row">
        <h3>User login information</h3>
        <table id="result-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Number of log-ins</th>
                    <th>Account type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $userLoginNum['login_counter'] ?></td>
                    <td><?php echo $userType['type'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-5">
        <h3>All users login information</h3>
        <table id="result-table" class="table table-striped">
            <thead>
            <tr>
                <th>Number of log-ins</th>
                <th>Account type</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $classicLoginsAll['login_counter'] ?></td>
                <td>Classic</td>
            </tr>
            <tr>
                <td><?php echo $googleLoginsAll['login_counter'] ?></td>
                <td>Google</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>

