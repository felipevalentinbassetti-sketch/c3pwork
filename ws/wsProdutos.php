<?php
include "../inc/funcoes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"):

  if (!(isset ($_POST["nome"]) || ($_POST["preco_v"]) || ($_POST["preco_c"]) || ($_POST["codigo_barras"]) || ($_POST["quantidade"]) || ($_POST["qtd_min"]) || ($_POST["descricao"]))):
    $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
  else:

    $nome = $_POST["nome"];
    $preco_v = $_POST["preco_v"];
    $preco_c = $_POST["preco_c"];
    $codigo_barras = $_POST["codigo_barras"];
    $quantidade = $_POST["quantidade"];
    $qtd_min = $_POST["qtd_min"];
    $descricao = $_POST["descricao"];
    $situacao = 1;
    $con = conexao();
    $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
    $usuario = buscarEmpresaPorID($con, $token["id_empresa"]);
    $id_empresa = $token["id_empresa"];

    $verifcodigo = verificaCodigo($con, $codigo_barras, $id_empresa);
    
    if($verifcodigo == false){
      $response = ['success'=> false, 'mensagem'=> 'Codigo de barras ja cadastrado!'];
    }else{
    if(empty ($nome) || empty ($preco_v) || empty ($preco_c) || empty ($codigo_barras) || empty ($quantidade) || empty ($qtd_min) || empty ($descricao)):
      $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
    else:
        if(adicionarProduto($con, $nome, $preco_v, $preco_c, $codigo_barras, $quantidade, $qtd_min, $descricao, $situacao, $id_empresa)){
          $response = ['success'=> true, 'mensagem' => 'Produto cadastrado com sucesso'];
        }
        else{
          $response = ['success'=> false, 'mensagem' => 'Erro com banco de dados'];
        }
      endif;
    }
    endif;
  endif;
  header("Content-Type: application/json");
  echo json_encode($response);
