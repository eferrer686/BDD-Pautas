<?php

$idRadio = '';
$estacionRadio = '';
$tablaEstados ='';

// if(isset($_POST['Buscar'])){
//   searchRadios();
// }
if(isset($_POST['idRadio'])){
  goToRadio();
}
if(isset($_POST['tablaSQLRadios'])){

    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLRadios']);
    updateSQLTable();
}
//Ajax change of Estado
if(isset($_POST['estadoID'])){
  estadoChange($_POST['estadoID']);
}
// Ajax add estadoNuevo
if(isset($_POST['estadoNuevo'])){
  addEstado($_POST['estadoNuevo']);
}
// Ajax add ciudadNueva
if(isset($_POST['ciudadNueva'])){
  addCiudad($_POST['ciudadNueva'],$_POST['idEstadoDeNuevaCiudad']);
}
function searchRadios(){
    global $searchText;
    $_SESSION['searchMethod'] = 'estacion';

    if(isset($_POST['Estacion'])){
      $_SESSION['searchText'] = $_POST['Estacion'];
    }
    else{
      $_SESSION['searchText'] = "";
    }

    searchRadio();
}

function searchRadio(){
    global $servername, $username, $password, $searchText,$dbname, $user, $pwd, $con,$row,

    $idRadio,
    $estacionRadio;

    $tablaProveedores = getAllProveedores();

    $sqlFrom = 'radios';

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
   }else{$searchMethod='estacion';}
   if (isset($_SESSION['searchText'])){
       $searchText=$_SESSION['searchText'];
   }else{$searchText='';}
    $result = sqlSearchSpecific( $sqlFrom,$searchMethod, $searchText);

    if($result != null){
        while($row = mysqli_fetch_array($result))
          {
            $idEstado = $row['idestado'];
            $idCiudad = $row['idciudad'];
            $frecuencia = $row['frecuencia'];
            $siglas = $row['siglas'];
            $idProveedor = $row['idProveedor'];

            echo
             "<tr class='trTableRadios'id=editable>
             <td class='idRadio'>" . $row['idRadio'] .
             "</td><td class='estacion' contenteditable=true>" . $row['estacion'] .
             "</td><td class='estado' onchange = estadosChange(this) ><select>" . selectEstados($idEstado) ."</select>".
             "</td><td class='ciudad'><select>" . selectCiudades($idCiudad,$idEstado) ."</select>".
             "</td><td class='frecuencia'contenteditable=true>" . $frecuencia .
             "</td><td class='siglas' contenteditable=true>" . $siglas .
             "</td><td class='proveedor'><select id='sel'>" . setSelectProveedor($idProveedor, $tablaProveedores) .
             "</select></td></tr>";

          }
        if ($tablaProveedores!= null) {
          echo
          "<tr class='trTableRadios'id=editable>".
           "<td class='idRadio'>".
           "</td><td class='estacion' contenteditable=true>".
           "</td><td class='estado' onchange = estadosChange(this)><select>" . selectEstados(0) ."</select>".
           "</td><td class='ciudad'><select>" . selectCiudades("","") ."</select>".
           "</td><td class='frecuencia'contenteditable=true>".
           "</td><td class='siglas' contenteditable=true>".
           "</td><td class='proveedor'><select>".setSelectProveedor(0,$tablaProveedores)."</select>".
           "</td> ";
         } else {
           echo
           "<tr class='trTableRadios'id=editable>".
            "<td class='idRadio'>".
            "</td><td class='estacion' contenteditable=true>".
            "</td><td class='estado' onchange = estadosChange(this)><select>" . selectEstados(0) ."</select>".
            "</td><td class='ciudad'><select>" . selectCiudades("","") ."</select>".
            "</td><td class='frecuencia'contenteditable=true>".
            "</td><td class='siglas' contenteditable=true>".
            "</td><td class='proveedor'><select><option>No hay proveedores todavia</option></select>".
            "</td> ";
         }

        echo"</table></div>";
    } else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
    }
    mysqli_close($con);

  }

  function updateSQLTable(){

    global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple;

    $newTable = $_SESSION['tablaSQL'];
    for ($i=0; $i < count($newTable)-1; $i++) {

      $tableID = 'idRadio';
      $sqlFrom = 'radio';

      $idTuple = $newTable[$i][0];

      $updateName = 'estacion';
      $updateValue = $newTable[$i][1];
      sqlUpdate();


      $updateName = 'ciudad_idciudad';
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

    $sql = 'INSERT INTO radio (estacion, ciudad_idCiudad, frecuencia, siglas,Proveedor_idProveedor) VALUES ("' .

      $lastRow[1] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'","' .
      $lastRow[5] .'","' .
      $lastRow[6] .'")';



    $result = mysqli_query($con,$sql);



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
      if(isset($tablaProveedores)){
        return $tablaProveedores;
      }else {
        return null;
      }
  }



  function setSelectProveedor($idProveedor,$tablaProveedores){
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
  function selectEstados($idEstado){
    global $tablaEstados;

    setTablaEstados($idEstado);
    $r='';
    if($tablaEstados!=0){
      for ($j=0; $j < count($tablaEstados); $j++) {
        if($tablaEstados[$j]['idestado'] == $idEstado){
          $r = $r.
          "<option value='". $tablaEstados[$j]['idestado'] ."' selected='selected'>"
          .  $tablaEstados[$j]['estado'].
          "</option>";}
        else{
          $r = $r.
          "<option value='". $tablaEstados[$j]['idestado'] ."'>"
          . $tablaEstados[$j]['estado'] ."</option>";

          }
        }
    }
    else {
      $r = "<option>No hay estados todavia</option>";
    }
      return $r;
  }

  function setTablaEstados($idEstado){
    global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
    $tablaEstados;

    // Buscar Tabla Relacional
    $sqlFrom = 'estados';
    $searchMethod="estado";
    $searchText = "";

    $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

    if($result != null){
      $i=0;
        while($row = mysqli_fetch_array($result))
          {
            $tablaEstados[$i]=$row;
            $i=$i+1;
          }
    }
  }

  function estadoChange($estado){

    global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
    $tablaEstados;

    $sqlFrom = 'ciudades';
    $searchMethod="idestado";
    $searchText = $estado;

    $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

    $r='';

    if($result != null){
      $i=0;
        while($row = mysqli_fetch_array($result))
          {
            $r[$i]['idciudad'] = $row['idciudad'];
            $r[$i]['ciudad'] = $row['ciudad'];

            $i=$i+1;
          }
    }
    echo json_encode($r);
    exit();
  }
  function selectCiudades($idCiudad,$idEstado){
    global $tablaCiudades;

    setTablaCiudades($idCiudad,$idEstado);

    $r='';
    for ($j=0; $j < count($tablaCiudades); $j++) {
      if($tablaCiudades[$j]['idciudad'] == $idCiudad){
        $r = $r.
        "<option value='". $tablaCiudades[$j]['idciudad'] ."' selected='selected'>"
        .  $tablaCiudades[$j]['ciudad'].
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaCiudades[$j]['idciudad'] ."'>"
        . $tablaCiudades[$j]['ciudad'] ."</option>";

        }
      }
      return $r;
  }

  function setTablaCiudades($idCiudad,$idEstado){
    global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
    $tablaCiudades;

    // Buscar Tabla Relacional
    $sqlFrom = 'ciudades';
    $searchMethod="idestado";
    $searchText = $idEstado;

    $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

    if($result != null){
      $i=0;
        while($row = mysqli_fetch_array($result))
          {
            $tablaCiudades[$i]=$row;
            $i=$i+1;
          }
    }
  }


// Add estado
function addEstado($estado){
  global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

  $con = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

  $sql = "INSERT INTO estado (estado, user_iduser) VALUES ('".
     $estado."', '".
    $_SESSION['idUser'] ."')";

  $result = mysqli_query($con,$sql);


  exit();
}
function addCiudad($ciudad,$idEstado){
  global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

  $con = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

  $sql = "INSERT INTO ciudad (ciudad, estado_idestado) VALUES ('".
    $ciudad ."', '".
    $idEstado ."')";

  $result = mysqli_query($con,$sql);

  exit();
}
?>
