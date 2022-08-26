<?php
require_once 'vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig('');

$redirect_uri = 'https://site101.webte.fei.stuba.sk/zadaniadsf/zadanie3/redirect.php';
$client->addScope('email');
$client->addScope('profile');
$client->setRedirectUri($redirect_uri);

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
        <a class="h1 navbar-brand" href="#">Zadanie 3</a>
        <div class="collapse navbar-collapse" >
            <div class="navbar-nav ">
                <a class="nav-link text-light" href="index.php">Login</a>
                <a class="nav-link text-light" href="register.php">Register</a>
            </div>
        </div>
    </div>
</nav>
<div class="container-sm text-center mt-5" style="max-width: 400px">
    <form action="login.php" method="POST">
        <div class="">
            <h3 class=" mb-3">Sign in</h3>
        </div>

        <div  class="form-floating">
            <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="placeholder" required>
            <label for="email" class="form-label">Username</label>
        </div>
        <div  class="form-floating">
            <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="placeholder" required>
            <label for="password" class="form-label">Password</label>
        </div>
        <div class="mt-3">
            <input type="submit" value="Login" class="btn btn-primary">
        </div>
        <div class="mt-3">
            <span><a href='<?php echo $client->createAuthUrl()?>' class="btn btn-primary">Google Login</a></span>
        </div>
        <div class="mt-3">
            <span>Don´t have an account? <a href="register.php" class="btn btn-secondary ">Create account</a></span>
            <br>
        </div>
    </form>



</div>





</body>
</html>