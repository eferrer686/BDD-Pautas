<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/proveedores.php';
    include '../php/proveedorInfo.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/proveedores.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/proveedores.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
  </head>
    <title> Proveedor: <?php printNombreProveedor(); ?> </title>
  <body>
    <h1> Proveedor: <?php printNombreProveedor(); ?> </h1>
  </body>
</html>
