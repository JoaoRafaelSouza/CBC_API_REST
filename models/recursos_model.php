<?php

namespace Models;

class Recursos_Model {
    protected $table = 'clubes';
    protected $primaryKey = 'id';
    public $recurso = 'recurso';
    public $saldo_disponivel = 'recurso';
    
        public function getRecurso()
    {
        return $this->recurso ?? null;
    }

    public function setRecurso($recurso)
    {
        $this->recurso = $recurso;
        return $this;
    }

    public function getSaldoDisponivel()
    {
        return $this->saldo_disponivel ?? null;
    }

    public function setSaldoDisponivel($saldo)
    {
        $this->saldo_disponivel = $saldo;
        return $this;
    }
}