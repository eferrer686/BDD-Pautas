<?php
    include '../php/sqlPHP.php';
    include '../php/gui.php';
    include '../php/pautasRadio.php';

?>
<html>
<head>

<script lang="javascript" src="../js/SheetJS/dist/xlsx.full.min.js"></script>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/pautasRadio.js"></script>
<title> Pautas </title>
<?php topnav(); ?>
<link rel="stylesheet" type="text/css" href="../css/pautasRadio.css">
<link rel="stylesheet" type="text/css" href="../css/background.css">
<link rel="icon" href="../css/icon.png">



</head>

<body onload="setNombre()">
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
            <h2 id="titlePautas">Nuevo Renglon</h2>
          </td>
          <td>
            <span class=closeNuevoRenglon>&times;</span>
          </td>
        </tr>
      </table>
      <?php setSelectECR(); ?>
      <input type=button name=AceptarNuevoRenglon value=Aceptar class="AceptarNuevoRenglon" onclick='agregarNuevoRenglon()'>
    </div>
  </div>



  <table class="topHTMLTable">
    <td>
      <h1 class="titlePautasRadio">Pautas de </h1>
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
      </table>
      <td height=40 width=40>
        <img src="../images/loading7.gif" alt="Loading..." id="loading" height="40" width="40" hidden="true">
      </td>
      <td>
        <p class="universo">universo:</p>
      </td>
      <td>
        <input type="number" id='universoPauta' name="universo" onchange="changeUniverso(this)" value= <?php getUniverso(); ?>>
      </td>
    </td>
  </table>

  <!-- Table Pautas -->
  <div class="pautas" id = "pautas"><?php setTablePautas(); ?></div>
  <!-- Table Pautas -->



  <input type="button" name="mostrarModalNuevoRenglon" id="mostrarModalNuevoRenglon" value="Agregar" class="agregarNuevoRenglon" onclick="mostrarModalNuevoRenglon()">
  <input type="button" name="exportar" value="Exportar" class="exportarButton" onclick="exportClientVersion()">




</body>

</html>
