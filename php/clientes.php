<?php

  $idCliente = '';
  $nombreCliente = '';
  $numPautas = '';

  if(isset($_POST['Buscar'])){
      searchClientes();
  }
  if(isset($_POST['Nuevo'])){
      goToAddCliente();
  }
  if(isset($_POST['idCliente'])){
      $_SESSION['idCliente'] = $_POST['idCliente'];
      goToCliente();
  }
  function searchClientes(){
      global $searchText;
      $_SESSION['searchText'] = $_POST['Nombre'];
      header("Location: /bdd-pautas/html/clientes.php");
  }
  function searchCliente(){
      global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

      $idCliente,
      $nombreCliente;

      $sqlFrom = 'clientes';
      $searchMethod = 'nombre';

      echo '<table class="tableClientesSQL">';
      echo
          "<tr class='trTableTop'><td>ID
          </td><td>Nombre
          </td><td>Contacto
          </td><td>Mail
          </td><td>RFC
          </td><td>Direccion
          </td><td>Pautas
          </td></tr>
           ";
      sqlSearch();

      if($result != null){
          while($row = mysqli_fetch_array($result))
            {
              echo
               "<tr class='trTableClientes'>
               <td class='idCliente'>" . $row['idCliente'] .
               "</td><td>" . $row['nombre'] .
               "</td><td>" . $row['contacto'] .
               "</td><td>" . $row['mail'] .
               "</td><td>" . $row['rfc'] .
               "</td><td>" . $row['direccion'] .
               "</td><td>" . $row['numPautas'] .
               "</td></tr> ";
            }

      }
  }
  function goToCliente(){
    header("Location: /bdd-pautas/html/clienteInfo.php");
    exit();
  }
  function goToAddCliente(){
    header("Location: /bdd-pautas/html/clienteNuevo.php");
    exit();
  }

?>
