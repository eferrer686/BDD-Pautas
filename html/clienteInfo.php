<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/clientes.php';
    include '../php/clienteInfo.php';
?>
<html>

  <head>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/clienteInfo.js"></script>
    <?php checkLogin(); ?>
    <?php topnav(); ?>
    <?php  setAll();  ?>
    <link rel="stylesheet" type="text/css" href="../css/clientes.css">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <link rel="icon" href="../css/icon.png">
  </head>
    <title class="titleWindowClienteInfo"> Cliente: <?php printNombreCliente(); ?> </title>
  <body onload="setNombre()">
    <form class="actualizarInput" action="clienteInfo.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLPautas" name="tablaSQLPautas" value="" hidden='true'>
    </form>
    <h1 class="titleClienteInfo"> Cliente: <?php printNombreCliente(); ?> </h1>
    <table class="clienteInfo">
      <tr>
        <td>
          <table class="clienteInfoTable">

              <td><p>ID</p></td>
              <td><?php printIDCliente(); ?></td>
            </tr>
            <tr>
              <td><p>Nombre</p></td>
              <td><?php printNombreCliente(); ?></td>
            </tr>
            <tr>
              <td><p>Contacto</p></td>
              <td><?php printContactoCliente(); ?></td>
            </tr>
            <tr>
              <td><p>Mail</p></td>
              <td><?php printMailCliente(); ?></td>
            </tr>
            <tr>
              <td><p>Telefono</p></td>
              <td><?php printTelefonoCliente(); ?></td>
            </tr>
            <tr>
              <td><p>RFC</p></td>
              <td><?php printRFCCliente(); ?></td>
            </tr>
            <tr>
              <td><p>Direccion</p></td>
              <td><?php printDireccionCliente(); ?></td>
            </tr>
            <tr>
              <td><p>Pautas</p></td>
              <td><?php printPautaCliente(); ?></td>
            </tr>
          </table>
        </td>
        <td>
            <?php pautasCliente(); ?>
        </td>
      </tr>
    </table>
  </body>
  <footer>
    <form class="formPautaInfo" action="clienteInfo.php" method="post">
      <input type="text" class="idPautaText" name="idPauta" value="" hidden="true">
    </form>
  </footer>
</html>
