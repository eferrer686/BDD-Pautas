<?php
function topnav(){
  echo '
   <link rel="stylesheet" type="text/css" href="../css/topnav.css">
   <div class="topnav">
     <a href="home.php">Home</a>
     <a href="clientes.php">Clientes</a>
     <a href="proveedores.php">Proveedores</a>
     <a href="#about">Radio</a>
     <a href="#about">Television</a>
     <a href="?logout=true" >Logout</a>
 </div>';
}

?>
