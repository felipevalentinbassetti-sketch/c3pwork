 <?php 
include_once "funcoes.php";
$con = conexao();
$token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
$usuario = buscarEmpresaPorID($con, $token["id_empresa"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/css.css">
    <link rel="stylesheet" href="./assets/css/nav.css">
    <title>Index</title>
</head>
<nav>
<div>
    <h1>Seja bem vindo <?= $usuario["nome"]?></h1>
    <a href="logout.php">Sair da conta</a><br>
    <a href="adicionarProduto.php#produto">add prod</a><br>
    <a href="produtos.php">Vizualizar produtos</a><br>
    <a href="adicionarCliente.php#cliente">add cliente</a><br>
    <a href="venda.php#venda">Vender</a>
</div>
</nav>