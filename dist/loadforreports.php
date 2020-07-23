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

///////////cargar tablas//////////
//inicia variable que trae numero para tabla
$tabla=$_SESSION['info'];
//condicional
if ($tabla==1){//////////////////////cargar tabla compañias
    $nombrearchivo='archivos\tabla_compañias.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	//Our SQL statement. This will empty / truncate the table "plane"
$sqlv = "TRUNCATE TABLE companys";
$conexion->query($sqlv);
	
	for ($i=2;$i<=$numRows;$i++){
		
		$nombre=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$area=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO companys (nombre,area)";
		$sql=$sql." VALUES ('$nombre',$area)";
		$result=$conexion->query($sql);
		
		  if (!$result){
			  echo $sql.$numRows;
			die ("Query failed");
		}
    }
    $conexion->close();
}else if($tabla==2){///////////////////cargar fincas
    $nombrearchivo='archivos\tabla_fincas.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	//Our SQL statement. This will empty / truncate the table "plane"
$sqlv = "TRUNCATE TABLE farms";
$conexion->query($sqlv);
	
	for ($i=2;$i<=$numRows;$i++){
		
		$nombre=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$abreviatura=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO farms(nombre,abreviatura)";
		$sql=$sql." VALUES ('$nombre',$abreviatura)";
		$result=$conexion->query($sql);
		
		  if (!$result){
			  echo $sql.$numRows;
			die ("Query failed");
		}
    }
    $conexion->close();
}else if($tabla==3){///////////////////cargar fincas
    $nombrearchivo='archivos\tabla_productos.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	//Our SQL statement. This will empty / truncate the table "plane"
$sqlv = "TRUNCATE TABLE products";
$conexion->query($sqlv);
	
	for ($i=2;$i<=$numRows;$i++){
		
		$nombre=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$cod_nombre=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$grupo=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO products(nombre,cod_nombre,grupo)";
		$sql=$sql." VALUES ('$nombre','$cod_nombre','$grupo')";
		$result=$conexion->query($sql);
		
		  if (!$result){
			  echo $sql.$numRows;
			die ("Query failed");
		}
    }
    $conexion->close();
}else if($tabla==4){///////////////////cargar LISTA DE VARIEDADES A CAMBIAR
    $nombrearchivo='archivos\tabla_variedadesAd.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
	
	//Our SQL statement. This will empty / truncate the table "plane"
$sqlv = "TRUNCATE TABLE addxvariety";
$conexion->query($sqlv);
	
	for ($i=2;$i<=$numRows;$i++){
		
		$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$porcentaje=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$sem=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO addxvariety(finca,variedad,porcentaje,sem)";
		$sql=$sql." VALUES ('$finca','$variedad',$porcentaje,$sem)";
		$result=$conexion->query($sql);
		
		  if (!$result){
			  echo $sql.$numRows;
			die ("Query failed");
		}
    }
    $conexion->close();
}else if($tabla==5){

}

?>