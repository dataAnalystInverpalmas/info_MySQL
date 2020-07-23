<?php
//lamar conexion
include ('../funciones/conexion.php');

if(isset($_POST['fecha']))
{
        $fecha = $_POST['fecha'];
        $finca = $_POST['finca'];
        $producto = $_POST['producto'];
        $tipo = $_POST['tipo'];
        $indicador = $_POST['indicador'];
        $revision = $_POST['revision'];
        $valor = $_POST['valor'];

$query = "INSERT INTO  indicator_transactions 
        (fecha,finca,producto,tipo,indicador,revision,valor)
        VALUES 
        ('$fecha','$finca','$producto','$tipo','$indicador','$revision',$valor)
        ";
$result = $conexion->query($query);

}

?>
