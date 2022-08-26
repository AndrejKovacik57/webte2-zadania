<?php

if(isset($_POST['email'])){
    try{
        /* @var $conn*/
        require_once 'config.php';

        $stmt = $conn->prepare("select name, password, user_id, accounts.id from users join accounts on users.id = accounts.user_id where email = :email and `type` = 'classic'");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch();

       if(password_verify($_POST['password'], $user['password'])){
            session_start();
            $_SESSION['name'] = $user['name'];
            $_SESSION['account_id'] = $user['id'];
            header('Location: check.php');
        }else{
           header('Location: index.php');
       }

    }catch (PDOException $e){
        echo $e->getMessage();
    }
}

