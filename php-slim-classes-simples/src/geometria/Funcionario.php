<?php

declare(strict_types=1);

namespace src\geometria;

class Funcionario
{
    private string $nome = '';
    private float $valorHora = 0;
    private float $valorHoraExtra = 0;
    private float $qtdHoras = 0;
    private float $qtdHorasExtras = 0;

    public function __construct(){}

    public function calcularSalario(): float
    {
        return ($this->qtdHoras * $this->valorHora) + ($this->qtdHorasExtras * $this->valorHoraExtra);
    }

    public function setNome(string $novoNome): void
    {
        $this->nome = $novoNome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setValorHora(float $novoValorHora): void
    {
        if ($novoValorHora <= 0) {
            throw new \InvalidArgumentException("Digite um valor válido.");
        }
        $this->valorHora = $novoValorHora;
    }

    public function getValorHora(): float
    {
        return $this->valorHora;
    }

    public function setValorHoraExtra(float $novoValorHoraExtra): void
    {
        if ($novoValorHoraExtra <= 0) {
            throw new \InvalidArgumentException("Digite um valor válido.");
        }
        $this->valorHoraExtra = $novoValorHoraExtra;
    }

    public function getValorHoraExtra(): float
    {
        return $this->valorHoraExtra;
    }

    public function setQtdHoras(float $novaQtdHoras): void
    {
        if ($novaQtdHoras <= 0) {
            throw new \InvalidArgumentException("Digite uma hora válida.");
        }
        $this->qtdHoras = $novaQtdHoras;
    }

    public function getQtdHoras(): float
    {
        return $this->qtdHoras;
    }

    public function setQtdHorasExtras(float $novaQtdHorasExtras): void
    {
        if ($novaQtdHorasExtras <= 0) {
            throw new \InvalidArgumentException("Digite uma hora válida.");
        }
        $this->qtdHorasExtras = $novaQtdHorasExtras;
    }

    public function getQtdHorasExtras(): float
    {
        return $this->qtdHorasExtras;
    }
}
