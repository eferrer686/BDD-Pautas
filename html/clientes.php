<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/clientes.php';
?>
<html>
  <head>
    <title> Clientes </title>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <link rel="stylesheet" type="text/css" href="../css/clientes.css">
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
    <?php searchCliente(); ?>
  </body>
  <footer>
    <form class="trFormHiddenClientes" action="clientes.php" method="post">
    </form>
  </footer>
</html>
