<?php
//traer conexion
require("funciones/conexion.php");
  //comprobar si se logea en formulario

if (isset($_POST['login'])){
//CONSULTA
$usuario=mysqli_real_escape_string($conexion,$_POST['email']);
$password=mysqli_real_escape_string($conexion,$_POST['password']);

$sql="SELECT name,password,email,role FROM users WHERE email='".$usuario."' and password='".$password."' ";

$query=$conexion->query($sql);
$rows=$query->num_rows;
$row=mysqli_fetch_assoc($query);

if($rows>0){
  //iniciali  variables de session_start
  $_SESSION['usuario']=$row['name'];
  $_SESSION['role']=$row['role'];
  header("location: home.php");
}else{
?>
<script>
  alert("Error en Login");
</script>
<?php
header("location: index.php");
}

}

 ?>
