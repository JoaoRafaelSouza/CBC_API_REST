<?php
namespace Config;

use PDO;
use PDOException;

class Conexao {
    public static function conectar() {
        $envPath = __DIR__ . '/../.env.local';
        if (!file_exists($envPath)) {
            die("Arquivo .env.local não encontrado.");
        }

        $env = parse_ini_file($envPath);
        $host = $env['DB_HOST'];
        $dbname = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS'];

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("Erro ao conectar ao banco de dados.");
        }
    }
}