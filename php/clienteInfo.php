<?php

function printNombreCliente(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idCliente,
    $nombreCliente;

    $sqlFrom = 'clientes';
    $searchMethod = 'idCliente';
    $_SESSION['searchText'] = $_SESSION['idCliente'];

    sqlSearch();

    if($result != null){
      while($row = mysqli_fetch_array($result))
        {
          echo $row['nombre'];
        }
      }
}
// function tableClientes(){
//     global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row;
//
//     $sqlFrom='personas';
//
//     echo '<table class="sqlTable">';
//     echo
//         "<tr class='trTableTop'><td>ID Cliente
//         </td><td>Nombre
//         </td><td>Estado Civil
//         </td><td>Edad
//         </td><td>Fecha de Nacimiento
//         </td><td>Potencial
//         </td><td>Genero
//         </td><td>Visita Programada
//         </td></tr>
//
//          ";
//     if (isset($_SESSION['searchMethod'])){
//         $searchMethod=$_SESSION['searchMethod'];
//         echo $searchMethod;
//     }
//     if (isset($_SESSION['searchText'])){
//         $searchText=$_SESSION['searchText'];
//     }
//
//     sqlSearch(); //Query into $Result variable
//     if($result != null){
//         while($row = mysqli_fetch_array($result))
//           {
//             echo"
//               <tr class='trTableClientes'><td class='idPersona'>" . $row['idPersona'] .
//              "</td><td>" . $row['nombre'] .
//              "</td><td>" . $row['estadoCivil'] .
//              "</td><td>" . $row['edad'] .
//              "</td><td>" . $row['fNacimiento'] .
//              "</td><td>" . $row['potencial'] .
//              "</td><td>" . $row['genero'] .
//              "</td><td>" . $row['fVisita'] .
//              "</td></tr> ";  //$row['index'] the index here is a field name
//
//           }
//         echo"</table>";
//     } else{
//         unset($_SESSION['searchMethod']);
//     }
//
//
//     mysqli_close($con);
// }
?>
