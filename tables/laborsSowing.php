<?php
//////////////conexion////////////////////
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
$nombrearchivo='archivos\tabla_labores_siembra.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "DELETE FROM labors_sowing WHERE programa=2020";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$variedad=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$temporada=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$tipo=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$fecha=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$observacion=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$valor=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$programa=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

		$sql="INSERT INTO labors_sowing (variedad,temporada,tipo,fecha,comentario,valor,programa)";
		$sql=$sql." VALUES ('$variedad','$temporada','$tipo','$fecha','$observacion',$valor,'$programa')";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed");
		}
	}
?>