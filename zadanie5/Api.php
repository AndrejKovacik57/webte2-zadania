<?php
require_once "MyPDO.php";
require_once "Inventor.php";
require_once "Invention.php";
class api
{

    public static function getAll() {

        return MyPDO::instance()->run("SELECT * FROM inventors ")->fetchAll();
    }


    public static function findWithInventions($id)
    {
        $inventorData = MyPDO::instance()->run("SELECT * FROM inventors WHERE id = ?", [$id])->fetch();
        $inventionsData = MyPDO::instance()->run("SELECT inventions.description, inventions.invention_year FROM inventors JOIN inventions ON inventors.id = inventions.inventor_id where inventors.id = ?", [$id])->fetchAll();
        if (!$inventorData) {
            return false;
        }

        return ['inventor' => $inventorData, 'inventions' => $inventionsData];
    }
    public static function searchBySurnname($surname)
    {
        $data = MyPDO::instance()->run("SELECT * FROM inventors WHERE surname = ?", [$surname])->fetch();
        if (!$data) {
            return false;
        }
        return $data;
    }

    public static function searchByCentury($century){
        $century -=1;
        $data = MyPDO::instance()->run("SELECT description,invention_year FROM inventions where invention_year LIKE ?", ["$century%"])->fetchAll();
        if (!$data) {
            return false;
        }
        return $data;
    }

    public static function whatHappendInAYear($year)
    {
        $bornInAYear = MyPDO::instance()->run("SELECT `name`, surname FROM inventors where YEAR(birth_date) = ?", [$year])->fetchAll();
        $diedInAYear = MyPDO::instance()->run("SELECT `name`, surname FROM inventors where YEAR(death_date) = ?", [$year])->fetchAll();
        $inventionInAYear = MyPDO::instance()->run("SELECT description FROM inventions where invention_year = ?", [$year])->fetchAll();


        return ['bornInAYear' => $bornInAYear, 'diedInAYear' => $diedInAYear, 'inventionInAYear'=>$inventionInAYear];
    }

    public static function createInventor($data)
    {
        $inventor = new Inventor();
        $inventor->setName($data['name']);
        $inventor->setSurname($data['surname']);
        $inventor->setDescription($data['description']);
        $inventor->setBirthDate($data['birth_date']);
        $inventor->setBirthPlace($data['birth_place']);
        if(isset($data['death_date']) && strlen($data['death_date']) > 0)
            $inventor->setDeathDate($data['death_date']);
        if(isset($data['death_place']) && strlen($data['death_place']) > 0)
            $inventor->setDeathPlace($data['death_place']);
        $inventor->save();

        $invention = new Invention();
        $invention->setInventorId($inventor->getId());
        $invention->setDescription($data['invention_description']);
        $invention->setInventionYear($data['invention_year']);
        $invention->save();
        return['inventor'=>$inventor->toArray(), 'invention'=>$invention->toArray()];
    }
    public static function createInvention($data)
    {
        $invention = new Invention();
        $invention->setInventorId($data['inventor_id']);
        $invention->setDescription($data['invention_description']);
        $invention->setInventionYear($data['invention_year']);
        $invention->save();
        return['invention'=>$invention->toArray()];
    }
    public static function updateInventor($data)
    {
        MyPDO::instance()->run("UPDATE inventors SET name=?, surname=?, birth_date=?, birth_place=?, death_date=?, death_place=?, description=? WHERE id = ?"
            ,[$data['name'],$data['surname'],$data['birth_date'],$data['birth_place'],strlen($data['death_date']) > 0 ? $data['death_date'] :null, strlen($data['death_place']) > 0 ? $data['death_place'] :null, $data['description'],$data['id']]);
        $inventorUpdatedData = MyPDO::instance()->run("SELECT * FROM inventors WHERE id = ?", [$data['id']])->fetch();
        return ['updated'=> $inventorUpdatedData];
    }

    public static function deleteById($id)
    {
        MyPDO::instance()->run("delete from inventors where id = ?",
            [$id]);
        return ['message'=>'success'];
    }

}