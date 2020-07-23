<?php
//lamar conexion
include ('funciones/conexion.php');
//funciones personalizadas
//carbon
require "vendor/autoload.php";
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

//Consulta de solo variedades de vitrinas//
$sqlVariedadesV="SELECT * from varieties as v 
WHERE producto like '%VITRINAS%' order by producto,color,nombre asc";

?>