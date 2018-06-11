<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/tarifaTelevision.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/tarifasTelevision.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <?php setAll(); ?>
    <link rel="stylesheet" type="text/css" href="../css/tarifasTelevision.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
    <title> Tarifas</title>
  </head>

  <body>

    <form class="actualizarInput" action="tarifaTelevision.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLTelevisiones" name="tablaSQLTelevisiones" value="" hidden='true'>
    </form>



        <h1> Tarifas de  <?php printNombreTelevision(); ?> </h1>



    <?php searchTarifa(); ?>

  </body>
  <footer>
    <form class="formTarifaInfo" action="tarifaTelevision.php" method="post">
      <input type="text" class="idTarifaText" name="idTarifa" value="" hidden="true">
    </form>
  </footer>
</html>
