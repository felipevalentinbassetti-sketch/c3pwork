<?php
include "../inc/funcoes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"):

  if (!(isset ($_POST["nome"]) || ($_POST["razao_social"]) || ($_POST["cnpj"]) || ($_POST["senha"]) || ($_POST["data_cadastro"]))):
    $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
  else:
    $nome = $_POST["nome"];
    $razao_social = $_POST["razao_social"];
    $cnpj = $_POST["cnpj"];
    $senha = $_POST["senha"];
    $data_cadastro = $_POST["data_cadastro"];

    $con = conexao();
    $verifcnpj = verificaCnpj($con, $cnpj);

    if($verifcnpj == false){
      $response = ['success'=> false, 'mensagem'=> 'CNPJ já foi cadastrado'];
    }else{
    $dados = [$nome, $razao_social, $cnpj, $senha, $data_cadastro];
    if(empty ($nome) || empty ($razao_social) || empty ($cnpj) || empty ($senha) || empty ($data_cadastro) ):
      $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
    else:
        $teste = adicionarEmpresa($con, $nome, $razao_social, $cnpj, $senha, $data_cadastro);
        $dados[] = $teste;
        if($teste){
          $response = ['success'=> true, 'mensagem' => 'Produto cadastrado com sucesso'];
        }
        else{
          $response = ['success'=> false, 'mensagem' => 'Erro com banco de dados', 'dados' => $dados];
        }
      endif;
    }
    endif;
  endif;
  header("Content-Type: application/json");
  echo json_encode($response);
