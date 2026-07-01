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

        $response->getBody()->write("
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Resultado</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css'>
</head>
<body>

<div class='container-fluid p-5 bg-primary text-white text-center'>
     <h1>Resultado</h1>
</div>

<div class='container mt-5'>
    <div class='row justify-content-center'>
        <div class='col-md-6'>
            <div class='card shadow p-4 text-center'>
                <h2 class='mb-4'>Cálculo de IMC</h2>
                
                <p><strong>Nome:</strong> $nome</p>
                <p><strong>IMC:</strong> $imc</p>
                <p><strong>Classificação:</strong> $classificacao</p>

                <a href='/formularioPessoa.html' class='btn btn-primary mt-3'>Voltar</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
");

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

        $response->getBody()->write("
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Resultado</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css'>
</head>
<body>

<div class='container-fluid p-5 bg-primary text-white text-center'>
     <h1>Resultado</h1>
</div>

<div class='container mt-5'>
    <div class='row justify-content-center'>
        <div class='col-md-6'>
            <div class='card shadow p-4 text-center'>
                <h2 class='mb-4'>Cálculo de Salário</h2>
                
                <p><strong>Funcionário:</strong> $nome</p>
                <p><strong>Salário Final:</strong> R$ $salarioFinal</p>

                <a href='/formularioFuncionario.html' class='btn btn-primary mt-3'>Voltar</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
");

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

        $linhas = "";
        foreach ($produtos as $prod) {
            $linhas .= "
            <tr>
                <td>{$prod['nome']}</td>
                <td>{$prod['quantidade']}</td>
                <td>R$ {$prod['valorTotal']}</td>
            </tr>
            ";
        }

        $response->getBody()->write("
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Resultado</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css'>
</head>
<body>

<div class='container-fluid p-5 bg-primary text-white text-center'>
     <h1>Resultado</h1>
</div>

<div class='container mt-5'>
    <div class='row justify-content-center'>
        <div class='col-md-8'>
            <div class='card shadow p-4 text-center'>
                <h2 class='mb-4'>Relatório de Estoque</h2>
                
                <table class='table table-bordered table-striped'>
                    <thead class='table-dark'>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Total (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        $linhas
                    </tbody>
                </table>

                <a href='/formularioProduto.html' class='btn btn-primary mt-3'>Voltar</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
");

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
        $response->getBody()->write("
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Resultado</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css'>
</head>
<body>
<div class='container-fluid p-5 bg-primary text-white text-center'>
     <h1>Resultado</h1>
</div>

<div class='container mt-5'>
    <div class='row justify-content-center'>
        <div class='col-md-6'>
            <div class='card shadow p-4 text-center'>
                <h2 class='mb-4'>Nota:</h2>
                
                <p><strong>Aluno:</strong> $nome</p>
                <p><strong>Média:</strong> $media</p>
                <p><strong>Situação:</strong> $situacao</p>

                <a href='/formularioNota.html' class='btn btn-primary mt-3'>Voltar</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
");
        
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
        if ($tipo == "invalido") {
            $area = "Não disponível";
        } else {
            $area = $triangulo->calcularArea();
        }

        $response->getBody()->write("
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <title>Resultado</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css'>
</head>
<body>

<div class='container-fluid p-5 bg-primary text-white text-center'>
     <h1>Resultado</h1>
</div>

<div class='container mt-5'>
    <div class='row justify-content-center'>
        <div class='col-md-6'>
            <div class='card shadow p-4 text-center'>
                <h2 class='mb-4'>Cálculo de Triângulo</h2>
                
                <p><strong>Lado 1:</strong> $lado1</p>
                <p><strong>Lado 2:</strong> $lado2</p>
                <p><strong>Lado 3:</strong> $lado3</p>
                <p><strong>Tipo:</strong> $tipo</p>
                <p><strong>Perímetro:</strong> $perimetro</p>
                <p><strong>Área:</strong> $area</p>

                <a href='/formularioTriangulo.html' class='btn btn-primary mt-3'>Voltar</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
");

        return $response;
    }
);

$app->run();
