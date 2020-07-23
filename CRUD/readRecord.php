<?php
//lamar conexion
include ('../funciones/conexion.php');

// Design initial table header 
$data = '<table class="table table-bordered table-striped">
<tr>
    <th>Fecha</th>
    <th>Finca</th>
    <th>Producto</th>
    <th>Indicador</th>
    <th>Revision</th>
    <th>Tipo</th>
    <th>Valor</th>
    <th colspan="2">Acciones</th>
</tr>';

$query = "SELECT * FROM indicator_transactions";

if (!$result = mysqli_query($conexion, $query)) {
exit(mysqli_error($conexion));
}

// if query results contains rows then featch those rows 
if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_assoc($result))
{
    $data .= '<tr>
    <td>'.$row['fecha'].'</td>
    <td>'.$row['finca'].'</td>
    <td>'.$row['producto'].'</td>
    <td>'.$row['indicador'].'</td>
    <td>'.$row['revision'].'</td>
    <td>'.$row['tipo'].'</td>
    <td>'.$row['valor'].'</td>
    <td>
    <button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning"><i class="fas fa-edit">Editar</i></button>
    </td>
    <td>
    <button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger"><i class="far fa-trash-alt">Eliminar</i></button>
    </td>
    </tr>';
    }
    }
else
{
// records now found 
    $data .= '<tr><td colspan="9">No hay registros!</td></tr>';
}

    $data .= '</table>';

echo $data;

?>