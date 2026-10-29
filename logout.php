<?php
include "inc/funcoes.php";
$con = conexao();
$token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
removeToken($con, $token["token"], $token["id_empresa"]);

setcookie("token", $_COOKIE["token"], time()-1, "/");
header("Location:empresa.html");
exit();
?>