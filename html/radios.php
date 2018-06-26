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

    <table class="buttonsTable">
      <tr>
        <td>
          <input class="nuevoEstado" type="button" name="nuevo" value="Nuevo Estado">
        </td>
        <td>
          <input class="nuevaCiudad" type="button" name="nuevo" value="Nueva Ciudad">
        </td>
      </tr>
    </table>


    <form class="actualizarInput" action="radios.php" method="post">
      <input type="button" name="Actualizar" value="Actualizar" class="actualizarButton">
      <input type="text" class="tablaSQLRadios" name="tablaSQLRadios" value="" hidden='true'>
    </form>

    <?php searchRadio(); ?>


    <!-- Modal Agregar Ciudad -->
    <div id=modalCiudad class=modal>
      <div class=modal-content>
        <span class=closeCiudad>&times;</span>
        <p>Nueva ciudad</p>
        <table>
          <tr>
            <td>
              <p>Selecciona un Estado:</p>
            </td>
            <td>
              <select class="estadoDeNuevaCiudad"><?php echo selectEstados(0); ?></select>
            </td>
          </tr>
          <tr>
            <td>
              <p>Nueva  ciudad:</p>
            </td>
            <td>
              <input type="text" name="ciudad" value="" class="nuevaCiudadInputText">
            </td>
          </tr>
        </table>
        <input type=button name=agregarCiudad value=Agregar class="modalButton" onclick="agregarCiudad()">
      </div>
    </div>

    <!-- Modal Agregar Estado -->
    <div id=modalEstado class=modal>
      <div class=modal-content>
        <span class=closeEstado>&times;</span>
        <p>Nuevo Estado</p>
        <input type="text" name="estado" value="" class="nuevoEstadoInputText">
        <input type=button name=agregarEstado value=Agregar class="modalButton" onclick="agregarEstado()">
      </div>
    </div>

  </body>
  <footer>
    <form class="formRadioInfo" action="radios.php" method="post">
      <input type="text" class="idRadioText" name="idRadio" value="" hidden="true">
    </form>
  </footer>
</html>
