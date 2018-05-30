<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/clientes.php';
    include '../php/clienteNuevo.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/clientes.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/clientes.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
  </head>
    <title> Cliente Nuevo</title>
  <body>
    <h1> Cliente Nuevo</h1>
  </body>
</html>
