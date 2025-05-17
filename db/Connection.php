<?php

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (!self::$instance) {
            self::$instance = new PDO(
                'mysql:host=localhost;dbname=posnet;charset=utf8',
                'root',
                ''
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

    private function __construct() {}  // Previene instanciación directa
    private function __clone() {}
    private function __wakeup() {}
}
