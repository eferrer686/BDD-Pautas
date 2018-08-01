<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/proveedores.php';
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
    <title> Proveedores</title>
  </head>

  <body>
    <table>
      <td>
        <h1><a href="proveedores.php">Proveedores</a></h1>
      </td>
      <td class="searchInput">
        <form class="tableProveedores" action="proveedores.php" method="post">
          <input type="text" name="Nombre" value="">
          <input type="submit" name="Buscar" value="Buscar">
        </form>
      </td>
    </table>

    <form class="actualizarInput" action="proveedores.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLProveedores" name="tablaSQLProveedores" value="" hidden='true'>
    </form>

    <?php searchProveedores(); ?>


  </body>
  <footer>
    <form class="formProveedorInfo" action="proveedores.php" method="post">
      <input type="text" class="idProveedorText" name="idProveedor" value="" hidden="true">
    </form>
  </footer>
</html>
