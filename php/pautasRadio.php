<?php

$idRadio = '';
$estacionRadio = '';

if(isset($_POST['Buscar'])){
    searchRadios();
}
if(isset($_POST['idRadio'])){
  goToRadio();
}
if(isset($_POST['tablaSQLRadios'])){

    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLRadios']);

    updateSQLTable();
}

function searchRadios(){
    global $searchText;
    $_SESSION['searchMethod'] = 'estacion';
    $_SESSION['searchText'] = $_POST['Estacion'];
    header("Location: /bdd-pautas/html/radios.php");
}

function searchRadio(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idRadio,
    $estacionRadio;

    $tablaProveedores = getAllProveedores();

    $sqlFrom = 'radios';
    $searchMethod = 'estacion';

    echo '<div class="bigTableContainer"> <table class="tableRadiosSQL" id="tableRadiosSQL">';
    echo
        "<tr class='trTableTop'><td>ID
        </td><td>Estacion
        </td><td>Estado
        </td><td>Ciudad
        </td><td>Frecuencia
        </td><td>Siglas
        </td><td>Proveedor
        </td></tr>
         ";
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
            echo
             "<tr class='trTableRadios'id=editable>
             <td class='idRadio'>" . $row['idRadio'] .
             "</td><td class='estacion' contenteditable=true>" . $row['estacion'] .
             "</td><td class='estado' contenteditable=true>" . $row['estado'] .
             "</td><td class='ciudad' contenteditable=true>" . $row['ciudad'] .
             "</td><td class='frecuencia'contenteditable=true>" . $row['frecuencia'] .
             "</td><td class='siglas' contenteditable=true>" . $row['siglas'] .
             "</td><td class='proveedor'><select id='sel'>" . setSelect($row['idProveedor'], $tablaProveedores) .
             "</select></td></tr>";

          }

          echo
          "<tr class='trTableRadios'id=editable>".
           "<td class='idRadio'>".
           "</td><td class='estacion' contenteditable=true>".
           "</td><td class='estado' contenteditable=true>".
           "</td><td class='ciudad' contenteditable=true>".
           "</td><td class='frecuencia'contenteditable=true>".
           "</td><td class='siglas' contenteditable=true>".
           "</td><td class='proveedor'><select>".setSelect(0,$tablaProveedores)."</select>".
           "</td> ";

        echo"</table></div>";
    } else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
    }
    mysqli_close($con);

  }

  function updateSQLTable(){


    global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple;
    $tableID = 'idRadio';
    $sqlFrom = 'radio';

    $newTable = $_SESSION['tablaSQL'];
    for ($i=0; $i < count($newTable)-1; $i++) {
      $idTuple = $newTable[$i][0];

      $updateName = 'estacion';
      $updateValue = $newTable[$i][1];
      sqlUpdate();
      $updateName = 'estado';
      $updateValue = $newTable[$i][2];
      sqlUpdate();
      $updateName = 'ciudad';
      $updateValue = $newTable[$i][3];
      sqlUpdate();
      $updateName = 'frecuencia';
      $updateValue = $newTable[$i][4];
      sqlUpdate();
      $updateName = 'siglas';
      $updateValue = $newTable[$i][5];
      sqlUpdate();
      $updateName = 'Proveedor_idProveedor';
      $updateValue = $newTable[$i][6];
      sqlUpdate();


    }


    if($newTable[count($newTable)-1][1]!=''){
        addRadio($newTable[count($newTable)-1]);
    }else{

      $result = mysqli_query($con,$sql);
      mysqli_close($con);

      $_SESSION['searchMethod'] = 'estacion';
      $_SESSION['searchText'] = '';

      searchRadios();
    }
  }
  function addRadio($lastRow){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql = 'INSERT INTO radio (estacion, estado, ciudad, frecuencia, siglas,Proveedor_idProveedor) VALUES ("' .

      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'","' .
      $lastRow[5] .'","' .
      $lastRow[6] .'")';



    $result = mysqli_query($con,$sql);




    $_SESSION['searchMethod'] = 'estacion';
    $_SESSION['searchText'] = '';

    searchRadios();


  }
  function goToRadio(){
    $_SESSION['searchMethod'] = 'idRadio';
    $_SESSION['searchText'] = $_POST['idRadio'];

    $_SESSION['idRadio'] = $_POST['idRadio'];

    header("Location: /bdd-pautas/html/tarifaradio.php");
    exit();
  }
  function getAllProveedores(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idRadio,
    $estacionRadio;

  // Get all Proveedores
  $sqlFrom = 'proveedores';
  $searchMethod = 'nombre';
  $searchText = "";

  sqlSearch();

  $tablaProveedores;

  if($result != null){
    $i = 0;
      while($row = mysqli_fetch_array($result)){
            $tablaProveedores[$i]=$row;
            $i=$i+1;
        }
      }
      return $tablaProveedores;
  }



  function setSelect($idProveedor,$tablaProveedores){
    $r='';
    for ($i=0; $i < count($tablaProveedores); $i++) {
      if($tablaProveedores[$i]['idProveedor'] == $idProveedor){

        $r = $r.
        "<option value='". $tablaProveedores[$i]['idProveedor'] ."' selected='selected'>"
        .  $tablaProveedores[$i]['nombre'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaProveedores[$i]['idProveedor'] ."'>"
        . $tablaProveedores[$i]['nombre'] ."</option>";
        }
      }
      return $r;

    }

?>
