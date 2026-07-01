<?php

declare(strict_types=1);

namespace src\geometria;

class Produto
{
    private string $nome = '';
    private float $preco = 0;
    private float $qtdEstoque = 0;

    public function __construct(){}

    public function calcularValorTotal(): float
    {
        return $this->preco * $this->qtdEstoque;
    }

    public function adicionarEstoque(float $quantidade): void
    {
        if ($quantidade < 0) {
            throw new \InvalidArgumentException("Digite uma quantidade válida.");
        }
        $this->qtdEstoque = $this->qtdEstoque + $quantidade;
    }

    public function removerEstoque(float $quantidade): void
    {
        if ($quantidade < 0) {
            throw new \InvalidArgumentException("Digite uma quantidade válida.");
        }
        if ($quantidade > $this->qtdEstoque) {
            throw new \InvalidArgumentException("Quantidade maior que o estoque.");
        }
        $this->qtdEstoque = $this->qtdEstoque - $quantidade;
    }

    public function setNome(string $novoNome): void
    {
        $this->nome = $novoNome;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setPreco(float $novoPreco): void
    {
        if ($novoPreco <= 0) {
            throw new \InvalidArgumentException("Digite um preço válido.");
        }
        $this->preco = $novoPreco;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function setQtdEstoque(float $novaQtdEstoque): void
    {
        if ($novaQtdEstoque < 0) {
            throw new \InvalidArgumentException("Digite uma quantidade válida.");
        }
        $this->qtdEstoque = $novaQtdEstoque;
    }

    public function getQtdEstoque(): float
    {
        return $this->qtdEstoque;
    }
}