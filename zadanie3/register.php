<?php

if(isset($_POST['name'])){
    try{
        /* @var $conn*/
        require_once 'config.php';

        $stmt = $conn->prepare('INSERT INTO users (name, email)
            VALUES (:name, :email)');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->execute();

        $user_id = $conn->lastInsertId();
        $stmt = $conn->prepare("INSERT INTO accounts (user_id, type, password) 
            VALUES (".$user_id.", 'classic', :password)");
        $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->execute();
        $account_id = $conn->lastInsertId();

        session_start();
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['account_id'] = $account_id;
        header('Location: 2fa.php');

    }catch (PDOException $e){
        echo $e->getMessage();
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
    <form action="register.php" method="POST">
        <div class="">
            <h3 class=" mb-3">Register</h3>
        </div>

        <div  class="form-floating">
            <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="placeholder" required>
            <label for="name" class="form-label">Name</label>
        </div  class="form-floating">

        <div  class="form-floating">
            <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="placeholder" required>
            <label for="email" class="form-label">Email</label>
        </div>
        <div  class="form-floating">
            <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="placeholder" required>
            <label for="password" class="form-label">Password</label>
        </div>
        <div class="mt-3">
            <input type="submit"  class="btn btn-primary" value="Register">
        </div>
        <div class="mt-3">
            <span>Already have an account? <a href="index.php" class="btn btn-secondary ">Log in</a></span>
        </div>
    </form>

</div>

</body>
</html>