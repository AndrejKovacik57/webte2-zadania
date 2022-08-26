<?php
require_once 'MyPdo.php';
require_once  'Word.php';
require_once  'Translation.php';

/* @var $myPdo*/
require_once 'config.php';

//    $slovo = new Word($myPdo);
//    $slovo->findById(1);
//    var_dump($slovo);

if (isset($_POST['word-id-update']))
{
    try{
        $pole = explode(";", $_POST['term-update']);


        if($pole[0]){
            $myPdo = new MyPDO('mysql:host=localhost;dbname=zadanie2','xkovacika1','NpbYgx2Su7VcfM6');

            $stmt1 = $myPdo->prepare("update translations set title = :EN_pojem, description = :vysvetlenie_EN_pojmu where word_id = :wordid and language_id = 3;");
            $stmt2 = $myPdo->prepare("update translations set title = :SK_pojem, description = :vysvetlenie_SK_pojmu where word_id = :wordid and language_id = 1;");
            $stmt3 = $myPdo->prepare("update words set title = :EN_pojem where id = :wordid");

            $stmt1->bindParam(':EN_pojem', $pole[0]);
            $stmt1->bindParam(':vysvetlenie_EN_pojmu', $pole[1]);
            $stmt1->bindParam(':wordid', $_POST['word-id-update'], PDO::PARAM_INT);

            $stmt2->bindParam(':SK_pojem', $pole[2]);
            $stmt2->bindParam(':vysvetlenie_SK_pojmu', $pole[3]);
            $stmt2->bindParam(':wordid', $_POST['word-id-update'], PDO::PARAM_INT);

            $stmt3->bindParam(':EN_pojem', $pole[0]);
            $stmt3->bindParam(':wordid', $_POST['word-id-update'], PDO::PARAM_INT);

            $stmt1->execute();
            $stmt2->execute();
            $stmt3->execute();
        }
    }catch (PDOException $e){
        echo "Error: ".$e->getMessage();
    }



}
header("Location: admin.php");

