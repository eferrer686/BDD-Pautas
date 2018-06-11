<?php

$idTelevision = '';
$canalTelevision = '';

if(isset($_POST['Buscar'])){
    searchTelevisiones();
}
if(isset($_POST['idTelevision'])){
  goToTelevision();
}
if(isset($_POST['tablaSQLTelevisiones'])){

    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLTelevisiones']);

    updateSQLTable();
}

function searchTelevisiones(){
    global $searchText;
    $_SESSION['searchMethod'] = 'canal';
    $_SESSION['searchText'] = $_POST['Canal'];
    header("Location: /bdd-pautas/html/televisiones.php");
}

function searchTelevision(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idTelevision,
    $canalTelevision;

    $tablaProveedores = getAllProveedores();

    $sqlFrom = 'televisiones';
    $searchMethod = 'canal';

    echo '<div class="bigTableContainer"> <table class="tableTelevisionesSQL" id="tableTelevisionesSQL">';
    echo
        "<tr class='trTableTop'><td>ID
        </td><td>Nombre
        </td><td>Canal
        </td><td>Estado
        </td><td>Ciudad
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
             "<tr class='trTableTelevisiones'id=editable>
             <td class='idTelevision'>" . $row['idTelevision'] .
             "</td><td class='nombre'contenteditable=true>" . $row['nombre'] .
             "</td><td class='canal' contenteditable=true>" . $row['canal'] .
             "</td><td class='estado' contenteditable=true>" . $row['estado'] .
             "</td><td class='ciudad' contenteditable=true>" . $row['ciudad'] .
             "</td><td class='siglas' contenteditable=true>" . $row['siglas'] .
             "</td><td class='proveedor'><select id='sel'>" . setSelect($row['idProveedor'], $tablaProveedores) .
             "</select></td></tr>";

          }

          echo
          "<tr class='trTableTelevisiones'id=editable>".
           "<td class='idTelevision'>".
           "</td><td class='nombre'contenteditable=true>".
           "</td><td class='canal' contenteditable=true>".
           "</td><td class='estado' contenteditable=true>".
           "</td><td class='ciudad' contenteditable=true>".
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
    $tableID = 'idTelevision';
    $sqlFrom = 'television';

    $newTable = $_SESSION['tablaSQL'];
    for ($i=0; $i < count($newTable)-1; $i++) {
      $idTuple = $newTable[$i][0];

      $updateName = 'nombre';
      $updateValue = $newTable[$i][1];
      sqlUpdate();
      $updateName = 'canal';
      $updateValue = $newTable[$i][2];
      sqlUpdate();
      $updateName = 'estado';
      $updateValue = $newTable[$i][3];
      sqlUpdate();
      $updateName = 'ciudad';
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
        addTelevision($newTable[count($newTable)-1]);
    }else{

      $result = mysqli_query($con,$sql);
      mysqli_close($con);

      $_SESSION['searchMethod'] = 'canal';
      $_SESSION['searchText'] = '';

      searchTelevisiones();
    }
  }
  function addTelevision($lastRow){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql = 'INSERT INTO television (nombre, canal, estado, ciudad, siglas,Proveedor_idProveedor) VALUES ("' .

      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'","' .
      $lastRow[5] .'","' .
      $lastRow[6] .'")';



    $result = mysqli_query($con,$sql);




    $_SESSION['searchMethod'] = 'canal';
    $_SESSION['searchText'] = '';

    searchTelevisiones();


  }
  function goToTelevision(){
    $_SESSION['searchMethod'] = 'idTelevision';
    $_SESSION['searchText'] = $_POST['idTelevision'];

    $_SESSION['idTelevision'] = $_POST['idTelevision'];

    header("Location: /bdd-pautas/html/tarifatelevision.php");
    exit();
  }
  function getAllProveedores(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idTelevision,
    $canalTelevision;

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
