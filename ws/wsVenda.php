<?php
include "../inc/funcoes.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"):

    if (!isset($_POST["cliente"]) || !isset($_POST["pagamento"]) || !isset($_POST["valor_total"]) || !isset($_POST["produtos"]) || empty($_POST["produtos"])):
        $response = ['success' => false, 'mensagem' => 'Campos obrigatórios da venda não foram enviados ou estão vazios'];
    else:
        $cliente = $_POST["cliente"];
        $pagamento = $_POST["pagamento"];
        $parcelas = isset($_POST["parcelas"]) ? intval($_POST["parcelas"]) : 1;
        $produtos = $_POST["produtos"];

        $con = conexao();
        $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
        $id_empresa = $token["id_empresa"];
        $data_venda = date('Y-m-d H:i:s');
        $erro = false;

        foreach ($produtos as $codigo_barras => $dados) {
            $quantidade = intval($dados['quantidade']);
            if ($quantidade > 0) {
                if (!adicionarVenda($con, $cliente, $id_empresa, $codigo_barras, $quantidade, $pagamento, $parcelas, $data_venda)) {
                    $erro = true;
                    break;
                }
                if (!vendaProduto($con, $id_empresa, $codigo_barras, $quantidade)) {
                    $erro = true;
                    break;
                }

            }
        }
        if ($erro) {
            $response = ['success' => false, 'mensagem' => 'Erro ao registrar a venda'];
        } else {
            $response = ['success' => true, 'mensagem' => 'Venda realizada com sucesso!'];
        }
    endif;

    header("Content-Type: application/json");
    echo json_encode($response);
endif;
