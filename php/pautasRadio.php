<?php

$idPauta = '';
$nombre = '';
$presupuesto = '';
$invTotal = '';
$tablaRadioIdTarifas = '';
$tablaPautas = '';
$tablaTarifas ='';

if(isset($_SESSION['idPauta'])){
    global $idPauta;
    $idPauta = $_SESSION['idPauta'];
    setPautasRadio();
}
if(isset($_POST['estadoChange'])){
  estadoChange($_POST['estadoChange'],$_POST['parentID']);
}
//Ajax change of Estado
if(isset($_POST['estadoID'])){
  estadoChange($_POST['estadoID']);
}
//Ajax change of Ciudad
if(isset($_POST['ciudadID'])){
  ciudadChange($_POST['ciudadID']);
}
//Ajax change of spots date per day
if(isset($_POST['getSpotsCalendar'])){
  //Recibe fecha inicio y fecha fin
  getSpotsCalendar($_POST['iDiaSpot'],($_POST['iMesSpot']+1),$_POST['iAñoSpot'],$_POST['fDiaSpot'],($_POST['fMesSpot']+1),$_POST['fAñoSpot'],$_POST['idPautaRenglon']);

  exit();
}
//Ajax change of spots date per day
if(isset($_POST['getSpotsDia'])){

  getSpotsDia($_POST['diaSpot'],($_POST['mesSpot']+1),$_POST['añoSpot'],$_POST['idPautaRenglon']);

  exit();
}
//Ajax update spots for day

if(isset($_POST['tablaModalSpots'])){

  updateModalTable(json_decode($_POST['tablaModalSpots']));
  exit();
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
      global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,
      $tablaRadios,
      $tablaEstaciones,
      $idPauta,
      $nombreCliente;

      setTablaRadios();

      $sqlFrom = 'pautasRadio';
      $searchMethod ='idPauta';
      $searchText = $idPauta;

      $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

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
          "<p>Estacion | Frecuencia | Siglas</p>".
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
              $idPautaRadio = $tablaPautas[$j]['idPautaRadio'];
              $idEstado = $tablaPautas[$j]['idestado'];
              $idCiudad = $tablaPautas[$j]['idciudad'];

               $r = $r. "<tr class='pautaIndividual' id='".$idPautaRadio."'>".
                 "<td>".
                   "<p id='idTarifa'>". $idPautaRadio ."</p>".
                 "</td>".
                 "<td id='estado' onchange = estadosChange(this)>".
                   "<select>". selectEstados($idEstado) ."</select>".
                 "</td>"."<td id='ciudad' class='ciudad' onchange = ciudadesChange(this)>".
                   "<select>". selectCiudades($idCiudad,$idEstado) ."</select>".
                 "</td>".
                 "<td id='estacion' class='estacion'>".
                   "<select id='estacionSelect'>".selectEstaciones($idPautaRadio,$idCiudad)."</select>".
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


  function selectEstados($idEstado){
    global $tablaEstados;

    setTablaEstados($idEstado);

    $r='';
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

  function selectEstaciones($idRadio,$idCiudad){
    global $tablaEstaciones;

    setTablaEstaciones($idRadio,$idCiudad);

    $r='';
    for ($j=0; $j < count($tablaEstaciones); $j++) {

      if($tablaEstaciones[$j]['idRadio'] == $idRadio){
        $r = $r.
        "<option value='". $tablaEstaciones[$j]['idRadio'] ."' selected='selected'>"
        . $tablaEstaciones[$j]['estacion'] ." | ". $tablaEstaciones[$j]['frecuencia'] ." | ". $tablaEstaciones[$j]['siglas'] .
        "</option>";}
      else{
        $r = $r.
        "<option value='". $tablaEstaciones[$j]['idRadio'] ."'>"
        . $tablaEstaciones[$j]['estacion'] ." | ". $tablaEstaciones[$j]['frecuencia'] ." | ". $tablaEstaciones[$j]['siglas'] ."</option>";

        }
      }
      return $r;
  }

  function selectTarifas($idTarifa){
    global $tablaEstaciones,
    $tablaRadios;

    setTablaEstaciones($idRadio,$idCiudad);

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

function setTablaEstaciones($idRadio,$idCiudad){
  global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
  $tablaEstaciones;

  // Buscar Tabla Relacional
  $sqlFrom = 'radios';
  $searchMethod="idCiudad";
  $searchText = $idCiudad;

  $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

  if($result != null){
    $i=0;
      while($row = mysqli_fetch_array($result))
        {
          $tablaEstaciones[$i]=$row;
          $i=$i+1;
        }
  }
}

function ciudadChange($ciudad){

  global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
  $tablaEstados;

  $sqlFrom = 'radios';
  $searchMethod="idciudad";
  $searchText = $ciudad;

  $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

  $r='';

  if($result != null){
    $i=0;
      while($row = mysqli_fetch_array($result))
        {
          $r[$i]['idRadio'] = $row['idRadio'];
          $r[$i]['estacion'] = $row['estacion'];
          $r[$i]['frecuencia'] = $row['frecuencia'];
          $r[$i]['siglas'] = $row['siglas'];

          $i=$i+1;
        }
  }
  echo json_encode($r);
  exit();
}

function getNumSpotsDia($dia,$mes,$año,$idPautaRadio){
  //Suma de spots por dia especifico
  global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
  $tablaSpots;

  // Buscar Tabla Relacional
  $sqlFrom = 'spotsRadio';
  $searchMethod="idPautaRadio";
  $searchText = $idPautaRadio;

  $sql= "SELECT sum(cantidad) as cantidad from spotsradio where idUser = ".$_SESSION['idUser']." and fecha like DATE_FORMAT('". $año . "-" . $mes . "-" . $dia . "', '%Y-%m-%d') and idPautaRadio = " . $idPautaRadio;

  $result = sqlSearchSpecificQuery($sql);

  if($result != null){
    $row = mysqli_fetch_array($result);
    $r=$row['cantidad'];
  }
  if($r == null){
    $r = 0;
  }
  return $r;

}

function getSpotsDia($dia,$mes,$año,$idPautaRadio){
  global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
  $tablaSpots;

  // Buscar Tabla Relacional
  $sql= "SELECT * FROM spotsradio where fecha = DATE_FORMAT('". $año . "-" . $mes . "-" . $dia . "', '%Y-%m-%d') and idPautaRadio = " . $idPautaRadio . " and idUser = " . $_SESSION['idUser'];
  $result = sqlSearchSpecificQuery($sql);

  $r = "<div class=bigTableContainer> <table class = spotsRadioDia id = spotsRadioDia>" .
  "<tr class='spotsRadioDiaHeaders'><td>idSpot</td>" .
  "<td>Hora</td>" .
  "<td>Cantidad</td>" .
  "<td>Duracion | Tarifa General | Tarifa Especifica | Descuento</td></tr>";

  if($result != null){
    $i=0;
      while($row = mysqli_fetch_array($result))
        {
          $r = $r .
          "<tr class='trTableRadios'><td id=idSpot>" .  $row['idSpot'] . "</td>" .
          "<td id=hora><input type=time value=" . $row['hora'] . "></td>" .
          "<td id=cantidad><input type=number value=" . $row['cantidad'] . "></td>" .
          "<td id=duracion><select>".setSelectTarifa($row['idTarifa'], $idPautaRadio) ."</select></td></tr>";
        }
  }
    $r = $r .
    "<tr class='trTableRadios'><td id=idSpot></td>" .
    "<td id=hora><input type=time></td>" .
    "<td id=cantidad><input type=number></td>" .
    "<td id=duracion><select>". setSelectTarifa(0, $idPautaRadio) ."</select></td></tr>";
    $r = $r . "</table>";

    echo $r;

}
function setSelectTarifa($idTarifa, $idPautaRadio){
  global $tablaTarifas;

  setTablaPautasRadio($idPautaRadio);

  $r = '';

  for ($i=0; $i < count($tablaTarifas); $i++) {
    if($tablaTarifas[$i]['idTarifa'] == $idTarifa){

      $r = $r .
      "<option value='". $tablaTarifas[$i]['idTarifa'] ."' selected='selected'>"
      .  $tablaTarifas[$i]['duracion']  ." | $"  . $tablaTarifas[$i]['tarifaGeneral'] . " | $"  . $tablaTarifas[$i]['tarifaEspecifica'] . " | " . $tablaTarifas[$i]['descuento'] . "</option>";}
    else{
      $r = $r .
      "<option value='". $tablaTarifas[$i]['idTarifa'] ."'>"
      .  $tablaTarifas[$i]['duracion']  ." | $"  . $tablaTarifas[$i]['tarifaGeneral'] . " | $"  . $tablaTarifas[$i]['tarifaEspecifica'] . " | " . $tablaTarifas[$i]['descuento'] . "</option>";
      }
    }
    return $r;
}
function setTablaPautasRadio($idPautaRadio){
  global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
  $tablaTarifas;

  // Buscar Tabla Relacional
  $sqlFrom = 'tarifasPautasRadio';
  $searchMethod="idPautaRadio";
  $searchText = $idPautaRadio;

  $result = sqlSearchSpecific($sqlFrom,$searchMethod,$searchText);

  if($result != null){
    $i=0;
    while($row = mysqli_fetch_array($result))
      {
        $tablaTarifas[$i]=$row;
        $i=$i+1;
      }
  }
}
function getSpotsCalendar($iDiaSpot,$iMesSpot,$iAñoSpot,$fDiaSpot,$fMesSpot,$fAñoSpot,$idPautaRenglon){
  global $servername, $username, $password, $dbname, $user, $pwd,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

  $r=[];
  // Buscar Tabla Relacional
  $sqlFrom = 'spotsRadio';
  $searchMethod="idPautaRadio";
  $searchText = $idPautaRenglon;

  $sql = "
  SELECT
    	sum(cantidad) as cantidad,
      fecha,
      idSpot,
      idPautaRadio
    FROM
        spotsradio
    WHERE
        fecha BETWEEN DATE_FORMAT('".$iAñoSpot."-%".$iMesSpot."-%".$iDiaSpot."', '%Y-%m-%d') AND DATE_FORMAT('".$fAñoSpot."-%".$fMesSpot."-%".$fDiaSpot."', '%Y-%m-%d')
            AND idPautaRadio = ".$idPautaRenglon."
            AND idUser = ". $_SESSION['idUser']."
      group by fecha
      ;"
    ;

    $result = sqlSearchSpecificQuery($sql);

    if($result != null){
      $i=0;
      while($row = mysqli_fetch_array($result))
        {
          $r[$i]=$row;
          $i=$i+1;
        }
    }
    if($r == null){
      $r[0] = 0;
    }
    echo json_encode($r);

}



// Manipulación de tabla de modales


function updateModalTable($newTable){
  global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple;


  for ($i=0; $i < count($newTable)-1; $i++) {

    $tableID = 'idSpot';
    $sqlFrom = 'spot';

    $idTuple = $newTable[$i][0];

    $updateName = 'hora';
    $updateValue = $newTable[$i][1];
    sqlUpdate();


    $updateName = 'cantidad';
    $updateValue = $newTable[$i][2];
    sqlUpdate();

    $updateName = 'tarifaRadio_idTarifa';
    $updateValue = $newTable[$i][3];
    sqlUpdate();

  }


  if($newTable[count($newTable)-1][1]!=''){
      addSpot($newTable[count($newTable)-1]);
  }
}
function addSpot($lastRow){
  global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

  $con = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

  $sql = 'INSERT INTO spot (fecha, hora, cantidad, renglonPauta_idRenglonPauta, tarifaRadio_idTarifa) VALUES ("' .
      $lastRow[4] .'","' .
      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[5] .'","' .
      $lastRow[3] .'")';



  $result = mysqli_query($con,$sql);




  $_SESSION['searchMethod'] = 'estacion';
  $_SESSION['searchText'] = '';

  searchRadios();


}
?>
