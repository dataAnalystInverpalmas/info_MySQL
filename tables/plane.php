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
//$nombrearchivo='archivos\Plantas Sembradas  GrowerApp.xlsx'; //////////SUBIR CON GROWERAPP
	$nombrearchivo='archivos\Plantas Sembradas ld5000.xlsx'; //////////SUBIR CON LD5000
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlt = "TRUNCATE TABLE plane";

$conexion->query($sqlt);

	for ($i=2;$i<=$numRows;$i++){

$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
$bloque=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
$nave=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
$camaa=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
$tabla=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
$producto=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
$variedad=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
$tipo_suelo=$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
$temporada=$objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
$plantas= $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
$tipo_plantas = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
$fecha_siembra=$objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
//variables que vienen vacias solo para LD5000
$cama=$camaa.$tabla;
$origen='VILLA DE LEYVA';
$area = 0;

/* $idSQL="SELECT id FROM farms WHERE farms.nombre='$finca' limit 1";
$idRES=$conexion->query($idSQL);
$id= $fincaRES->fetch_assoc(); */

		$sql="INSERT INTO plane (finca,bloque,nave,cama,producto,variedad,origen,tipo_plantas,tipo_suelo,temporada,fecha_siembra,plantas,area)";
		$sql=$sql." VALUES ('$finca',$bloque,$nave,'$cama','$producto','$variedad','$origen','$tipo_plantas','$tipo_suelo','$temporada','$fecha_siembra',$plantas,$area)";
		$result=$conexion->query($sql);
		echo $sql;
		  if (!$result){
			die ("Query failed ". $conexion->error);
		}
	}
/*/////////////////////////////////////////////////////////////////
		$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$bloque=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$nave=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$cama=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$producto=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$origen=$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$tipo_plantas=$objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
		$tipo_suelo=$objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
		$temporada=$objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
		$fecha_siembra= $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
		$plantas=$objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
		$area=$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
*/	
 ?>   