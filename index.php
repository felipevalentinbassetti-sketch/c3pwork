<script>
  document.addEventListener("DOMContentLoaded", function () {
    const msg = localStorage.getItem("sucesso");
    if (msg) {
      alert(msg);
      localStorage.removeItem("sucesso");
    }
  });
</script>


<?php include "inc/header.php"; ?>
<body>
</body>
</html>
<?php
// lembrar de 
// 📱 Celular ➝ VARCHAR(15)
//☎️ Telefone ➝ VARCHAR(15)
//🏠 CEP ➝ VARCHAR(10)
//📧 E-mail ➝ VARCHAR(100)
?>