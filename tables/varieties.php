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
///////////////////////////////////////////
	$nombrearchivo='archivos\tabla_variedades.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlv = "TRUNCATE TABLE varieties";
$conexion->query($sqlv);

	for ($i=2;$i<=$numRows;$i++){

		$nombre=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$producto=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$color=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$ciclo=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$codvari=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO varieties (nombre,producto,color,ciclo,codvari)";
		$sql=$sql." VALUES ('$nombre','$producto','$color',$ciclo,'$codvari')";
		$result=$conexion->query($sql);

		  if (!$result){
			  echo $sql.$numRows;
			die ("Query failed");
		}
	}

?>