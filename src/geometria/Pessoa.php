<?php

declare(strict_types=1);

namespace src\geometria;

class Pessoa
{
   
    private float $peso = 0;
    private float $altura = 0;
    private string $nome = '';

    public function __construct(){}

    public function calcularIMC(): float
    {
        return $this->peso / ($this->altura * $this->altura);
    }

    public function classificarIMC(): string
    {
        $imc = $this->calcularIMC();
        
        if ($imc < 18.5) {
            return "abaixo do peso";
        }
        if ($imc >= 18.5 && $imc < 25) {
            return "peso normal";
        }
        if ($imc >= 25 && $imc < 30) {
            return "sobrepeso";
        }
        return "obesidade";
    }

    public function setPeso(float $novoPeso): void
    {
        if ($novoPeso <= 0) {
            throw new \InvalidArgumentException("Digite um peso válido.");
        }
        $this->peso = $novoPeso;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function setAltura(float $novaAltura): void
    {
        if ($novaAltura <= 0) {
            throw new \InvalidArgumentException("Digite uma altura válida.");
        }
        $this->altura = $novaAltura;
    }

    public function getAltura(): float
    {
        return $this->altura;
    }

    public function setNome(string $novoNome): void
    {
        $this->nome = $novoNome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }
       
}
