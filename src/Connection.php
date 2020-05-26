<?php
declare(strict_types=1);

namespace App;

class Connection
{
    private static $pdo = null;

    public static function make()
    {
        if ( self::$pdo === null ) {
            $db = parse_url(getenv('DATABASE_URL'));
            self::$pdo = new \PDO(sprintf(
            'pgsql:host=%s;port=%s;user=%s;password=%s;dbname=%s',
            $db['host'],
            $db['port'],
            $db['user'],
            $db['pass'],
            ltrim($db['path'], '/')
            ));
        }

        return self::$pdo;
        $db = parse_url(getenv('DATABASE_URL'));
        // $pdo = new \PDO('pgsql:host=localhost;dbname=ruslankuga');
        // return $pdo;
        //$this->pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    }
}