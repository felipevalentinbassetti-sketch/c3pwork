<?php
    include "inc/checklogin.php";

    if (!isset($_GET['codigo'])) {
        die("Código de barras não informado.");
    }

    $codigo = $_GET['codigo'];
    //echo "$codigo";

    $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
    $id_empresa = $token["id_empresa"];
    $p = pesquisarProdutos($con, $id_empresa, $codigo);

    //var_dump ($p);
?>
<!DOCTYPE HTML>
<!--
	Dimension by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Adicionar produto</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="bootstrap/assetsF/css/main.css" />
		<noscript><link rel="stylesheet" href="bootstrap/assetsF/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

    <?php include_once "inc/sidebar.php"; ?>


			<div id="wrapper">

            <!-- Main -->
                <div id="main">

                    <!-- add produto -->
                        <article id="atualizar">
                            <div class="container" id="form-container">
                                <?php
                                echo "<h2>".$p[0]['nome']."</h2>";
                                echo "
                                <form id='formProduto' method='post' >
                                    <label for='preco_v'>Preço de venda:</label><br>
                                    <input type='number' id='preco_v' name='preco_v' min='0' value='".$p[0]['preco_v']."' required><br><br>

                                    <label for='preco_c'>Preço de custo:</label><br>
                                    <input type='number' id='preco_c' name='preco_c' min='0' value='" . $p[0]['preco_c'] . "' required><br><br>

                                    <label for='codigo_barras'>Código de barras:</label><br>
                                    <input type='number' id='codigo_barras' name='codigo_barras' value='".$p[0]['codigo_barras']."' readonly><br><br>
                                    
                                    <label for='quantidade'>Quantidade:</label><br>
                                    <input type='number' id='quantidade' name='quantidade' min='0' value='".$p[0]['quantidade']."' required><br><br>

                                    <button value='submit'>Enviar</button>
                                </form>";
                                ?>

                                <a href="index.php">Voltar</a>
                            </div>
                        </article>

                </div>

            <!-- Footer -->
                <footer id="footer">
                    <p class="copyright">&copy; C3PWork <a href="https://html5up.net">HTML5 UP</a>.</p>
                </footer>

        </div>

		<!-- BG -->
			<div id="bg"></div>

		<!-- Scripts -->
			<script src="bootstrap/assetsF/js/jquery.min.js"></script>
			<script src="bootstrap/assetsF/js/browser.min.js"></script>
			<script src="bootstrap/assetsF/js/breakpoints.min.js"></script>
			<script src="bootstrap/assetsF/js/util.js"></script>
			<script src="bootstrap/assetsF/js/main.js"></script>

            <script src="assets/scripts/script_atualizar.js"></script>

	</body>
</html>
