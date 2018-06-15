<?php
    //include '../php/sqlPHP.php';
    include '../php/gui.php';
    
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
  <table class="topHTMLTable">
  <td>
    <h1>Pautas</h1>
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
  <div class="pautas" id = "pautas"></div>
  <!-- Table Pautas -->

  <!-- Modal de Fecha -->
  <!-- The Modal -->
<!-- <div id=myModal class=modal>

  <div class=modal-content>
    <span class=close>&times;</span>
    <table>
      <tr>
      <td>
        <p>Numero de spots:</p>
      </td>
      <td>
        <input type=number name=numSpots value=''>
      </td>
    </tr>
    <tr>
      <td>
        <p>Tipo de Spot:</p>
      </td>
      <td>
        <input type=text name=tipoSpot value=''>
      </td>
    </tr>
  </table>
  <input type=button name=AceptarSpot value=Aceptar>
  </div>

</div> -->



</body>

</html>
