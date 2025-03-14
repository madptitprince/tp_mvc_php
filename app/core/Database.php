<?php
// app/core/Database.php

class Database
{
    private static $host = 'localhost';
    private static $db_name = 'mvc_db_tp';
    private static $username = 'root'; // Remplacez par votre utilisateur
    private static $password = 'muxa2002'; // Remplacez par votre mot de passe
    private static $conn = null;

    // Méthode statique pour établir la connexion à la base de données
    public static function getConnection()
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                die("Erreur de connexion à la base de données : " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}

