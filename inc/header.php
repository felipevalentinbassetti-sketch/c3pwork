
<?php 
include_once "funcoes.php";

$con = conexao();

if(isset($_COOKIE["token"])){
  $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
  $user = buscarEmpresaPorID($con, $token["id_empresa"]);
  
  include "navlogad.php";
  
}
else{
  include "navdeslogado.php";
}



?>