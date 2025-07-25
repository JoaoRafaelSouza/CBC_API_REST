<?php

namespace Models;

class Recursos_Model {
    protected $table = 'recursos';
    protected $primaryKey = 'id';

    private $id;
    private $recurso;
    private $saldo_disponivel;
    private $ativado;

    // ID
    public function getId()
    {
        return $this->id ?? null;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    // Recurso
    public function getRecurso()
    {
        return $this->recurso ?? null;
    }

    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;
        return $this;
    }

    // Saldo Disponível
    public function getSaldoDisponivel()
    {
        return $this->saldo_disponivel ?? null;
    }

    public function setSaldoDisponivel($saldo)
    {
        $this->saldo_disponivel = $saldo;
        return $this;
    }

    // Ativado
    public function isAtivado()
    {
        return $this->ativado ?? null;
    }

    public function setAtivado($ativo)
    {
        $this->ativado = $ativo;
        return $this;
    }
}