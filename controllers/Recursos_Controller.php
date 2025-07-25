<?php

namespace Controllers;

use Models\Recursos_Model;
use Models\Clube_Model;
use Daos\Helpers;

class Recursos_Controller
{
    public function consumir($dados)
    {
        if (!isset($dados['clube_id'], $dados['recurso_id'], $dados['valor_consumo'])) {
            http_response_code(400);
            echo json_encode(["erro" => "Dados obrigatórios não fornecidos."]);
            return;
        }

        $dao = new Helpers();

        // Buscar clube
        $clubeInfo = $dao->Listar("clubes", "*", "id = {$dados['clube_id']} AND ativado = 1", "");
        if (empty($clubeInfo)) {
            http_response_code(404);
            echo json_encode(["erro" => "Clube não encontrado."]);
            return;
        }

        // Buscar recurso
        $recursoInfo = $dao->Listar("recursos", "*", "id = {$dados['recurso_id']} AND ativado = 1", "");
        if (empty($recursoInfo)) {
            http_response_code(404);
            echo json_encode(["erro" => "Recurso não encontrado."]);
            return;
        }

        $clube = (new Clube_Model())
            ->setId($clubeInfo[0]['id'])
            ->setClube($clubeInfo[0]['clube'])
            ->setSaldoDisponivel($clubeInfo[0]['saldo_disponivel'])
            ->setAtivado($clubeInfo[0]['ativado']);

        $recurso = (new Recursos_Model())
            ->setId($recursoInfo[0]['id'])
            ->setRecurso($recursoInfo[0]['recurso'])
            ->setSaldoDisponivel($recursoInfo[0]['saldo_disponivel'])
            ->setAtivado($recursoInfo[0]['ativado']);

        $valor = floatval($dados['valor_consumo']);

        // Verificar saldos
        if ($clube->getSaldoDisponivel() < $valor || $recurso->getSaldoDisponivel() < $valor) {
            http_response_code(400);
            echo json_encode(["erro" => "Saldo insuficiente no clube ou no recurso."]);
            return;
        }

        // Atualizar saldos
        $novoSaldoClube = $clube->getSaldoDisponivel() - $valor;
        $novoSaldoRecurso = $recurso->getSaldoDisponivel() - $valor;

        $dao->Editar("clubes", "", "saldo_disponivel = {$novoSaldoClube}", "id = {$clube->getId()}");
        $dao->Editar("recursos", "", "saldo_disponivel = {$novoSaldoRecurso}", "id = {$recurso->getId()}");

        echo json_encode([
            "clube" => $clube->getClube(),
            "saldo_anterior" => $clube->getSaldoDisponivel(),
            "saldo_atual" => $novoSaldoClube
        ]);
    }

    public function cadastrar($dados)
    {

        // Verifica se os dados estão sendo enviados direito
        if (!isset($dados['recurso']) || !isset($dados['saldo_disponivel'])) {
            http_response_code(400);
            echo json_encode(["erro" => "Campos obrigatórios ausentes."]);
            return;
        }

        // Verifica se saldo é negativo
        if (floatval($dados['saldo_disponivel']) < 0) {
            http_response_code(400);
            echo json_encode(["erro" => "Saldo não pode ser negativo."]);
            return;
        }

        // Aqui estou usando a Recursos_Model.php
        $recursos = new Recursos_Model();
        $recursos->setRecurso($dados['recurso']);
        $recursos->setSaldoDisponivel($dados['saldo_disponivel']);
        $recursos->setAtivado(1);

        // Aqui eu estou utilizando o método da minha Helpers.php
        $dao = new Helpers();
        $campos = "recurso, saldo_disponivel, ativado";
        $valores = "'{$recursos->getRecurso()}', '{$recursos->getSaldoDisponivel()}', {$recursos->isAtivado()}";

        // Aqui tenho o include
        $resultado = $dao->Incluir("recursos", $campos, $valores);
        echo json_encode(["mensagem" => $resultado]);
    }

    public function listar()
    {
        $dao = new Helpers();
        $dados = $dao->Listar("recursos", "*", "ativado = 1", "id");

        $recursos = [];
        foreach ($dados as $linha) {
            $recurso = new Recursos_Model();
            $recurso->setId($linha['id'])
                ->setRecurso($linha['recurso'])
                ->setSaldoDisponivel($linha['saldo_disponivel'])
                ->setAtivado($linha['ativado']);
            $recursos[] = [
                "id" => $recurso->getId(),
                "recurso" => $recurso->getRecurso(),
                "saldo_disponivel" => $recurso->getSaldoDisponivel()
            ];
        }

        echo json_encode($recursos);
    }
}