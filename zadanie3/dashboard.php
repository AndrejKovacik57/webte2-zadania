<?php
session_start();
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
    <h3 class=" mb-3">You are logged in! <br> Welcome: <?php echo $_SESSION['name']; ?></h3>
</div>

</body>
</html>
