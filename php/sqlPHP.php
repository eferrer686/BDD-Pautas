<?php

//Global Variables
    $servername = "localhost";
    $username = "root";
    $password = "Edoardo686*";
    $dbname = "bddpautas";
    $user = '';
    $pwd = '';
    $sqlFrom='';
    $searchText='';
    $searchMethod='';
    $updateName='';
    $updateValue='';
    $tableID='';
    $idTuple='';

if (!isset($_SESSION["user"])){
    session_start(['cookie_lifetime' => 10800,]);
}
    //Login method for formLogin
if(isset($_POST['login'])){
    setUser();
    login();
}
if (isset($_GET['logout'])){
  logout();
}
if(isset($_POST['register'])){
    header("Location: /clientmanager/register.php");
}
function printNombre(){
  echo $_SESSION['nombre'] ;
}

function setUser(){
    global $user,$pwd;
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['pwd'] = $_POST['pwd'];
}


//Login from DB
function login() {
    global $servername,$username,$password,$dbname,$user,$pwd;

    $con = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM user WHERE username = '" . $_SESSION['user'] . "' and password = '" . $_SESSION['pwd'] ."'";
    $result = mysqli_query($con, $sql);
    //Encontrar usuarios
    if (mysqli_num_rows($result) > 0) {

        $row = $result->fetch_assoc();

            $_SESSION['idUser'] = $row["iduser"];
            $_SESSION['nombre'] = $row["nombre"];
            $_POST['Nombre'] = '';
            header("Location: /bdd-pautas/html/home.php");
            exit();

    }
    else{

        echo '<script language="javascript">';
        echo 'alert("Usuario o contraseña incorrecta")';
        echo '</script>';
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        session_regenerate_id(true);

    }

    mysqli_close($con);
 }
//Table Search and Echo
function sqlSearch(){

    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }


    $sql="SELECT * FROM ".$sqlFrom." where ".$searchMethod." like '%".$searchText."%' and idUser = ".$_SESSION['idUser'];
    // logjs($sql);

    $result = mysqli_query($con,$sql);



}
function sqlSearchSpecific($sqlFrom,$searchMethod,$searchText){

    global $servername, $username, $password, $dbname, $user, $pwd,$con,$row;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }


    $sql="SELECT * FROM ".$sqlFrom." where ".$searchMethod." like '%".$searchText."%' and idUser = ".$_SESSION['idUser'];
    // logjs($sql);
    // echo json_encode($sql);

    $result = mysqli_query($con,$sql);
    return $result;
}
function sqlSearchUnique(){

    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }


    $sql="SELECT * FROM ".$sqlFrom." where ".$searchMethod." like '".$searchText."' and idUser = ".$_SESSION['idUser'];
    // logjs($sql);

    $result = mysqli_query($con,$sql);



}

function sqlSearchSpecificQuery($sql){

    global $servername, $username, $password, $dbname, $user, $pwd,$con,$row;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }
    $result = mysqli_query($con,$sql);
    return $result;
}

function tableClientes(){
    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row;

    $sqlFrom='personas';

    echo '<table class="sqlTable">';
    echo
        "<tr class='trTableTop'><td>ID Cliente
        </td><td>Nombre
        </td><td>Estado Civil
        </td><td>Edad
        </td><td>Fecha de Nacimiento
        </td><td>Potencial
        </td><td>Genero
        </td><td>Visita Programada
        </td></tr>

         ";
    if (isset($_SESSION['searchMethod'])){
        $searchMethod=$_SESSION['searchMethod'];
    }
    if (isset($_SESSION['searchText'])){
        $searchText=$_SESSION['searchText'];
    }

    sqlSearch(); //Query into $Result variable
    if($result != null){
        while($row = mysqli_fetch_array($result))
          {
            echo"
            <tr class='trTableClientes'><td class='idPersona'>" . $row['idPersona'] .
            "</td><td>" . $row['nombre'] .
             "</td><td>" . $row['estadoCivil'] .
             "</td><td>" . $row['edad'] .
            "</td><td>" . $row['fNacimiento'] .
             "</td><td>" . $row['potencial'] .
             "</td><td>" . $row['genero'] .
             "</td><td>" . $row['fVisita'] .
             "</td></tr> ";  //$row['index'] the index here is a field name

          }
        echo"</table>";
    } else{
        unset($_SESSION['searchMethod']);
    }


    mysqli_close($con);
}



//Update and Delete
function sqlUpdate(){

    global $servername, $username, $password, $dbname, $user, $pwd, $searchMethod, $searchText, $sqlFrom, $result,$con,$row,$updateName,$updateValue,$tableID,$idTuple;

    $con = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql = "UPDATE ".$sqlFrom." SET ".$updateName."='".$updateValue."' WHERE ".$tableID."= ".$idTuple."";

    // echo '<script language="javascript">';
    // echo $sql;
    // echo '</script>';

    $result = mysqli_query($con,$sql);

}

function logout(){
  global $user,$password;
  $_SESSION['idUser']='';
  $_SESSION['nombre']='';
  $_SESSION['user']='';

  $user='';
  $pwd='';
  echo '<script language="javascript">';
  echo 'alert("Inicie sesion otra vez porfavor")';
  echo '</script>';
  header("Location: /bdd-pautas/index.php");
  exit();
}

function checkLogin(){
  global $user;
  if($_SESSION['user'] ==''){
    echo 'alert("Favor de iniciar sesión")';
    header("Location: /bdd-pautas/index.php");
  }
}
function logjs($log){
  echo '<script language="javascript">';
  echo 'console.log("'.$log.'")';
  echo '</script>';
}
function alertjs($log){
  echo '<script language="javascript">';
  echo 'alert("'.$log.'")';
  echo '</script>';
}
?>
