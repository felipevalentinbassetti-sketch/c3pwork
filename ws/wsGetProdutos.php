<?php

include "../inc/funcoes.php";
$response = null;
$conexao = conectar();
$data = listarProdutos($conexao);

if($data){
    $response = ['success'=> true, 'dados' => $data];
}
else{
    $response = ['success'=> false, 'mensagem' => 'Problemas com  Banco de Dados'];
}
header("Content-Type: application/json");
echo json_encode($response);