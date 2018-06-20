<?php

$idPauta = '';
$nombre = '';
$presupuesto = '';
$invTotal = '';
$tablaRadioIdTarifas = '';
$tablaPautas = '';

if(isset($_SESSION['idPauta'])){
    global $idPauta;
    $idPauta = $_SESSION['idPauta'];
    setPautasRadio();
}
if(isset($_POST['estadoChange'])){
  estadoChange($_POST['estadoChange'],$_POST['parentID']);
}

function searchRadios(){
    global $searchText;
    $_SESSION['searchMethod'] = 'estacion';
    $_SESSION['searchText'] = $_POST['Estacion'];
    header("Location: /bdd-pautas/html/radios.php");
}

function printPautaNombre(){
  global $nombre;
  echo $nombre;
}

function setPautasRadio(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idPauta,
    $nombre,
    $presupuesto,
    $invTotal;

    $sqlFrom = 'pautas';
    $searchMethod = 'idPauta';

   if (isset($_SESSION['searchMethod'])){
       $searchMethod=$_SESSION['searchMethod'];
   }

   $searchText = $idPauta;
    sqlSearch();

    if($result != null){
      $row = mysqli_fetch_array($result);
      $nombre = $row['nombre'];
      $presupuesto = $row['presupuesto'];
      $invTotal = $row['invTotal'];
    } else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
    }
    mysqli_close($con);

  }
  function setTablePautas(){
      global $servername, $username, $password, $dbname, $user, $pwd, $result,$con,$row,

      $idPauta,
      $nombreCliente;

      setTablaRadios();

      $sqlFrom = 'pautasRadioIdTarifas';
      $searchMethod ='idPauta';
      $searchText = $idPauta;

      sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

      if($result != null){
        $i=0;
          while($row = mysqli_fetch_array($result))
            {
              $tablaPautas[$i]=$row;
              $i=$i+1;
            }
      }
      $r="<table class=tablePautas>".
      "<tr class=tablePautasHeaders>".
        "<td>".
          "<a>ID</a>".
        "</td>".
        "<td>".
          "<p>Estado</p>".
        "</td>".
        "<td>".
        "<p>Ciudad</p>".
        "</td>".
        "<td>".
          "<p>Estacion</p>".
        "</td>".
        "<td>".
          "<p>Frecuencia</p>".
        "</td>".
        "<td>".
          "<p>Siglas</p>".
        "</td>".
        "<td class=fechasHeader>".
          "<p>Fechas</p>".
        "</td>".
        "<td>".
          "<p>Spots</p>".
        "</td>".
        "<td>".
          "<p>Inversion</p>".
        "</td>".
        "<td>".
          "<p>Rating</p>".
        "</td>".
        "<td>".
          "<p>GRP's</p>".
        "</td>".
        "<td>".
          "<p>Impactos</p>".
        "</td>".
        "<td>".
          "<p>Inversion</p>".
        "</td>".
        "<td>".
          "<p>Comision</p>".
        "</td>".
      "</tr>";
      if (isset($tablaPautas)){
      for ($j=0; $j < count($tablaPautas); $j++) {
              $idTarifa = $tablaPautas[$j]['idTarifa'];

               $r = $r. "<tr class='pautaIndividual' id='".$idTarifa."'>".
                 "<td>".
                   "<p id='idTarifa'>". $idTarifa ."</p>".
                 "</td>".
                 "<td>".
                   "<select id='estado' onchange=estadosChange(this)>". selectEstados($idTarifa) ."</select>".
                 "</td>"."<td>".
                   "<select id='ciudad'>". selectCiudades($idTarifa) ."</select>".
                 "</td>".
                 "<td>".
                   "<select id='estacionSelect'>".selectEstaciones($idTarifa)."</select>".
                 "</td>".
                 "<td>".
                   "<select id='frecuenciaSelect'>".selectFrecuencias($idTarifa)."</select>".
                 "</td>".
                 "<td>".
                   "<select id='siglasSelect'>".selectSiglas($idTarifa)."</select>".
                 "</td>".
                 "<td class=innerTD>".
                   "<div  id=calendar class=calendar></div>".
                 "</td>".
                 "<td>".
                   "<p>Spots</p>".
                 "</td>".
                 "<td>".
                   "<p>Inversion</p>".
                 "</td>".
                 "<td>".
                   "<p>Rating</p>".
                 "</td>".
                 "<td>".
                   "<p>GRP's</p>".
                 "</td>".
                 "<td>".
                   "<p>Impactos</p>".
                 "</td>".
                 "<td>".
                   "<p>Inversion</p>".
                 "</td>".
                 "<td>".
                   "<p>Comision</p>".
                 "</td>".
               "</tr>";
            }

          }
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);

      mysqli_close($con);

      echo $r;
      echo '<script language="javascript">';
      echo "displayTable();";
      echo '</script>';
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


  function selectEstados($idTarifa){
    global $tablaRadioIdTarifas,
    $tablaRadios;

    setTablaRadioIdTarifas($idTarifa);

    $r='';
    for ($j=0; $j < count($tablaRadios); $j++) {
      if($tablaRadios[$j]['idRadio'] == $tablaRadioIdTarifas[0]['idRadio']){
        $r = $r.
        "<option value='". $tablaRadios[$j]['estado'] ."' selected='selected'>"
        .  $tablaRadios[$j]['estado'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaRadios[$j]['estado'] ."'>"
        . $tablaRadios[$j]['estado'] ."</option>";
        }
      }
      return $r;

    }

  function selectCiudades($idTarifa){
    global $tablaRadioIdTarifas,
    $tablaRadios;

    setTablaRadioIdTarifas($idTarifa);

    $r='';
    for ($j=0; $j < count($tablaRadios); $j++) {
      if($tablaRadios[$j]['idRadio'] == $tablaRadioIdTarifas[0]['idRadio']){
        $r = $r.
        "<option value='". $tablaRadios[$j]['ciudad'] ."' selected='selected'>"
        .  $tablaRadios[$j]['ciudad'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaRadios[$j]['ciudad'] ."'>"
        . $tablaRadios[$j]['ciudad'] ."</option>";
        }
      }
      return $r;

    }

  function selectEstaciones($idTarifa){
    global $tablaRadioIdTarifas,
    $tablaRadios;

    setTablaRadioIdTarifas($idTarifa);

    $r='';
    for ($j=0; $j < count($tablaRadios); $j++) {
      if($tablaRadios[$j]['idRadio'] == $tablaRadioIdTarifas[0]['idRadio']){
        $r = $r.
        "<option value='". $tablaRadios[$j]['estacion'] ."' selected='selected'>"
        .  $tablaRadios[$j]['estacion'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaRadios[$j]['estacion'] ."'>"
        . $tablaRadios[$j]['estacion'] ."</option>";
        }
      }
      return $r;

    }


  function selectFrecuencias($idTarifa){
    global $tablaRadioIdTarifas,
    $tablaRadios;

    setTablaRadioIdTarifas($idTarifa);

    $r='';
    for ($j=0; $j < count($tablaRadios); $j++) {
      if($tablaRadios[$j]['idRadio'] == $tablaRadioIdTarifas[0]['idRadio']){
        $r = $r.
        "<option value='". $tablaRadios[$j]['frecuencia'] ."' selected='selected'>"
        .  $tablaRadios[$j]['frecuencia'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaRadios[$j]['frecuencia'] ."'>"
        . $tablaRadios[$j]['frecuencia'] ."</option>";
        }
      }
      return $r;

    }

  function selectSiglas($idTarifa){
    global $tablaRadioIdTarifas,
    $tablaRadios;

    setTablaRadioIdTarifas($idTarifa);

    $r='';
    for ($j=0; $j < count($tablaRadios); $j++) {
      if($tablaRadios[$j]['idRadio'] == $tablaRadioIdTarifas[0]['idRadio']){
        $r = $r.
        "<option value='". $tablaRadios[$j]['siglas'] ."' selected='selected'>"
        .  $tablaRadios[$j]['siglas'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaRadios[$j]['siglas'] ."'>"
        . $tablaRadios[$j]['siglas'] ."</option>";
        }
      }
      return $r;

    }

  function selectTarifas($idTarifa){
    global $tablaRadioIdTarifas,
    $tablaRadios;

    setTablaRadioIdTarifas($idTarifa);

    $r='';
    for ($j=0; $j < count($tablaRadios); $j++) {
      if($tablaRadios[$j]['idRadio'] == $tablaRadioIdTarifas[0]['idRadio']){
        $r = $r.
        "<option value='". $tablaRadioIdTarifas[0]['tarifaGeneral'] ."' selected='selected'>"
        .  $tablaRadioIdTarifas[0]['tarifaGeneral'].
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaRadioIdTarifas[0]['tarifaGeneral'] ."'>"
        . $tablaRadioIdTarifas[0]['tarifaGeneral'] ."</option>";
        }
      }
      return $r;

    }

  function setTablaRadios(){
    global $servername, $username, $password, $dbname, $user, $pwd, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
    $tablaRadios;

    // Buscar Radios
    $sqlFrom = 'radios';
    $searchMethod="estado";
    $searchText = "";

    sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

    if($result != null){
      $i=0;
        while($row = mysqli_fetch_array($result))
          {
            $tablaRadios[$i]=$row;
            $i=$i+1;
          }
    }


  }
  function setTablaRadioIdTarifas($idTarifa){
    global $servername, $username, $password, $dbname, $user, $pwd, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
    $tablaRadioIdTarifas;

    // Buscar Tabla Relacional
    $sqlFrom = 'pautasradioidtarifas';
    $searchMethod="idTarifa";
    $searchText = $idTarifa;

    sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

    if($result != null){
      $i=0;
        while($row = mysqli_fetch_array($result))
          {
            $tablaRadioIdTarifas[$i]=$row;
            $i=$i+1;
          }
    }
  }
  function estadoChange($estado,$parentID){
    echo $estado . "-" .$parentID;
    // global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple;
    //
    // $tableID = 'idRadio';
    // $sqlFrom = 'radio';
    //
    // $newTable = $_SESSION['tablaSQL'];
    // for ($i=0; $i < count($newTable)-1; $i++) {
    //   $idTuple = $newTable[$i][0];
    //
    //   $updateName = 'estacion';
    //   $updateValue = $newTable[$i][1];
    //   sqlUpdate();
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

?>
