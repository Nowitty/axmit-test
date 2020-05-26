<?php
declare(strict_types=1);

namespace App;

class Database
{
    private $pdo;
    public $table;

    public function __construct()
    {
        $this->pdo = Connection::make();
    }

    public function __set($name, $value) 
    {
        $this->$name = $value;
    }

    public function insert($params)
    {
        $pdo = $this->pdo;
        $columns = implode(', ', array_keys($params));
        $values = implode(', ', array_map(function ($item) use ($pdo) {
            return $pdo->quote($item);
        }, array_values($params)));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    public function selectAll()
    {
        return $this->pdo->query("SELECT * FROM {$this->table} ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function selectBy($column, $value)
    {
        return $this->pdo->query("SELECT * FROM {$this->table} WHERE {$column}='{$value}'")->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}