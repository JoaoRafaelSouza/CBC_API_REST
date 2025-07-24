<?php

namespace Daos;
use PDO;
use Config\Conexao;

class Helpers{
    private $conexao;

    public function __construct()
    {
        $con = new Conexao();
        $this->conexao = $con->conectar();
    }

    public function Listar($tabela, $colunas, $where){
        $query = "SELECT " . $colunas . " FROM " . $tabela . " where " . $where;
        
        $stmt = $this->conexao->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}