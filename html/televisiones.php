<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/televisiones.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/televisiones.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/televisiones.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
    <title> Televisión</title>
  </head>

  <body>
    <table>
      <td>
        <h1><a href="televisiones.php">Televisión</a></h1>
      </td>
      <td class="searchInput">
        <form class="tableTelevisiones" action="televisiones.php" method="post">
          <input type="text" name="Estacion" value="">
          <input type="submit" name="Buscar" value="Buscar">
        </form>
      </td>
    </table>

    <form class="actualizarInput" action="televisiones.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLTelevisiones" name="tablaSQLTelevisiones" value="" hidden='true'>
    </form>

    <?php searchTelevision(); ?>


  </body>
  <footer>
    <form class="formTelevisionInfo" action="televisiones.php" method="post">
      <input type="text" class="idTelevisionText" name="idTelevision" value="" hidden="true">
    </form>
  </footer>
</html>
