<script>
  document.addEventListener("DOMContentLoaded", function () {
    const msg = localStorage.getItem("sucesso");
    if (msg) {
      alert(msg);
      localStorage.removeItem("sucesso");
    }
  });
</script>

<?php 
    include "inc/funcoes.php";
    include_once "inc/checkprodutos.php";
    $con = conexao();
    $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
    $id_empresa = $token["id_empresa"];
    $a=listarProdutos($con, $id_empresa);
	$info=buscarEmpresaPorID($con, $id_empresa);

	//var_dump($data);
    //print_r($a);
    //echo $a[0]["nome"];
    ?>

<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Produtos</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="bootstrap/assetsP/css/main.css" />
		<noscript><link rel="stylesheet" href="bootstrap/assetsP/css/noscript.css" /></noscript>
	</head>

	<?php if (!empty($situacao)){ ?>
    <script>
        alert("Produtos com estoque crítico: <?= implode(', ', array_map('addslashes', $situacao)) ?>");
    </script>
	<?php }?>

	<body class="is-preload">

    <?php include_once "inc/sidebar.php"; ?>


		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">

				<!-- Intro -->
					<div id="intro">
						<h1>Aba de<br />
						Produtos</h1>
						<p>Esta é a seção de <strong>Produtos</strong>, onde serão exibidos os itens disponíveis para visualização e compra.<br />

						<ul class="actions">
							<li><a href="#header" class="button icon solid solo fa-arrow-down scrolly">Continue</a></li>
						</ul>
					</div>

				<!-- Header -->
					<header id="header">
						<a href="produtos.php" class="logo">Produtos</a>
					</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="links">
							<li class="active"><a href="index.html">Produtos em estoque</a></li>
							<li><a href="generic(nUsado).html">Produtos vazios</a></li>
							<!--<li><a href="elements.html">Elements Reference</a></li>-->
						</ul>
						<!--<ul class="icons">
							<li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
						</ul>-->
					</nav>

				<!-- Main -->
					<div id="main">

						<!-- Featured Post -->
							<article class="post featured">
								<header class="major">
									<span class="date"><?php echo $info['data_cadastro']; ?></span>
									<h2><a href="#"><?php echo $info['nome']; ?></a></h2>
									<!-- <p>Aenean ornare velit lacus varius enim ullamcorper proin aliquam<br />
									facilisis ante sed etiam magna interdum congue. Lorem ipsum dolor<br />
									amet nullam sed etiam veroeros.</p> -->
								</header>
								<!-- <a href="#" class="image main"><img src="images/pic01.jpg" alt="" /></a>
								<ul class="actions special">
									<li><a href="#" class="button large">Full Story</a></li>
								</ul> -->
							</article>

						<!-- Posts -->
							<?php
								echo "<section class='posts'>";
								for ($i = 0; $i < count($a); $i++) {
									echo "
									<article>
										<header>
											<h2><a href='atualizarProduto.php?codigo=". $a[$i]['codigo_barras'] ."'>". $a[$i]['nome'] ."</a></h2>
										</header>
										<a href='#' class='image fit'><img src='bootstrap/images/pic01.jpg' alt='Imagem do ". $a[$i]['nome'] ."' /></a>
										<p>
											<strong>Preço de Venda:</strong> R$ ". number_format($a[$i]['preco_v'], 2, ',', '.') ."
											<strong>Preço de Custo:</strong> R$ ". number_format($a[$i]['preco_c'], 2, ',', '.') ."<br />
											<strong>Código de Barras:</strong> ". $a[$i]['codigo_barras'] ."<br />
											<strong>Quantidade:</strong> ". $a[$i]['quantidade'] ."<br />
											<strong>Descrição:</strong> ". $a[$i]['descricao'] ."<br />
											<!--<strong>Situação:</strong> ". $a[$i]['situacao'] ."-->
										</p>
										<ul class='actions special'>
											<li><a href='atualizarProduto.php?codigo=". $a[$i]['codigo_barras'] ."#atualizar' class='button'>Atualizar</a></li>
										</ul>
									</article>
									";
								}
								echo "</section>";
							?>

						<!-- Footer -->
							<footer>
								<div class="pagination">
									<!--<a href="#" class="previous">Prev</a>-->
									<a href="#" class="page active">1</a>
									<a href="#" class="page">2</a>
									<a href="#" class="page">3</a>
									<span class="extra">&hellip;</span>
									<a href="#" class="page">8</a>
									<a href="#" class="page">9</a>
									<a href="#" class="page">10</a>
									<a href="#" class="next">Next</a>
								</div>
							</footer>

					</div>

				<!-- Footer -->
					<!-- <footer id="footer">
						<section>
							<form method="post" action="#">
								<div class="fields">
									<div class="field">
										<label for="name">Name</label>
										<input type="text" name="name" id="name" />
									</div>
									<div class="field">
										<label for="email">Email</label>
										<input type="text" name="email" id="email" />
									</div>
									<div class="field">
										<label for="message">Message</label>
										<textarea name="message" id="message" rows="3"></textarea>
									</div>
								</div>
								<ul class="actions">
									<li><input type="submit" value="Send Message" /></li>
								</ul>
							</form>
						</section>
						<section class="split contact">
							<section class="alt">
								<h3>Address</h3>
								<p>1234 Somewhere Road #87257<br />
								Nashville, TN 00000-0000</p>
							</section>
							<section>
								<h3>Phone</h3>
								<p><a href="#">(000) 000-0000</a></p>
							</section>
							<section>
								<h3>Email</h3>
								<p><a href="#">info@untitled.tld</a></p>
							</section>
							<section>
								<h3>Social</h3>
								<ul class="icons alt">
									<li><a href="#" class="icon brands alt fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon brands alt fa-facebook-f"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon brands alt fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
								</ul>
							</section>
						</section>
					</footer> -->

				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; C3PWork</li><li>Design: <a href="https://html5up.net">HTML5 UP</a></li></ul>
					</div>

			</div>

		<!-- Scripts -->
			<script src="bootstrap/assetsP/js/jquery.min.js"></script>
			<script src="bootstrap/assetsP/js/jquery.scrollex.min.js"></script>
			<script src="bootstrap/assetsP/js/jquery.scrolly.min.js"></script>
			<script src="bootstrap/assetsP/js/browser.min.js"></script>
			<script src="bootstrap/assetsP/js/breakpoints.min.js"></script>
			<script src="bootstrap/assetsP/js/util.js"></script>
			<script src="bootstrap/assetsP/js/main.js"></script>

	</body>
</html>