<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/clientes.php';
?>
<html>
  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/clientes.js"></script>
    <title> Clientes </title>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/clientes.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
  </head>
  <body>
      <table>
        <td>
          <h1><a href="clientes.php">Clientes</a></h1>
        </td>
        <td class="searchInput">
          <form class="tableClientes" action="clientes.php" method="post">
            <input type="text" name="Nombre" value="">
            <input type="submit" name="Buscar" value="Buscar">
          </form>
        </td>

    </table>

    <form class="actualizarInput" action="clientes.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLClientes" name="tablaSQLClientes" value="" hidden='true'>
    </form>

    <?php searchCliente(); ?>


  </body>
  <footer>
    <form class="formClienteInfo" action="clientes.php" method="post">
      <input type="text" class="idClienteText" name="idCliente" value="" hidden="true">
    </form>
  </footer>
</html>
