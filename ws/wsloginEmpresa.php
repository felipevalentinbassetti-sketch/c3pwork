<?php
include "../inc/funcoes.php";

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"):

  if (!(isset ($_POST["cnpj"]) || ($_POST["senha"]))):
    $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
  else:
    $cnpj = $_POST["cnpj"];
    $senha = $_POST["senha"];

    if(empty ($cnpj) || empty ($senha) ):
      $response = ['success'=> false, 'mensagem' => 'Os campos não podem estar vazios'];
    endif;
    $con = conexao();
    $empresa = verificaSenha($con, $cnpj, $senha);

        if(!$empresa){
          $msg = "Usuario invalido";
        }
        else{

          $token = gerarToken($con, $empresa);
              
          setcookie("token", $token, time()+(60*60*24), "/");

          $msg = 'sucesso';
          $success = true;

        }
    endif;
    $response = ["success" => $success, 'msg' => $msg];
    header('Content-Type: application/json');
    echo json_encode($response);
  endif;