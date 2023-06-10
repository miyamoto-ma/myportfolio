<?php

class Database
{
    private static $instance;

    // データベースに接続する準備
    public static function getPDOInstance()
    {
        try {
            if (!isset(self::$instance)) {
                self::$instance = new PDO(
                    DSN,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            }
            return self::$instance;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }
}
