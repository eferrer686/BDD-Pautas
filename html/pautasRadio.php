<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/pautasRadio.php';

?>
<html>
<head>

<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/pautasRadio.js"></script>
<title> Pautas </title>
<?php topnav(); ?>
<link rel="stylesheet" type="text/css" href="../css/pautasRadio.css">
<link rel="stylesheet" type="text/css" href="../css/background.css">
<link rel="icon" href="../css/icon.png">



</head>

<body>
  <!-- Modal de Fecha -->
  <!-- The Modal -->

  <div id=myModal class=modal>

    <div class=modal-content>
      <table class="modal-title">
        <tr>
          <td>
            <div id='textDate'></div>
          </td>
          <td>
            <span class=close>&times;</span>
          </td>
        </tr>
      </table>
      <div id=modal-table></div>
        <input type=date name=date id=modalDate value='' hidden=true>
        <input type=text name=id id=modalId value='' hidden=true>
      <div class=tablaDiaPautasRadio></div>
      <input type=button name=AceptarSpot value=Aceptar class="aceptarSpot">
    </div>
  </div>


  <div id=modalNuevoRenglon class=modal>
    <div class=modal-content>
      <table class="modal-title">
        <tr>
          <td>
            <h2>Nuevo Renglon</h2>
          </td>
          <td>
            <span class=closeNuevoRenglon>&times;</span>
          </td>
        </tr>
      </table>
      <table class="inputNuevoRenglon">
        <tr>
          <td>
            <p>Estado</p>
          </td>
          <td>
            <input type="text" name="" value="">
          </td>
        </tr>
        <tr>
          <td>
            <p>Ciudad</p>
          </td>
          <td>
            <input type="text" name="" value="">
          </td>
        </tr>
        <tr>
          <td>
            <p>Estación</p>
          </td>
          <td>
            <input type="text" name="" value="">
          </td>
        </tr>
      </table>
      <input type=button name=AceptarNuevoRenglon value=Aceptar class="AceptarNuevoRenglon">
    </div>
  </div>



  <table class="topHTMLTable">
    <td>
      <h1>Pautas de <?php printPautaNombre(); ?></h1>
    </td>
    <td>
      <table class="setDates">
        <td>
          <p>Desde:</p>
        </td>
        <td>
          <input type="date" name="begin" value="" class="begin" id = "begin">
        </td>
        <td>
          <p>Hasta:</p>
        </td>
        <td>
          <input type="date" name="finish" value="" class="finish" id = "finish">
        </td>
        <td>
          <img src="../images/loading.gif" alt="Loading..." id="loading" height="50" width="50" hidden="true">
        </td>
      </table>
    </td>
  </table>

  <!-- Table Pautas -->
  <div class="pautas" id = "pautas"><?php setTablePautas(); ?></div>
  <!-- Table Pautas -->



  <input type="button" name="mostrarModalNuevoRenglon" id="mostrarModalNuevoRenglon" value="Agregar" class="agregarNuevoRenglon" onclick="mostrarModalNuevoRenglon()">





</body>

</html>
