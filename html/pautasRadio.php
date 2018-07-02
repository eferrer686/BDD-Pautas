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
      <div class=tablaDiaPautasRadio></div>
      <input type=button name=AceptarSpot value=Aceptar>
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
          <input type="date" name="finish" value="" class="begin" id = "finish">
        </td>
      </table>
    </td>
  </table>

  <!-- Table Pautas -->
  <div class="pautas" id = "pautas"><?php setTablePautas(); ?></div>
  <!-- Table Pautas -->







</body>

</html>
