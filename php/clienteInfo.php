<?php

function setAll(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idCliente,

    $nombre,
    $contacto,
    $mail,
    $telefono,
    $rfc,
    $direccion,
    $pautas;

    $sqlFrom = 'clientes';

    $idCliente = $_SESSION['idCliente'];




    if (isset($_SESSION['searchMethod'])){
        $searchMethod=$_SESSION['searchMethod'];
    }
    if (isset($_SESSION['searchText'])){
        $searchText=$_SESSION['searchText'];
    }
    sqlSearch();

    if($result != null){
      while($row = mysqli_fetch_array($result))
        {
          $nombre =  $row['nombre'];
          $contacto= $row['contacto'];
          $mail= $row['mail'];
          $telefono= $row['telefono'];
          $rfc= $row['rfc'];
          $direccion= $row['direccion'];
          $pautas= $row['numPautas'];
        }
      }else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
      }
      mysqli_close($con);
}
function printIDCliente(){
  global $idCliente;
  echo $idCliente;
}
function printNombreCliente(){
  global $nombre;
  echo $nombre;
}
function printContactoCliente(){
  global $contacto;
  echo $contacto;
}
function printMailCliente(){
  global $mail;
  echo $mail;
}
function printTelefonoCliente(){
  global $telefono;
  echo $telefono;
}
function printRFCCliente(){
  global $rfc;
  echo $rfc;
}
function printDireccionCliente(){
  global $direccion;
  echo $direccion;
}
function printPautaCliente(){
  global $pautas;
  echo $pautas;
}


//Tabla Pautas

function pautasCliente(){
  global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

  $idCliente;



  $sqlFrom = 'pautas';

  echo '<div class="bigTableContainer"> <table class="tableClientesSQL" id="tableClientesSQL">';
  echo
      "<tr class='trTableTop'><td>ID
      </td><td>Nombre
      </td><td>Inversión Total
      </td></tr>
       ";

     $searchMethod="Cliente_idCliente";

     $searchText = $_SESSION['idCliente'];;

  sqlSearch();

  if($result != null){
      while($row = mysqli_fetch_array($result))
        {
          echo
           "<tr class='trTableClientes'id=editable>
           <td class='idCliente'>" . $row['idPauta'] .
           "</td><td class='nombre' contenteditable=true>" . $row['nombre'] .
           "</td><td class='invTotal'contenteditable=true>" . $row['invTotal'] .
           "</td> ";
        }

        echo
        "<tr class='trTableClientes'id=editable>".
         "<td class='idCliente'>".
         "</td><td class='nombre' contenteditable=true>".
         "</td><td class='invTotal'>".

         "</td></tr> ";
      echo"</table></div>";

  } else{
    unset($_SESSION['searchMethod']);
    unset($_SESSION['searchText']);
  }
  mysqli_close($con);

}
?>
