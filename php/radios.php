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

    $sqlFrom = 'radios';
    $searchMethod = 'estacion';

    echo '<div class="bigTableContainer"> <table class="tableRadiosSQL" id="tableRadiosSQL">';
    echo
        "<tr class='trTableTop'><td>ID
        </td><td>Estacion
        </td><td>Frecuencia
        </td><td>Siglas
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
             "</td><td class='frecuencia'contenteditable=true>" . $row['frecuencia'] .
             "</td><td class='siglas' contenteditable=true>" . $row['siglas'] .
             "</td> ";
          }

          echo
          "<tr class='trTableRadios'id=editable>".
           "<td class='idRadio'>".
           "</td><td class='estacion' contenteditable=true>".
           "</td><td class='frecuencia'contenteditable=true>".
           "</td><td class='siglas' contenteditable=true>".
           "</td></tr> ";

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
      $updateName = 'frecuencia';
      $updateValue = $newTable[$i][2];
      sqlUpdate();
      $updateName = 'siglas';
      $updateValue = $newTable[$i][3];
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

    $sql = 'INSERT INTO radio (estacion, frecuencia, siglas) VALUES ("' .
      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'")';



    $result = mysqli_query($con,$sql);
    $lastID  = mysqli_insert_id($con);

    $sql =  "INSERT INTO user_has_radio (user_iduser, Radio_idRadio) VALUES ('". $_SESSION['idUser'] . "', '" . $lastID . "')";


    $result = mysqli_query($con,$sql);
    mysqli_close($con);

    $_SESSION['searchMethod'] = 'estacion';
    $_SESSION['searchText'] = '';

    searchRadios();


  }
  function goToRadio(){
    $_SESSION['searchMethod'] = 'idRadio';
    $_SESSION['searchText'] = $_POST['idRadio'];

    header("Location: /bdd-pautas/html/radioInfo.php");
    exit();
  }
?>
