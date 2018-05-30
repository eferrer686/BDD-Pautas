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
      goToCliente();
  }
  function searchClientes(){
      global $searchText;
      $_SESSION['searchMethod'] = 'nombre';
      $_SESSION['searchText'] = $_POST['Nombre'];
      header("Location: /bdd-pautas/html/clientes.php");
  }
  function searchCliente(){
      global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

      $idCliente,
      $nombreCliente;

      $sqlFrom = 'clientes';

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
               "<tr class='trTableClientes'id=editable>
               <td class='idCliente'>" . $row['idCliente'] .
               "</td><td class='nombre' contenteditable=true>" . $row['nombre'] .
               "</td><td class='contacto'contenteditable=true>" . $row['contacto'] .
               "</td><td class='mail' contenteditable=true>" . $row['mail'] .
               "</td><td class='rfc' contenteditable=true>" . $row['rfc'] .
               "</td><td class='direccion' contenteditable=true>" . $row['direccion'] .
               "</td><td class='numPautas'>" . $row['numPautas'] .
               "</td></tr> ";
            }
          echo"</table>";
      } else{
          unset($_SESSION['searchMethod']);
      }
      mysqli_close($con);
    }



  function goToCliente(){
    $_SESSION['searchMethod'] = 'idCliente';
    $_SESSION['searchText'] = $_POST['idCliente'];

    header("Location: /bdd-pautas/html/clienteInfo.php");
    exit();
  }
  function goToAddCliente(){
    header("Location: /bdd-pautas/html/clienteNuevo.php");
    exit();
  }

?>
