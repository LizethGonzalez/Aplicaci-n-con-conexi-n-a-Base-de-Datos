<?php

namespace model;

class Database {
    private static $conn;

    // Evitamos que se instancie la clase
    private function __construct() {}

    public static function getConnection() {
        if (self::$conn === null) {
            self::$conn = new \mysqli("127.0.0.1", "root", "MariaDb123", "evaluacion", 3306);
            if (self::$conn->connect_error) {
                throw new \Exception("Error de conexión: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
