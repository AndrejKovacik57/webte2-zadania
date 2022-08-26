<?php

require_once 'vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig('client_secret_295350296865-prf5sua5o77npph4su2a6bokt09i55m6.apps.googleusercontent.com.json');

if(isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;
    $gogle_id = $google_account_info->getId();

    try{
        /* @var $conn*/
        require_once 'config.php';

        $stmt = $conn->prepare("SELECT * FROM users where email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        $stmt = $conn->prepare("SELECT * FROM accounts where google_id = :google_id");
        $stmt->bindParam(':google_id', $gogle_id);
        $stmt->execute();
        $user = $stmt->fetch();

        //kontrola ci je email pouzity ak nie tak registrujem
        if(!isset($existingUser['id'])){
            $stmt = $conn->prepare('INSERT INTO users (name, email)
            VALUES (:name, :email)');
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->execute();

            $user_id = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO accounts (user_id, type, google_id) 
            VALUES (".$user_id.", 'google','".$gogle_id."' )");
            $stmt->execute();

            $account_id = $conn->lastInsertId();
            $stmt = $conn->prepare("INSERT INTO logins (account_id, type)
                VALUES (:account_id, 'google')");
            $stmt->bindParam(':account_id', $account_id, PDO::PARAM_INT);
            $stmt->execute();
            session_start();
            $_SESSION['name'] = $name;
            $_SESSION['account_id'] =  $account_id;
            header('Location: dashboard.php');
        }
        //ak je emal uz pouzivany (klasicke) vytvorim druhy ucet typu google
        elseif(isset($existingUser['id']) and !isset($user['google_id'])){

            $stmt = $conn->prepare("INSERT INTO accounts (user_id, type, google_id) 
        VALUES (".$existingUser['id'].", 'google','".$gogle_id."' )");
            $stmt->execute();
            $user_id = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO logins (account_id, type)
            VALUES (:account_id, 'google')");
            $stmt->bindParam(':account_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            session_start();
            $_SESSION['name'] = $name;
            $_SESSION['account_id'] =  $user_id;
            header('Location: dashboard.php');
        }
        //kontrola ci tento user id v tabulke accountov ak je robim len prihlasenie
        elseif (isset($user['google_id'])){
            $stmt = $conn->prepare("INSERT INTO logins (account_id, type)
            VALUES (:account_id, 'google')");
            $stmt->bindParam(':account_id', $user['id'], PDO::PARAM_INT);
            $stmt->execute();
            session_start();
            $_SESSION['name'] = $name;
            $_SESSION['account_id'] =  $user['id'];
            header('Location: dashboard.php');
        }

    }catch (PDOException $e){
        echo $e->getMessage();
    }


}

