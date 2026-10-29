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
		<title>Adicionar cliente</title>
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
                        <article id="cliente">
                            <div class="container" id="form-container">
                                <h2>Cliente</h2>
                                <form id="formCliente" method="post" >
                                    <label for="nome">Nome do cliente:</label><br>
                                    <input type="text" id="nome" name="nome" maxlength="50" placeholder="Nome" required><br><br>

                                    <label for="email">Email:</label><br>
                                    <input type="text" id="email" name="email" placeholder="E-mail" required><br><br>
                                    <div id="erro"></div>

                                    <label for="numero_c">Número celular:</label><br>
                                    <input type="number" id="numero_c" name="numero_c" placeholder="Celular" required><br><br>

                                    <label for="numero_t">Número telefone:</label><br>
                                    <input type="number" id="numero_t" name="numero_t" placeholder="Telefone"><br><br>
                                    
                                    
                                    <label for="cep">CEP:</label><br>
                                    <input type="number" id="cep" name="cep" placeholder="Ex: 14804-039" required><br><br><!--colocar api de cep-->
                                    
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

            <script src="assets/scripts/script_clientes.js"></script>

	</body>
</html>
