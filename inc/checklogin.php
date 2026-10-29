<?php 
    include_once"funcoes.php";
if(!isset($_COOKIE["token"])){
    header("Location:index.php");
  }
  else{
    $con = conexao();
    $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
    $user = buscarEmpresaPorID($con, $token["id_empresa"]);

    if(!$user){
        header("Location:index.php");
    }
  }
?>