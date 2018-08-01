<?php
if(isset($_POST['tablaSQLPautas'])){
    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLPautas']);
    updateSQLTablePautas();
}
if(isset($_POST['idPauta'])){
  $_SESSION['idPauta'] = json_decode($_POST['idPauta']);
  goToPautas();
}
if(isset($_POST['getNombre'])){
    echo json_encode($_SESSION['nombreCliente']);
    exit();
}

//Ajax delete renglonPauta
if(isset($_POST['idRenglon'])){
  deleteRenglon($_POST['idRenglon']);
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
    sqlSearchUnique();

    if($result != null){
      while($row = mysqli_fetch_array($result))
        {

          $nombre =  $row['nombre'];
          $_SESSION['nombreCliente']=$nombre;
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
      </td><td>Presupuesto
      </td><td>Inversión Total
      </td><td>Inversión Cliente Total
      <td>Delete</td>
      </td></tr>
       ";

     $searchMethod="Cliente_idCliente";

     $searchText = $_SESSION['idCliente'];;

  sqlSearchUnique();

  if($result != null){
      while($row = mysqli_fetch_array($result))
        {
          echo
           "<tr class='trTablePautas'id=editable>
           <td class='idPauta'>" . $row['idPauta'] .
           "</td><td class='nombre' contenteditable=true>" . $row['nombre'] .
           "</td><td class='tipo'><select id='sel".$row['idPauta']."'>" . setSelect($row['tipo'],$row['idPauta']) .
           "</td><td class='presupuesto' contenteditable=true>$" . $row['presupuesto'] .
           "</td><td class='invTotal'>$" . getInversionTotal($row['idPauta']) .
           "</td><td class='invClienteTotal'>$" . getInversionClienteTotal($row['idPauta']) .
           "<td>".
             "<p class='deleteRenglon'>&#10006</p>".
           "</td>".
           "</td> ";
        }



  } else{
    unset($_SESSION['searchMethod']);
    unset($_SESSION['searchText']);
  }
  echo
  "<tr class='trTablePautas'id=editable>".
   "<td class='idPauta'>".
   "</td><td class='nombre' contenteditable=true>".
   "</td><td class='tipo'><select id='sel'>" . setSelect(0,"") .
   "</td><td class='presupuesto'contenteditable=true>".
   "</td><td class='invTotal'>".
   "</td><td class='invClienteTotal'>".
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

        $updateName = 'presupuesto';
        $updateValue = $newTable[$i][3];
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

  $sql = '  INSERT INTO pauta (Cliente_idCliente, nombre, tipo, presupuesto)  VALUES ("' .

    $_SESSION['idCliente'] .'","' .
    $lastRow[1].'","' .
    $lastRow[2].'","' .
    $lastRow[3] .'")';



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
  function goToPautas(){

    $table = $_SESSION['idPauta'];
    $idPauta = $table[0];
    $tipo = $table[2];


    if ($tipo == 1) {
      $_SESSION['idPauta']=$idPauta;
      header("Location: /bdd-pautas/html/pautasRadio.php");
      exit();
    }elseif ($tipo == 2) {
      echo '<script language="javascript">';
      echo 'alert("Es tv, por el momento no está disponible")';
      echo '</script>';
    }
    elseif ($tipo == 3) {
      echo '<script language="javascript">';
      echo 'alert("Es espectacular, por el momento no está disponible")';
      echo '</script>';
    }

  }

  function getInversionTotal($idPauta){
    global $servername, $username, $password, $dbname, $user, $pwd;

    $con = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql = "SELECT
              cantidad,
              tarifaGeneral,
              tarifaEspecifica
            FROM
              spotsradio
            WHERE
              idPauta = ".$idPauta;

    $result = mysqli_query($con,$sql);

    $inversion = 0;

    if($result != null){
      $i=0;
      while($row = mysqli_fetch_array($result))
        {
          $inversion=$inversion + ($row['cantidad']*$row['tarifaGeneral']);
        }
    }
    return $inversion;
  }
  function getInversionClienteTotal($idPauta){
    global $servername, $username, $password, $dbname, $user, $pwd;

    $con = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql = "SELECT
              cantidad,
              tarifaGeneral,
              tarifaEspecifica
            FROM
              spotsradio
            WHERE
              idPauta = ".$idPauta;

    $result = mysqli_query($con,$sql);

    $inversion = 0;

    if($result != null){
      $i=0;
      while($row = mysqli_fetch_array($result))
        {
          $inversion=$inversion + ($row['cantidad']*$row['tarifaEspecifica']);
        }
    }
    return $inversion;
  }



  function deleteRenglon($idPauta){

      global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;


      $con = mysqli_connect($servername, $username, $password, $dbname);

      // Check connection
      if (mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }
      $sql = "DELETE FROM pauta WHERE idPauta=". $idPauta;

      $result = mysqli_query($con,$sql);

  }

?>
