<?php
declare(strict_types=1);

namespace App;

class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::make();
    }

    public function insert($params, $table)
    {
        $pdo = $this->pdo;
        $columns = implode(', ', array_keys($params));
        $values = implode(', ', array_map(function ($item) use ($pdo) {
            return $pdo->quote($item);
        }, array_values($params)));
        $sql = "INSERT INTO {$table} ($columns) VALUES ($values)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public function selectAll($table)
    {
        return $this->pdo->query("SELECT * FROM {$table} ORDER BY id DESC")->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function selectBy($column, $value, $table)
    {
        return $this->pdo->query("SELECT * FROM {$table} WHERE {$column}='{$value}'")->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}