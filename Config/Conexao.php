<?php
namespace Config;

class Conexao {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        // Carrega variáveis do .env
        $env = parse_ini_file(__DIR__ . '/../.env.local');
        $this->host = $env['DB_HOST'];
        $this->dbname = $env['DB_NAME'];
        $this->username = $env['DB_USER'];
        $this->password = $env['DB_PASS'];
    }

    public function conectar()
    {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }
}