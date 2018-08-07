<?php

$idProveedor = '';
$nombreProveedor = '';

// if(isset($_POST['Buscar'])){
//     searchProveedores();
// }
if(isset($_POST['idProveedor'])){
  goToProveedor();
}
if(isset($_POST['tablaSQLProveedores'])){

    $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLProveedores']);

    updateSQLTable();
}

function searchProveedores(){
    global $searchText;
    $_SESSION['searchMethod'] = 'nombre';
    if(isset($_POST['Nombre'])){
      $_SESSION['searchText'] = $_POST['Nombre'];
    }
    else{
      $_SESSION['searchText'] = "";
    }

    searchProveedor();
}

function searchProveedor(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idProveedor,
    $nombreProveedor;

    $sqlFrom = 'proveedores';
    $searchMethod = 'nombre';

    echo '<div class="bigTableContainer"> <table class="tableProveedoresSQL" id="tableProveedoresSQL">';
    echo
        "<tr class='trTableTop'><td>ID
        </td><td>Nombre
        </td><td>Telefono
        </td><td>Direccion
        </td><td>Comisión
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
             "<tr class='trTableProveedores'id=editable>
             <td class='idProveedor'>" . $row['idProveedor'] .
             "</td><td class='nombre' contenteditable=true>" . $row['nombre'] .
             "</td><td class='telefono' contenteditable=true>" . $row['telefono'] .
             "</td><td class='direccion' contenteditable=true>" . $row['direccion'] .
             "</td><td class='comision' contenteditable=true>". $row['comision'] .
             "</td> ";
          }

          echo
          "<tr class='trTableProveedores'id=editable>".
           "<td class='idProveedor'>".
           "</td><td class='nombre' contenteditable=true>".
           "</td><td class='telefono'contenteditable=true>".
           "</td><td class='direccion' contenteditable=true>".
           "</td><td class='comision' contenteditable=true>".
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
    $tableID = 'idProveedor';
    $sqlFrom = 'proveedor';

    $newTable = $_SESSION['tablaSQL'];
    for ($i=0; $i < count($newTable)-1; $i++) {
      $idTuple = $newTable[$i][0];

      $updateName = 'nombre';
      $updateValue = $newTable[$i][1];
      sqlUpdate();
      $updateName = 'telefono';
      $updateValue = $newTable[$i][2];
      sqlUpdate();
      $updateName = 'direccion';
      $updateValue = $newTable[$i][3];
      sqlUpdate();
      $updateName = 'comision';
      $updateValue = $newTable[$i][4];
      sqlUpdate();

    }


    if($newTable[count($newTable)-1][1]!=''){
        addProveedor($newTable[count($newTable)-1]);
    }
  }
  function addProveedor($lastRow){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql = 'INSERT INTO proveedor (nombre, telefono, direccion, comision) VALUES ("' .
      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'")';



    $result = mysqli_query($con,$sql);
    $lastID  = mysqli_insert_id($con);

    $sql =  "INSERT INTO user_has_proveedor (user_iduser, Proveedor_idProveedor) VALUES ('". $_SESSION['idUser'] . "', '" . $lastID . "')";


    $result = mysqli_query($con,$sql);
    mysqli_close($con);




  }
  function goToProveedor(){
    $_SESSION['searchMethod'] = 'idProveedor';
    $_SESSION['searchText'] = $_POST['idProveedor'];

    header("Location: /bdd-pautas/html/proveedorInfo.php");
    exit();
  }
?>
