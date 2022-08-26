<?php
    header('Content-type: application/json; charset=utf-8');
    require_once 'MyPdo.php';
//    require_once 'Word.php';
//    require_once 'Translation.php';

    if (isset($_GET['search'])) {
        if (strlen($_GET['search']) >= 3){
            try{
                /* @var $myPdo*/
                require_once 'config.php';
                if(isset($_GET['popis'])){
                    $stmt = $myPdo->prepare('select  
                                                t1.title as searchTitle, 
                                                t1.description as searchDescription,
                                                t2.title as translatedTitle, 
                                                t2.description as translatedDescription,
                                                t1.word_id
                                        from translations t1 
                                        join translations t2 
                                            on t1.word_id = t2.word_id
                                        join languages 
                                            on t1.language_id = languages.id 
                                        where
                                            languages.code = :language 
                                          and
                                            (t1.title like :search or t1.description like :search2)
                                            and t1.id <> t2.id'
                    );
                    $search = $_GET['search'].'%';
                    $stmt->bindParam(':search', $search);
                    $stmt->bindParam(':search2', $search);
                }else{
                    $stmt = $myPdo->prepare('select  
                                                t1.title as searchTitle, 
                                                t1.description as searchDescription,
                                                t2.title as translatedTitle, 
                                                t2.description as translatedDescription,
                                                t1.word_id
                                        from translations t1 
                                        join translations t2 
                                            on t1.word_id = t2.word_id
                                        join languages 
                                            on t1.language_id = languages.id 
                                        where
                                            languages.code = :language 
                                          and
                                            t1.title like :search
                                            and t1.id <> t2.id'
                    );
                    $search = $_GET['search'].'%';
                    $stmt->bindParam(':search', $search);
                }
                $stmt->bindParam(':language', $_GET['language_code']);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetchAll();
                echo json_encode($result);


            }catch (PDOException $e){
                echo "Error: ".$e->getMessage();
            }
        }
        }


