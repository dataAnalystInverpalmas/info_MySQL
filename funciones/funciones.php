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

function fini(){//funcion para allar el inicio de la semana
	$fini = Carbon::now(); // or $date = new Carbon();
	$year=$fini->year;//año actual
	$fini->setISODate($year,43); // fecha de semana 42
    $fini->startOfWeek(Carbon::MONDAY); // inicio de la semana
    //$fini->addWeek(72);
    $fini->format('Y-m-d');
    return $fini;
}
function ffin(){//semana 42 siguiente año
	$ffin=Carbon::now();//fecha actual
	$yearf=$ffin->year;
	$ffin->setISODate($yearf+1,43); // fecha de semana 42
    $ffin->endOfWeek(Carbon::SUNDAY); // inicio de la semana
    //ahora retroceder 72 semanas
    $ffin->format('Y-m-d');
    return $ffin;
}

function roundC($valor){
    $cama=960;//valor de cama real
    $numero=intval($valor/$cama);
    $sobra=$valor%$cama;
    if($sobra>($cama/2)){
        $rta=$numero+1;
    }else{
        $rta=$numero;
    }
    return $rta;
}

?>