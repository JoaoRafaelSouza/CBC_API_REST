<?php

namespace Controllers;

use Models\Clube_Model;
use Daos\Helpers;

class Clube_Controller
{
    public function listar()
    {
        $dao = new Helpers();
        $dados = $dao->Listar("clubes", "*", "ativado = 1", "id");

        $clubes = [];
        foreach ($dados as $linha) {
            $clube = new Clube_Model();
            $clube->setId($linha['id'])
                ->setClube($linha['clube'])
                ->setSaldoDisponivel($linha['saldo_disponivel'])
                ->setAtivado($linha['ativado']);
            $clubes[] = [
                "id" => $clube->getId(),
                "clube" => $clube->getClube(),
                "saldo_disponivel" => $clube->getSaldoDisponivel()
            ];
        }

        echo json_encode($clubes);
    }

    public function cadastrar($dados)
    {
        // Verifica se os dados estão sendo enviados direito
        if (!isset($dados['clube']) || !isset($dados['saldo_disponivel'])) {
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

        // Aqui estou usando a Clube_Model.php
        $clube = new Clube_Model();
        $clube->setClube($dados['clube']);
        $clube->setSaldoDisponivel($dados['saldo_disponivel']);
        $clube->setAtivado(1);

        // Aqui eu estou utilizando o método da minha Helpers.php
        $dao = new Helpers();
        $campos = "clube, saldo_disponivel, ativado";
        $valores = "'{$clube->getClube()}', '{$clube->getSaldoDisponivel()}', {$clube->isAtivado()}";

        // Aqui tenho o include
        $resultado = $dao->Incluir("clubes", $campos, $valores);
        echo json_encode(["mensagem" => $resultado]);
    }
}