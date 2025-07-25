<?php

namespace Models;

class Clube_Model
{
    protected $table = 'clubes';
    protected $primaryKey = 'id';

    private $id;
    private $clube;
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

    // Clube
    public function getClube()
    {
        return $this->clube ?? null;
    }

    public function setClube($clube)
    {
        $this->clube = $clube;
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