<?php

  $idCliente = '';
  $nombreCliente = '';
  $numPautas = '';

  if(isset($_POST['Buscar'])){
      searchClientes();
  }

  if(isset($_POST['add'])){
      addCliente();
  }
  if(isset($_POST['idCliente'])){
      goToCliente();
  }
  function searchClientes(){
      global $searchText;

      $_SESSION['searchText'] = $_POST['Nombre'];
      $_SESSION['searchMethod'] = "nombre";
      header("Location: /bdd-pautas/html/clientes.php");
  }
  function searchCliente(){
      global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

      $idCliente,
      $nombreCliente;

      $sqlFrom = 'clientes';
      $searchMethod = 'idUser';
      $searchText = $_SESSION['idUser'];

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

      } else{
          unset($_SESSION['searchMethod']);
      }
  }
  function goToCliente(){
    header("Location: /bdd-pautas/html/clienteInfo.php");
    exit();
  }
?>
