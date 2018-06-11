<?php
if(isset($_POST['tablaSQLTelevisiones'])){

    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLTelevisiones']);

    updateSQLTable();
}


function setAll(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,
    $idTarifa,
    $nombre,
    $estado,
    $ciudad,
    $canal,
    $siglas,
    $idProveedor,
    $idTelevision;

    $sqlFrom = 'televisiones';

    $idTelevision = $_SESSION['idTelevision'];




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
          $estado =  $row['estado'];
          $ciudad =  $row['ciudad'];
          $canal =  $row['canal'];
          $siglas =  $row['siglas'];
          $idProveedor =  $row['idProveedor'];
        }
      }else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
      }
      mysqli_close($con);
}
function printNombreTelevision(){
  global $nombre;
  echo $nombre;
}




function searchTelevisiones(){
    global $searchText;
    $_SESSION['searchMethod'] = 'duracion';
    $_SESSION['searchText'] = $_POST['Nombre'];
    header("Location: /bdd-pautas/html/tarifaTelevision.php");
}

function searchTarifa(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,
    $idTelevision,
    $idTarifa,
    $nombreTarifa;

    $sqlFrom = 'tarifasTelevision';
    $searchMethod = 'duracion';

    echo '<div class="bigTableContainer"> <table class="tableTelevisionesSQL" id="tableTelevisionesSQL">';
    echo
        "<tr class='trTableTop'><td>ID
        </td><td>Programa
        </td><td>Duracion
        </td><td>Tarifa General
        </td><td>Tarifa Especifica
        </td><td>Descuento
        </td><td>Horario Inicio
        </td><td>Horario Fin
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
             <td class='idTarifa'>" . $row['idTarifa'] .
             "</td><td class='programa' contenteditable=true>" . $row['programa'] .
             "</td><td class='duracion' contenteditable=true>" . $row['duracion'] .
             "</td><td class='tarifaGeneral' contenteditable=true>" . $row['tarifaGeneral'] .
             "</td><td class='tarifaEspecifica' contenteditable=true>" . $row['tarifaEspecifica'] .
             "</td><td class='descuento'contenteditable=true>" . $row['descuento'] .
             "</td><td class='horaInicio'><input type='time' value=" . $row['horaInicio'] .">".
             "</td><td class='horaFin'><input type='time' value=" . $row['horaFin'] .">".
             "</td></tr>";

          }

          echo
          "<tr class='trTableTelevisiones'id=editable>
          <td class='idTarifa'>" .
          "</td><td class='programa' contenteditable=true>" .
          "</td><td class='duracion' contenteditable=true>" .
          "</td><td class='tarifaGeneral' contenteditable=true>" .
          "</td><td class='tarifaEspecifica' contenteditable=true>" .
          "</td><td class='descuento'contenteditable=true>" .
          "</td><td class='horaInicio'><input type='time'>" .
          "</td><td class='horaFin'><input type='time'>" .
          "</td></tr>";

        echo"</table></div>";
    } else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
    }
    mysqli_close($con);



  }
  function updateSQLTable(){


    global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple,
    $idTelevision,$sql;
    $tableID = 'idTarifa';
    $sqlFrom = 'tarifaTelevision';

    $newTable = $_SESSION['tablaSQL'];
    for ($i=0; $i < count($newTable)-1; $i++) {
      $idTuple = $newTable[$i][0];

      $updateName = 'programa';
      $updateValue = $newTable[$i][1];
      sqlUpdate();
      $updateName = 'duracion';
      $updateValue = $newTable[$i][2];
      sqlUpdate();
      $updateName = 'tarifaGeneral';
      $updateValue = $newTable[$i][3];
      sqlUpdate();
      $updateName = 'tarifaEspecifica';
      $updateValue = $newTable[$i][4];
      sqlUpdate();
      $updateName = 'descuento';
      $updateValue = $newTable[$i][5];
      sqlUpdate();
      $updateName = 'horaInicio';
      $updateValue = $newTable[$i][6];
      sqlUpdate();
      $updateName = 'horaFin';
      $updateValue = $newTable[$i][7];
      sqlUpdate();

    }


    if($newTable[count($newTable)-1][1]!=''){
        addTarifa($newTable[count($newTable)-1]);
    }else{

      $result = mysqli_query($con,$sql);
      mysqli_close($con);

      $_SESSION['searchMethod'] = 'idTelevision';
      $_SESSION['searchText'] =$_SESSION['idTelevision'];


      header("Location: /bdd-pautas/html/tarifaTelevision.php");
    }
  }

  function addTarifa($lastRow){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple,
    $idTelevision;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }



    $sql = 'INSERT INTO tarifaTelevision (Television_idTelevision, programa, duracion, tarifaGeneral, tarifaEspecifica, descuento, horaInicio, horaFin) VALUES ("' .
      $_SESSION['idTelevision'] .'","' .
      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'","' .
      $lastRow[5] .'","' .
      $lastRow[6] .'","' .
      $lastRow[7] .'")';

      echo '<script language="javascript">';
      echo 'alert("'.$sql.'")';
      echo '</script>';

    $result = mysqli_query($con,$sql);

    $_SESSION['searchMethod'] = 'idTelevision';
    $_SESSION['searchText'] =$_SESSION['idTelevision'];

    header("Location: /bdd-pautas/html/tarifaTelevision.php");


  }

?>
