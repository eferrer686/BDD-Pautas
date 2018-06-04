<?php

function printNombreProveedor(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,

    $idProveedor,
    $nombreProveedor;

    $sqlFrom = 'proveedores';

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
          echo $row['nombre'];
        }
      }else{
        unset($_SESSION['searchMethod']);
        unset($_SESSION['searchText']);
      }
      mysqli_close($con);
}
?>
