<?php 
    include "inc/checklogin.php";
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
                        <article id="produto">
                            <div class="container" id="form-container">
                                <h2>Produto</h2>
                                <form id="formProduto" method="post" >
                                    <label for="nome">Nome do produto:</label><br>
                                    <input type="text" id="nome" name="nome" maxlength="50" placeholder="Nome" required><br><br>

                                    <label for="preco_v">Preço de venda:</label><br>
                                    <input type="number" id="preco_v" name="preco_v" placeholder="Preço Venda" required><br><br>

                                    <label for="preco_c">Preço de custo:</label><br>
                                    <input type="number" id="preco_c" name="preco_c" placeholder="Preço Custo" required><br><br>

                                    <label for="codigo_barras">Código de barras:</label><br>
                                    <input type="number" id="codigo_barras" name="codigo_barras" maxlength="47" placeholder="Codigo Barras" required><br><br>
                                    <div id="erro"></div>
                                    
                                    <label for="quantidade">Quantidade:</label><br>
                                    <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade" required><br><br>
                                    
                                    <label for="qtd_min">Quantidade minina:</label><br>
                                    <input type="number" id="qtd_min" name="qtd_min" placeholder="Quantidade Minina" required><br><br>
                                    
                                    <label for="descricao">Descrição:</label><br>
                                    <input type="text" id="descricao" name="descricao" maxlength="100" placeholder="Descrição" required><br><br>

                                    <button value="submit">Enviar</button>
                                </form>

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

            <script src="assets/scripts/script_produtos.js"></script>


	</body>
</html>
