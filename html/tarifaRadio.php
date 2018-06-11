<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/tarifaRadio.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/tarifas.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <?php setAll(); ?>
    <link rel="stylesheet" type="text/css" href="../css/tarifas.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
    <title> Tarifas</title>
  </head>

  <body>

    <form class="actualizarInput" action="tarifaRadio.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLtarifas" name="tablaSQLTarifas" value="" hidden='true'>
    </form>



        <h1> Tarifas de  <?php printNombreRadio(); ?> </h1>



    <?php searchTarifa(); ?>

  </body>
  <footer>
    <form class="formTarifaInfo" action="tarifaRadio.php" method="post">
      <input type="text" class="idTarifaText" name="idTarifa" value="" hidden="true">
    </form>
  </footer>
</html>
