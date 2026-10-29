 <?php 
include_once "funcoes.php";
$con = conexao();
$token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
$usuario = buscarEmpresaPorID($con, $token["id_empresa"]);

?>

<head>
    <link rel="stylesheet" href="bootstrap/assetsN/css/main.css" />
</head>

<!-- Sidebar -->
			<section id="sidebar">
				<div class="inner">
					<nav>
						<ul>
							<li><a href="index.php">Bem vindo <?php echo $usuario["nome"];?></a></li>
                            <li><a href="adicionarProduto.php#produto">add prod</a></li>
                            <li><a href="produtos.php">Vizualizar produtos</a></li>
                            <li><a href="adicionarCliente.php#cliente">add cliente</a></li>
                            <li><a href="venda.php#venda">Vender</a></li>
                            <li><a href="logout.php">Sair da conta</a></li>
						</ul>
					</nav>
				</div>
			</section>