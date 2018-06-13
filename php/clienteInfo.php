<?php
if(isset($_POST['tablaSQLPautas'])){
    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLPautas']);
    updateSQLTablePautas();
}

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

  echo '<div class="bigTableContainer"> <table class="tablePautasSQL" id="tablePautasSQL">';
  echo
      "<tr class='trTableTop'><td>ID
      </td><td>Nombre
      </td><td>Tipo
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
           "<tr class='trTablePautas'id=editable>
           <td class='idCliente'>" . $row['idPauta'] .
           "</td><td class='nombre' contenteditable=true>" . $row['nombre'] .
           "</td><td class='tipo'><select id='sel".$row['idPauta']."'>" . setSelect($row['tipo'],$row['idPauta']) .
           "</td><td class='invTotal'>" . $row['invTotal'] .
           "</td> ";
        }



  } else{
    unset($_SESSION['searchMethod']);
    unset($_SESSION['searchText']);
  }
  echo
  "<tr class='trTablePautas'id=editable>".
   "<td class='idCliente'>".
   "</td><td class='nombre' contenteditable=true>".
   "</td><td class='tipo'><select id='sel'>" . setSelect(0,"") .
   "</td><td class='invTotal'>".

   "</td></tr> ";

echo"</table></div>";
  mysqli_close($con);

}
function updateSQLTablePautas(){

      global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple;
      $tableID = 'idPauta';
      $sqlFrom = 'pauta';

      $newTable = $_SESSION['tablaSQL'];
      for ($i=0; $i < count($newTable)-1; $i++) {
        $idTuple = $newTable[$i][0];

        $updateName = 'nombre';
        $updateValue = $newTable[$i][1];
        sqlUpdate();

        $updateName = 'tipo';
        $updateValue = $newTable[$i][2];
        sqlUpdate();

      }

      if($newTable[count($newTable)-1][1]!=''){
          addPauta($newTable[count($newTable)-1]);
      }
}

function addPauta($lastRow){
  global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

  $con = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

  $sql = '  INSERT INTO pauta (Cliente_idCliente, nombre, tipo)  VALUES ("' .

    $_SESSION['idCliente'] .'","' .
    $lastRow[1].'","' .
    $lastRow[2] .'")';



  $result = mysqli_query($con,$sql);

  mysqli_close($con);


}
function setSelect($tipo,$id){
  $r='';
  $r = $r.
  "<option value='1'>radio</option>".
  "<option value='2'>television</option>".
  "<option value='3'>espectacular</option>";

  if($tipo!=0){
      $r = $r.
      "<script>
          document.getElementById('sel".$id."').selectedIndex = ".($tipo-1).";
      </script>";
  }
  return $r;
  }
?>
