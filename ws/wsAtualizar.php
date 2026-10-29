<?php
include "../inc/funcoes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"):

  if (empty($_POST["preco_v"]) || empty($_POST["preco_c"]) || empty($_POST["codigo_barras"]) || empty($_POST["quantidade"])):
    $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
  else:
    $preco_v = $_POST["preco_v"];
    $preco_c = $_POST["preco_c"];
    $codigo_barras = $_POST["codigo_barras"];
    $quantidade = $_POST["quantidade"];
    $con = conexao();
    $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);

    if (!$token):
      $response = ['success'=> false, 'mensagem'=> 'Token inválido'];
    else:
      $id_empresa = $token["id_empresa"];

      if (atualizarProduto($con, $preco_v, $preco_c, $codigo_barras, $quantidade, $id_empresa)):
        $response = ['success'=> true, 'mensagem' => 'Produto atualizado com sucesso'];
      else:
        $response = ['success'=> false, 'mensagem' => 'Erro ao atualizar produto no banco de dados'];
      endif;

    endif;

    mysqli_close($con);
  endif;

endif;

header("Content-Type: application/json");
echo json_encode($response);
