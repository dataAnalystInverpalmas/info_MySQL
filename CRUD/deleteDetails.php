<?php
// check request

if(isset($_POST['id']) && isset($_POST['id']) != "")
{
//lamar conexion
include ('../funciones/conexion.php');

    // get user id
    $record_id = $_POST['id'];

    // delete User
    $query = "DELETE FROM indicator_transactions WHERE id = '$record_id'";
    if (!$result = mysqli_query($conexion, $query)) {
        exit(mysqli_error($conexion));
    }
}
?>