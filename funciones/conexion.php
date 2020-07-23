<?php
// Create connection
$conexion = new mysqli('localhost', 'inverpalmas', 'INVER2020!', 'informes');
$conexion->set_charset("utf8");
//sesion
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
else 
    {
        //
    }
?>
