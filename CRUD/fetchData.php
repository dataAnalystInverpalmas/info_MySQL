<?php
//lamar conexion
include ('../funciones/conexion.php');

if(isset($_POST['get_option']))
{
 $state = $_POST['get_option'];
 $find=$conexion->query("select revision from indicators where tipo='$state'");
 while($row=mysqli_fetch_array($find))
 {
  echo "<option>".$row['revision']."</option>";
 }
 exit;
}
?>