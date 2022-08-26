<?php
require_once 'MyPdo.php';
require_once  'Word.php';
require_once  'Translation.php';

/* @var $myPdo*/
require_once 'config.php';
//    $slovo = new Word($myPdo);
//    $slovo->findById(1);
//    var_dump($slovo);

if (isset($_POST['add_term']))
{
    echo 'po';
    $pole = explode(";", $_POST['add_term']);

    if($pole[0]){
        $word = new Word($myPdo);
        $word->setTitle($pole[0]);
        $word->save();

        $slovakTranslation = new Translation($myPdo);
        $slovakTranslation->setTitle($pole[0]);
        $slovakTranslation->setDescription($pole[1]);
        $slovakTranslation->setLanguageId(3);
        $slovakTranslation->setWordId($word->getId());
        $slovakTranslation->save();

        $englishTranslation = new Translation($myPdo);
        $englishTranslation->setTitle($pole[2]);
        $englishTranslation->setDescription($pole[3]);
        $englishTranslation->setLanguageId(1);
        $englishTranslation->setWordId($word->getId());
        $englishTranslation->save();
    }



}
header("Location: admin.php");

