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

<body onload="displayTable()">
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
        <input type="date" name="begin" value="" id = "begin" onchange="displayCalendar()">
      </td>
      <td>
        <p>Hasta:</p>
      </td>
      <td>
        <input type="date" name="finish" value="" id = "finish" onchange="displayCalendar()">
      </td>
    </table>
  </td>
</table>

  <!-- Table Pautas -->
  <div class="pautas" id = "pautas">
  <!-- Table Pautas -->

  </div>


</body>

</html>
