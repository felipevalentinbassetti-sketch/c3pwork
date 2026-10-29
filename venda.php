<?php 
    include "inc/checklogin.php";

//mandar o lucro (preco_v-preco_c)*quantidade_vendida para ajudar no fiscal
//tbm tem q mostrar se ja foi pago o valor total ou n

    $token = buscarEmpresaPorToken($con, $_COOKIE["token"]);
    $id_empresa = $token["id_empresa"];
    $c = listarClientes($con, $id_empresa);
    $p = listarProdutos($con, $id_empresa);
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
                        <article id="venda">
                            <div class="container" id="form-container">
                                <h2>Venda</h2>
                                <form id="formVenda" method="post">
                                    <label for="cliente">Cliente:</label><br>
                                    <select id="cliente" name="cliente" required>
                                        <option value="" disabled selected hidden>Clientes</option>
                                        <?php
                                        for ($i = 0; $i < count($c); $i++) {
                                            echo "<option value=".$c[$i]['id']."\">".$c[$i]['nome']."</option>";
                                        }
                                        ?>
                                    </select><br><br>

                                    <label for="Produto">Produtos:</label><br>
                                    <div>
                                        <?php
                                            for ($i = 0; $i < count($p); $i++) {
                                                echo "<label for='produto_".$p[$i]['codigo_barras']."'> ".$p[$i]['nome']." - R$ ".number_format($p[$i]['preco_v'], 2)."</label>
                                                    <input type='number' class='produto' id='produto_".$p[$i]['codigo_barras']."' data-valor='".$p[$i]['preco_v']."' data-codigo='".$p[$i]['codigo_barras']."' name='produtos[".$p[$i]['codigo_barras']."][quantidade]'  min='0' value='0' max='".$p[$i]['quantidade']."'><br>";
                                            }
                                        ?>
                                    </div>

                                    <label for="pagamento">Forma de Pagamento:</label><br>
                                    <select name="pagamento" id="pagamento" required>
                                        <option value="" disabled selected hidden>Pagamento</option>
                                        <option value="dinheiro">Dinheiro</option>
                                        <option value="debito">Débito</option>
                                        <option value="credito">Crédito</option>
                                        <option value="pix">PIX</option>
                                    </select><br>

                                    <div id="parcelas-container" style="display: none;">
                                        <label for="parcelas">Número de Parcelas:</label><br>
                                        <input type="number" id="parcelas" name="parcelas" min="1" max="12">
                                    </div><br>

                                    <div id="valor"></div><br><br>
                                    <input type="hidden" id="valor_total" name="valor_total">
                                    <div id="valor-parcelas" style="display: none;"></div><br><br>

                                    <button type="submit">Enviar</button>
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

            <script src="assets/scripts/script_venda.js"></script>

            <script>
                const inputQuantidade = document.querySelectorAll(".produto");
                const valorDiv = document.getElementById("valor");
                const pagamentoSelect = document.getElementById("pagamento");
                const parcelasInput = document.getElementById("parcelas");
                const parcelasContainer = document.getElementById("parcelas-container");
                const parcelasVDiv = document.getElementById("valor-parcelas");

                let total = 0;

                function atualizarValorTotal() {
                    total = 0;
                    inputQuantidade.forEach(cb => {
                        const qtd = parseInt(cb.value);
                        const preco = parseFloat(cb.dataset.valor);
                        if (!isNaN(qtd) && qtd > 0) {
                            total += qtd * preco;
                        }
                    });
                    valorDiv.textContent = "Total: R$ " + total.toFixed(2);
                    atualizarValorParcelas();
                }


                function atualizarValorParcelas() {
                    const parcelas = parseInt(parcelasInput.value);
                    if (pagamentoSelect.value === "credito" && parcelas > 0 && total > 0) {
                        const valorParcela = (total * 1.1) / parcelas;
                        parcelasVDiv.textContent = `Parcelas: ${parcelas}x de R$ ${valorParcela.toFixed(2)}`;
                    } else {
                        parcelasVDiv.textContent = "";
                    }
                }

                inputQuantidade.forEach(cb => {
                    cb.addEventListener("input", atualizarValorTotal);
                });


                pagamentoSelect.addEventListener("change", function () {
                    if (this.value === "credito") {
                        parcelasContainer.style.display = "block";
                        parcelasVDiv.style.display = "block";
                    } else {
                        parcelasContainer.style.display = "none";
                        parcelasVDiv.style.display = "none";
                    }
                    atualizarValorParcelas();
                });

                parcelasInput.addEventListener("input", atualizarValorParcelas);
            </script>

	</body>
</html>
