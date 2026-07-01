<?php

declare(strict_types=1);

namespace src\geometria;

class Nota
{
    private string $nome = '';
    private float $nota1 = 0;
    private float $nota2 = 0;

    public function __construct(){}

    public function calcularMedia(): float
    {
        return ($this->nota1 + $this->nota2) / 2;
    }

    public function determinarSituacao(): string
    {
        $media = $this->calcularMedia();
        
        if ($media < 3) {
            return "reprovado";
        }
        if ($media >= 3 && $media < 6) {
            return "recuperacao";
        }
        return "aprovado";
    }

    public function setNome(string $novoNome): void
    {
        $this->nome = $novoNome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNota1(float $novaNota1): void
    {
        if ($novaNota1 < 0 || $novaNota1 > 10) {
            throw new \InvalidArgumentException("Digite uma nota válida entre 0 e 10.");
        }
        else if (!is_numeric($novaNota1)){
            throw new \InvalidArgumentException("Digite uma nota válida.");
        }
        $this->nota1 = $novaNota1;
    }

    public function getNota1(): float
    {
        return $this->nota1;
    }

    public function setNota2(float $novaNota2): void
    {
        if ($novaNota2 < 0 || $novaNota2 > 10) {
            throw new \InvalidArgumentException("Digite uma nota válida entre 0 e 10.");
        }
        else if (!is_numeric($novaNota2)){
            throw new \InvalidArgumentException("Digite uma nota válida.");
        }
        $this->nota2 = $novaNota2;
    }

    public function getNota2(): float
    {
        return $this->nota2;
    }
}