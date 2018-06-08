<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/radios.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/radios.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/radios.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
    <title> Radios</title>
  </head>

  <body>
    <table>
      <td>
        <h1><a href="radios.php">Radios</a></h1>
      </td>
      <td class="searchInput">
        <form class="tableRadios" action="radios.php" method="post">
          <input type="text" name="Estacion" value="">
          <input type="submit" name="Buscar" value="Buscar">
        </form>
      </td>
    </table>

    <form class="actualizarInput" action="radios.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLRadios" name="tablaSQLRadios" value="" hidden='true'>
    </form>

    <?php searchRadio(); ?>


  </body>
  <footer>
    <form class="formRadioInfo" action="radios.php" method="post">
      <input type="text" class="idRadioText" name="idRadio" value="" hidden="true">
    </form>
  </footer>
</html>
