<?php

class DataBase
{
    // Valores por defecto para XAMPP/WSL (MySQL de Docker publicado en el 3308).
    // En Docker, docker-compose.yml los sustituye con variables de entorno (DB_HOST=mysql-db, DB_PORT=3306...).
    private const DB_HOST = '127.0.0.1';
    private const DB_USER = 'root';
    private const DB_PASS = 'root'; // <-- pon aquí tu contraseña de root
    private const DB_NAME = 'daw2mvc';
    private const DB_PORT = 3308;

    public static function connect(
        $host = null,
        $user = null,
        $pass = null,
        $db = null,
        $port = null
    ) {
        $host = $host ?? (getenv('DB_HOST') ?: self::DB_HOST);
        $user = $user ?? (getenv('DB_USER') ?: self::DB_USER);
        $pass = $pass ?? (getenv('DB_PASS') !== false ? getenv('DB_PASS') : self::DB_PASS);
        $db = $db ?? (getenv('DB_NAME') ?: self::DB_NAME);
        $port = $port ?? (int) (getenv('DB_PORT') ?: self::DB_PORT);

        $con = new mysqli($host, $user, $pass, $db, $port);
        if ($con->connect_error) {
            die("ERROR!!: No te puedes conectar: " . $con->connect_error);
        }

        $con->set_charset("utf8mb4");

        return $con;
    }
}
