<?php

//lamar conexion
include ('funciones/conexion.php');

if (isset($_POST['submit']))
{
    if($_POST['turno']==1)
    {
        $turno=1;
    }
    else
    {
        $turno=2;
    }
?>
<script> 
    window.location.href = "home.php?menu=tables&report=1000";
</script>
<?php
}
else
{
    $turno=0;
}

$_SESSION['turno']= $turno;

if ($turno==1)
{
    $_SESSION['nturno']="Entrada";
}
elseif ($turno==2)
{
    $_SESSION['nturno']="Salida";
}
else
{
    $_SESSION['nturno']="Sin seleccionar";
}
?>

<div class="row">
    <div class="col">
        <h1>Configuración</h1>  
    </div>
</div>
<form id="form" name="form" method="post" action="home.php?menu=tables&report=1001">
    <div class="row">
        <div class="col-sm-10">
            <select class="form-control" name="turno" id="turno">
                <option value="0">Seleccione Turno</option>
                <option value="1">Entrada</option>
                <option value="2">Salida</option>
            </select>
        </div>
        <div class="col-sm-2">
        <input name="submit" class="btn btn-success" type="submit" value="Guardar" />
        </div>
    </div>

<script>
    document.getElementById('turno').selectedIndex =<?php echo $_SESSION['turno']; ?>;
</script>