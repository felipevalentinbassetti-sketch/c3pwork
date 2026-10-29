<?php
include "../inc/funcoes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (
        empty($_POST["nome"]) ||
        empty($_POST["email"]) ||
        empty($_POST["numero_c"]) ||
        empty($_POST["cep"])
    ) {
        $response = ['success' => false, 'mensagem' => 'Todos os campos são obrigatórios'];
    } else {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $numero_c = $_POST["numero_c"];
        if (empty($_POST["numero_t"])){
            $numero_t = 0;
        }else{
            $numero_t = $_POST["numero_t"];
        }
        $cep = $_POST["cep"];

        $con = conexao();
        $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
        $id_empresa = $token["id_empresa"];

        if(verificaEmailCliente($con, $email, $id_empresa)){
            $response = ['success' => true, 'mensagem' => 'Email não cadastrado ainda'];
        if (adicionarCliente($con, $nome, $email, $numero_c, $numero_t, $cep, $id_empresa)) {
            $response = ['success' => true, 'mensagem' => 'Cliente cadastrado com sucesso'];
        } else {
            $response = ['success' => false, 'mensagem' => 'Erro ao cadastrar no banco de dados'];
        }
        }else{
            $response = ['success' => false, 'mensagem' => 'Email já cadastrado'];
        }
    }
} else {
    $response = ['success' => false, 'mensagem' => 'Método inválido'];
}

header("Content-Type: application/json");
echo json_encode($response);
