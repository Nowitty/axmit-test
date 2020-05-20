<?php
declare(strict_types=1);

namespace App;

class Database
{
    private $pdo;
    private $table;
    public function __construct($table)
    {
        $db['host'] = 'ec2-35-171-31-33.compute-1.amazonaws.com';
        $db['user'] = 'zdbtebkvfyplfe';
        $db['port'] = '5432';
        $db['pass'] = '043de618653034288655120d843beae5d169edb4c41aae052d177e5ad4783cda';
        $db['name'] = 'd91vcn4speqqg2';
        $this->pdo = new \PDO(sprintf(
            'pgsql:host=%s;port=%s;user=%s;password=%s;dbname=%s',
            $db['host'],
            $db['port'],
            $db['user'],
            $db['pass'],
            $db['name']
        ));
        $this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $this->table = $table;
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