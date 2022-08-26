<?php
require_once "MyPDO.php";

class Invention
{
    /* @var MyPDO */
    protected MyPDO $db;

    protected int $id;
    protected string $inventor_id;
    protected int $invention_year;
    protected string $description;

    public function __construct()
    {
        $this->db = MyPDO::instance();
    }

    /**
     * @return string
     */
    public function getInventorId(): string
    {
        return $this->inventor_id;
    }

    /**
     * @param string $inventor_id
     */
    public function setInventorId(string $inventor_id): void
    {
        $this->inventor_id = $inventor_id;
    }

    /**
     * @return int
     */
    public function getInventionYear(): int
    {
        return $this->invention_year;
    }

    /**
     * @param int $invention_year
     */
    public function setInventionYear(int $invention_year): void
    {
        $this->invention_year = $invention_year;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    public function save()
    {
        $this->db->run("INSERT into inventions 
            (`inventor_id`, `invention_year`, `description`) values (?, ?, ?)",
            [$this->inventor_id, isset($this->invention_year) ? $this->invention_year : null, $this->description]);
        $this->id = $this->db->lastInsertId();
    }

    public  function  toArray(): array
    {
        return ['id' => $this->id, 'inventor_id' => $this->inventor_id, 'description' => $this->description, 'invention_year' => $this->invention_year];
    }
}