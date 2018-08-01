<?php

  $idCliente = '';
  $nombreCliente = '';
  $numPautas = '';

  // if(isset($_POST['Buscar'])){
  //     searchClientes();
  // }
  if(isset($_POST['Nuevo'])){
      goToAddCliente();
  }
  if(isset($_POST['idCliente'])){
      goToCliente();
  }
  if(isset($_POST['tablaSQLClientes'])){
      $_SESSION['tablaSQL'] = json_decode($_POST['tablaSQLClientes']);
      updateSQLTable();
  }
  function searchClientes(){
      global $searchText;
      $_SESSION['searchMethod'] = 'nombre';

      if(isset($_POST['Nombre'])){
        $_SESSION['searchText'] = $_POST['Nombre'];
      }
      else{
        $_SESSION['searchText'] = "";
      }

      searchCliente();
  }
  function searchCliente(){
      global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

      $idCliente,
      $nombreCliente;

      $sqlFrom = 'clientes';

      echo '<div class="bigTableContainer"> <table class="tableClientesSQL" id="tableClientesSQL">';
      echo
          "<tr class='trTableTop'><td>ID
          </td><td>Nombre
          </td><td>Contacto
          </td><td>Mail
          </td><td>Telefono
          </td><td>RFC
          </td><td>Direccion
          </td><td>Pautas
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
               "<tr class='trTableClientes'id=editable>
               <td class='idCliente'>" . $row['idCliente'] .
               "</td><td class='nombre' contenteditable=true>" . $row['nombre'] .
               "</td><td class='contacto'contenteditable=true>" . $row['contacto'] .
               "</td><td class='mail' contenteditable=true>" . $row['mail'] .
               "</td><td class='mail' contenteditable=true>" . $row['telefono'] .
               "</td><td class='rfc' contenteditable=true>" . $row['rfc'] .
               "</td><td class='direccion' contenteditable=true>" . $row['direccion'] .
               "</td><td class='numPautas'>" . $row['numPautas'] .
               "</td> ";
            }

            echo
            "<tr class='trTableClientes'id=editable>".
             "<td class='idCliente'>".
             "</td><td class='nombre' contenteditable=true>".
             "</td><td class='contacto'contenteditable=true>".
             "</td><td class='mail' contenteditable=true>".
             "</td><td class='telefono' contenteditable=true>".
             "</td><td class='rfc' contenteditable=true>".
             "</td><td class='direccion' contenteditable=true>".
             "</td><td class='numPautas'>".
             "</td></tr> ";

          echo"</table></div>";
      } else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
      }
      mysqli_close($con);
    }



  function goToCliente(){
    $_SESSION['searchMethod'] = 'idCliente';
    $_SESSION['searchText'] = $_POST['idCliente'];
    $_SESSION['idCliente'] = $_POST['idCliente'];


    header("Location: /bdd-pautas/html/clienteInfo.php");
    exit();
  }
  function goToAddCliente(){
    header("Location: /bdd-pautas/html/clienteNuevo.php");
    exit();
  }
  function updateSQLTable(){

    global $searchText, $sqlFrom,$updateName,$updateValue,$tableID,$idTuple;
    $tableID = 'idCliente';
    $sqlFrom = 'cliente';

    $newTable = $_SESSION['tablaSQL'];
    for ($i=0; $i < count($newTable)-1; $i++) {
      $idTuple = $newTable[$i][0];

      $updateName = 'nombre';
      $updateValue = $newTable[$i][1];
      sqlUpdate();
      $updateName = 'contacto';
      $updateValue = $newTable[$i][2];
      sqlUpdate();
      $updateName = 'mail';
      $updateValue = $newTable[$i][3];
      sqlUpdate();
      $updateName = 'telefono';
      $updateValue = $newTable[$i][4];
      sqlUpdate();
      $updateName = 'rfc';
      $updateValue = $newTable[$i][5];
      sqlUpdate();
      $updateName = 'direccion';
      $updateValue = $newTable[$i][6];
      sqlUpdate();
    }

    if($newTable[count($newTable)-1][1]!=''){
        addCliente($newTable[count($newTable)-1]);
    }


  }
  function addCliente($lastRow){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql = 'INSERT INTO cliente (nombre, contacto, mail, telefono, rfc, direccion) VALUES ("' .
      $lastRow[1] .'","' .
      $lastRow[2] .'","' .
      $lastRow[3] .'","' .
      $lastRow[4] .'","' .
      $lastRow[5] .'","' .
      $lastRow[6] .'")';



    $result = mysqli_query($con,$sql);
    $lastID  = mysqli_insert_id($con);

    $sql = "INSERT INTO user_has_cliente (user_iduser,Cliente_idCliente) VALUES ('". $_SESSION['idUser'] . "', '" . $lastID . "')"  ;

    $result = mysqli_query($con,$sql);
    mysqli_close($con);

    $_SESSION['searchMethod'] = 'nombre';
    $_SESSION['searchText'] = '';

    searchClientes();


  }
?>
