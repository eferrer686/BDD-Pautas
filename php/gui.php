<?php
function topnav(){
  echo '
   <link rel="stylesheet" type="text/css" href="../css/topnav.css">
   <div class=spacing>

   </div>
   <div class="topnav">
     <a href="home.php">Home</a>
     <a href="clientes.php">Clientes</a>
     <a href="proveedores.php">Proveedores</a>
     <a href="radios.php">Radio</a>
     <a href="televisiones.php">Television</a>
     <a href="espectaculares.php">Espectacular</a>
     <a href="?logout=true" >Logout</a>
 </div>';
}

?>
