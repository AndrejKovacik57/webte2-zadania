<?php
require_once "MyPDO.php";

class Inventor
{
    /* @var MyPDO */
    protected MyPDO $db;

    protected int $id;
    protected string $name;
    protected string $surname;
    protected DateTime $birth_date;
    protected string $birth_place;
    protected DateTime $death_date;
    protected string $death_place;
    protected string $description;

    public function __construct()
    {
        $this->db = MyPDO::instance();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getBirthDate(): DateTime
    {
        return $this->birth_date;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate(string $birth_date): void
    {
        $this->birth_date = DateTime::createFromFormat('Y-m-d', $birth_date);
    }

    /**
     * @return string
     */
    public function getBirthPlace(): string
    {
        return $this->birth_place;
    }

    /**
     * @param string $birth_place
     */
    public function setBirthPlace(string $birth_place): void
    {
        $this->birth_place = $birth_place;
    }

    /**
     * @return string
     */
    public function getDeathDate(): DateTime
    {
        return $this->death_date;
    }

    /**
     * @param string $death_date
     */
    public function setDeathDate(string $death_date): void
    {
        $this->death_date = DateTime::createFromFormat('Y-m-d', $death_date);
    }

    /**
     * @return string
     */
    public function getDeathPlace(): string
    {
        return $this->death_place;
    }

    /**
     * @param string $death_place
     */
    public function setDeathPlace(string $death_place): void
    {
        $this->death_place = $death_place;
    }



    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }




    public function save()
    {
        $this->db->run("INSERT into inventors 
            (`name`, `surname`, `birth_date`, `birth_place`, `death_date`, `death_place`, `description`) values (?, ?, ?, ?, ?, ?, ?)",
            [$this->name, $this->surname, $this->birth_date->format('Y-m-d'), $this->birth_place, isset($this->death_date) ? $this->death_date->format('Y-m-d') : null, isset($this->death_place) ? $this->death_place : null, $this->description]);
        $this->id = $this->db->lastInsertId();
    }

    public  function  toArray(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'surname' => $this->surname, 'description' => $this->description, 'birth_date' => $this->birth_date->format('Y-m-d'), 'birth_place' => $this->birth_place,'death_date' =>  isset($this->death_date) ? $this->death_date->format('Y-m-d') : null, 'death_place' => isset($this->death_place) ? $this->death_place : null];
    }

}