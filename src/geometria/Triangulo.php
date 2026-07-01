<?php

declare(strict_types=1);

namespace src\geometria;

class Triangulo
{
    private float $lado1 = 0;
    private float $lado2 = 0;
    private float $lado3 = 0;

    public function __construct(){}

    private function validarTriangulo(): bool
    {
        if ($this->lado1 <= 0 || $this->lado2 <= 0 || $this->lado3 <= 0) {
            return false;
        }
        if ($this->lado1 + $this->lado2 <= $this->lado3) {
            return false;
        }
        if ($this->lado1 + $this->lado3 <= $this->lado2) {
            return false;
        }
        if ($this->lado2 + $this->lado3 <= $this->lado1) {
            return false;
        }
        return true;
    }

    public function determinarTipo(): string
    {
        if (!$this->validarTriangulo()) {
            return "invalido";
        }
        
        if ($this->lado1 == $this->lado2 && $this->lado2 == $this->lado3) {
            return "equilatero";
        }
        if ($this->lado1 == $this->lado2 || $this->lado1 == $this->lado3 || $this->lado2 == $this->lado3) {
            return "isosceles";
        }
        return "escaleno";
    }

    public function calcularPerimetro(): float
    {
        return $this->lado1 + $this->lado2 + $this->lado3;
    }

    public function calcularArea(): float
    {
        $p = $this->calcularPerimetro() / 2;
        $area = sqrt($p * ($p - $this->lado1) * ($p - $this->lado2) * ($p - $this->lado3));
        return $area;
    }

    public function setLado1(float $novoLado1): void
    {
        if ($novoLado1 <= 0) {
            throw new \InvalidArgumentException("Digite um lado válido.");
        }
        $this->lado1 = $novoLado1;
    }

    public function getLado1(): float
    {
        return $this->lado1;
    }

    public function setLado2(float $novoLado2): void
    {
        if ($novoLado2 <= 0) {
            throw new \InvalidArgumentException("Digite um lado válido.");
        }
        $this->lado2 = $novoLado2;
    }

    public function getLado2(): float
    {
        return $this->lado2;
    }

    public function setLado3(float $novoLado3): void
    {
        if ($novoLado3 <= 0) {
            throw new \InvalidArgumentException("Digite um lado válido.");
        }
        $this->lado3 = $novoLado3;
    }

    public function getLado3(): float
    {
        return $this->lado3;
    }
}