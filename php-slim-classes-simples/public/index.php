<?php

require __DIR__ . '/../vendor/autoload.php';



use src\geometria\Pessoa;
use src\geometria\Funcionario;
use src\geometria\Produto;
use src\geometria\Nota;
use src\geometria\Triangulo;

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as ResponseInterface;

$app = AppFactory::create();


 
$app->get(
    '/',
    function (Request $request, Response $response): ResponseInterface {
       $html = file_get_contents(__DIR__ . '/index.html');
        $response->getBody()->write($html);
        return $response;
    }
);

$app->get(
    '/pessoa/imc',
    function (Request $request, Response $response): ResponseInterface{
        $dados = $request->getQueryParams();
          
        $nome = $dados['txtNome'] ?? '';
        $peso = $dados['txtPeso'] ?? 0;
        $altura = $dados['txtAltura'] ?? 0;
    
        $pessoa = new Pessoa();
        $pessoa->setNome($nome);
        $pessoa->setPeso($peso);
        $pessoa->setAltura($altura);

        $imc = $pessoa->calcularIMC();
        $classificacao = $pessoa->classificarIMC();
        
        $resultado = "$nome, seu IMC é: $imc - Classificação: $classificacao";
        $response->getBody()->write($resultado);

        return $response;
    }
);

$app->get(
    '/exercicio2',
    function (Request $request, Response $response): ResponseInterface{
        $dados = $request->getQueryParams();
        $nome = $dados['txtNome'] ?? '';
        $valorHora = $dados['txtValorHora'] ?? 0;
        $valorHoraExtra = $dados['txtValorHoraExtra'] ?? 0;
        $qtdHoras = $dados['txtHora'] ?? 0;
        $qtdHorasExtras = $dados['txtHorasExtras'] ?? 0;

        $funcionario = new Funcionario();
        $funcionario->setNome($nome);
        $funcionario->setValorHora($valorHora);
        $funcionario->setValorHoraExtra($valorHoraExtra);
        $funcionario->setQtdHoras($qtdHoras);
        $funcionario->setQtdHorasExtras($qtdHorasExtras);
        $salarioFinal = $funcionario->calcularSalario();
        $resultado = "O salario de $nome é: R$ $salarioFinal";
        $response->getBody()->write($resultado);

        return $response;
    }
);

$app->get(
    '/produto/calcular',
    function (Request $request, Response $response): ResponseInterface{
        $dados = $request->getQueryParams();
        
        $produtos = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $nome = $dados["txtNome$i"] ?? '';
            $preco = $dados["txtPreco$i"] ?? 0;
            $entrada = $dados["txtEntrada$i"] ?? 0;
            $saida = $dados["txtSaida$i"] ?? 0;
            
            if ($nome != '') {
                $produto = new Produto();
                $produto->setNome($nome);
                $produto->setPreco($preco);
                $produto->adicionarEstoque($entrada);
                $produto->removerEstoque($saida);
                
                $produtos[] = [
                    'nome' => $produto->getNome(),
                    'quantidade' => $produto->getQtdEstoque(),
                    'valorTotal' => $produto->calcularValorTotal()
                ];
            }
        }
        
        $resultado = "<h3>Relatório de Estoque</h3>";
        $resultado .= "<table border='1' cellpadding='10' cellspacing='0'>";
        $resultado .= "<tr><th>Produto</th><th>Quantidade em Estoque</th><th>Valor Total (R$)</th></tr>";
        
        foreach ($produtos as $prod) {
            $resultado .= "<tr>";
            $resultado .= "<td>" . $prod['nome'] . "</td>";
            $resultado .= "<td>" . $prod['quantidade'] . "</td>";
            $resultado .= "<td>R$ " . $prod['valorTotal'] . "</td>";
            $resultado .= "</tr>";
        }
        
        $resultado .= "</table>";
        $response->getBody()->write($resultado);
        
        return $response;
    }
);

$app->get(
    '/nota/calcular',
    function (Request $request, Response $response): ResponseInterface{
        $dados = $request->getQueryParams();
        
        $nome = $dados['txtNome'] ?? '';
        $nota1 = $dados['txtNota1'] ?? 0;
        $nota2 = $dados['txtNota2'] ?? 0;
        
        $nota = new Nota();
        $nota->setNome($nome);
        $nota->setNota1($nota1);
        $nota->setNota2($nota2);
        
        $media = $nota->calcularMedia();
        $situacao = $nota->determinarSituacao();
        
        //$resultado = "Aluno: $nome | Media: $media | Situacao: $situacao";    
       $resultado = "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Resultado Nota</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' />
</head>
<body>
    <nav class='navbar navbar-expand-sm bg-dark navbar-dark'>
        <div class='container-fluid'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='/index.html'>Início</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/formularioPessoa.html'>Calculadora de IMC</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/formularioFuncionario.html'>Calculadora de Funcionario</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/formularioProduto.html'>Calculadora de Produto</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/formularioNota.html'>Calculadora de Nota</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='/formularioTriangulo.html'>Calculadora de Triângulo</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class='container mt-5'>
        <div class='row justify-content-center'>
            <div class='col-md-6'>
                <div class='card shadow p-4'>
                    <h2 class='text-center mb-4'>Resultado da Nota</h2>
                    <p class='text-center'>Nome: $nome</p>
                    <p class='text-center'>Média: $media</p>
                    <p class='text-center'>Situação: $situacao</p>
                </div>
            </div>
        </div>
    </div>
    <br>
</body>
</html>
";
        $response->getBody()->write($resultado);
        
        return $response;
    }
);

$app->get(
    '/triangulo/calcular',
    function (Request $request, Response $response): ResponseInterface{
        $dados = $request->getQueryParams();
        
        $lado1 = $dados['txtLado1'] ?? 0;
        $lado2 = $dados['txtLado2'] ?? 0;
        $lado3 = $dados['txtLado3'] ?? 0;
        
        $triangulo = new Triangulo();
        $triangulo->setLado1($lado1);
        $triangulo->setLado2($lado2);
        $triangulo->setLado3($lado3);
        
        $tipo = $triangulo->determinarTipo();
        $perimetro = $triangulo->calcularPerimetro();
        $area = $triangulo->calcularArea();
        
        $resultado = "Tipo: $tipo | Perimetro: $perimetro | Area: $area";
        $response->getBody()->write($resultado);
        
        return $response;
    }
);

$app->run();
