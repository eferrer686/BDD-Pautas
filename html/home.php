<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
?>
<html>
  <head>
    <title> BDD Pautas </title>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="icon" href="../css/icon.png">
  </head>
  <body>
    <h1> Bienvenido <?php printNombre(); ?> ! </h1>
  </body>
</html>
