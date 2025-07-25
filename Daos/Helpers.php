<?php

namespace Daos;
use Exception;
use PDO;
use Config\Conexao;

class Helpers
{
    private $conexao;

    public function __construct()
    {
        $con = new Conexao();
        $this->conexao = $con->conectar();
    }

    public function Listar($tabela, $colunas = '*', $where = '', $ordem = '')
    {
        $query = "SELECT {$colunas} FROM {$tabela}";
        
        if(!empty($where))
            $query .= " WHERE {$where}";
        if(!empty($ordem))
            $query .= " ORDER BY {$ordem} ASC;";

        try {
            $stmt = $this->conexao->prepare($query);
            if ($stmt->execute())
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ["erro" => $e->getMessage()];
        }
    }

    public function Incluir($tabela, $campos, $resultados)
    {
        $query = "INSERT INTO {$tabela} ({$campos}) VALUES ({$resultados});";

        try {
            $stmt = $this->conexao->prepare($query);
            if ($stmt->execute())
                return 'Incluído';
        } catch (Exception $e) {
            return ["erro" => $e->getMessage()];
        }
    }

    public function Editar($tabela, $campos, $resultados, $where)
    {
        $query = "UPDATE {$tabela} SET {$resultados} WHERE {$where};";
        try {
            $stmt = $this->conexao->prepare($query);
            if ($stmt->execute())
                return 'Editado';
        } catch (Exception $e) {
            return ["erro" => $e->getMessage()];
        }
    }
    public function Deletar($tabela, $where)
    {
        $query = "DELETE FROM {$tabela} WHERE {$where};";
        try {
            $stmt = $this->conexao->prepare($query);
            if ($stmt->execute())
                return 'Excluído';
        } catch (Exception $e) {
            return ["erro" => $e->getMessage()];
        }
    }
}