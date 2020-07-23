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

//inicia variable que trae numero para tabla
//inicia variable que trae numero para tabla
$tabla=$_SESSION['info'];
//condicional
if ($tabla==101){//CARGAR PLANTAS SEMBRADAS///////////////////////////////////

	//$nombrearchivo='archivos\Plantas Sembradas  GrowerApp.xlsx'; //////////SUBIR CON GROWERAPP
	$nombrearchivo='archivos\Plantas Sembradas ld5000.xlsx'; //////////SUBIR CON LD5000
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlt = "TRUNCATE TABLE plane";

$conexion->query($sqlt);

	for ($i=2;$i<=$numRows;$i++){
/*
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

		$sql="INSERT INTO plane (finca,bloque,nave,cama,producto,variedad,origen,tipo_plantas,tipo_suelo,temporada,fecha_siembra,plantas,area)";
		$sql=$sql." VALUES ('$finca',$bloque,$nave,'$cama','$producto','$variedad','$origen','$tipo_plantas','$tipo_suelo','$temporada','$fecha_siembra',$plantas,$area)";
		$result=$conexion->query($sql);
		echo $sql;
		  if (!$result){
			die ("Query failed ". $conexion->error);
		}
	}
}else if($tabla==102){//CARGAR VARIEDADES///////////////////////////////////

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

}else if($tabla==103){//CARGAR PRESUPUESTO//////////////////////////////
	$nombrearchivo='archivos\tabla_presupuesto.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE program";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){

		$producto=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$ciclo=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$temporada_obj=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$ncamas=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$programa=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$producto=strtoupper($producto);
		$temporada_obj=strtoupper($temporada_obj);

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO program (producto,variedad,ciclo,temporada_obj,ncamas,programa)";
		$sql=$sql." VALUES ('$producto','$variedad',$ciclo,'$temporada_obj',$ncamas,$programa)";
		$result=$conexion->query($sql);

		  if (!$result){
			die ("Query failed Insert");

		}
	}
		//actualizar columnas que dependen de la tabla de temporadas
		$sqlUPD="UPDATE program SET fecha_pico=(SELECT s.fecha_pico from seasons as s where s.nombre=temporada_obj)";
		$sqlUPD=$sqlUPD.",ciclo=(SELECT ciclo from varieties WHERE `variedad`=varieties.nombre group by 1)";
		$sqlUPD=$sqlUPD.",fecha_temporada=(SELECT s.fecha_fiesta from seasons as s where s.nombre=temporada_obj)";
		$sqlUPD=$sqlUPD.",fecha_siembra=DATE_ADD((SELECT s.fecha_pico from seasons as s where s.nombre=temporada_obj), INTERVAL -(ciclo) WEEK)";
		$sqlUPD=$sqlUPD.",fecha_ensarte=DATE_ADD((SELECT s.fecha_pico from seasons as s where s.nombre=temporada_obj), INTERVAL -(ciclo+4) WEEK)";
		$sqlUPD=$sqlUPD.",fecha_cosecha=DATE_ADD(fecha_siembra, INTERVAL -(2) DAY)";
		$sqlUPD=$sqlUPD.",plantas=ncamas*960";
		$sqlUPD=$sqlUPD.",tipo=(SELECT s.tipo FROM seasons as s WHERE s.nombre=temporada_obj)";
		$sqlUPD=$sqlUPD.",color=(SELECT v.color FROM varieties as v WHERE v.nombre=variedad)";

		$resultUPD=$conexion->query($sqlUPD);
		if (!$resultUPD){
		  die ("Query failed Update");
	  }

}else if($tabla==104){//CAREGAR////////////////TEMPORADAS//////////////
	$nombrearchivo='archivos\tabla_temporadas.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlt = "TRUNCATE TABLE seasons";
$conexion->query($sqlt);

	for ($i=2;$i<=$numRows;$i++){

		$nombre=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$fiesta=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$ano=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$fecha_pico=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$fecha_fiesta=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$cod_temporada=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$tipo_temporada=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO seasons (nombre,fiesta,cod_temporada,año,fecha_pico,fecha_fiesta,tipo)";
		$sql=$sql." VALUES ('$nombre','$fiesta','$cod_temporada',$ano,'$fecha_pico','$fecha_fiesta','$tipo_temporada')";
		$result=$conexion->query($sql);

		  if (!$result){
			  echo $sql.$numRows;
			die ("Query failed");
		}
	}
}else if($tabla==105){//CARGAR TABLA DE FUSARIUM/////////////////////////////////
	$nombrearchivo='archivos\tabla_fusarium.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE fusarium";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$bloque=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$temporada=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$pico=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$fecha=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
    $plantas=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
 		$dato=$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();

		$sql="INSERT INTO fusarium (finca,bloque,variedad,temporada,pico,fecha_siembra,plantas,dato)";
		$sql=$sql." VALUES ('$finca',$bloque,'$variedad','$temporada',$pico,$fecha,$plantas,$dato)";
		$result=$conexion->query($sql);

		if (!$result){
			die ("Query failed ".$sql);
		}
	}
	$UPD="UPDATE fusarium SET ntemporada=(SELECT s.nombre from seasons as s where s.cod_temporada=temporada)";
	$resultUPD=$conexion->query($UPD);

	if (!$resultUPD){
	  die ("Update failed");
  }

}else if($tabla==106){//CARGAR MANEJO DE VARIEDADES//////////////////////////////
	$nombrearchivo='archivos\tabla_manejos.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE arrangements";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$variedad=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$finca=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$tipo=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$aplicar=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$medidat=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$valor=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

		$sql="INSERT INTO arrangements (variedad,finca,tipo,aplicar,medidat,valor)";
		$sql=$sql." VALUES ('$variedad','$finca','$tipo','$aplicar','$medidat',$valor)";
		$result=$conexion->query($sql);
		if (!$result){
			die ("Query failed".$sql);
		}
	}
	
}else if($tabla==107){//CARGAR AREAS////////////////////////////////
	$nombrearchivo='archivos\tabla_areas.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE areas";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$nombre=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();

		$sql="INSERT INTO areas (nombre)";
		$sql=$sql." VALUES ('$nombre')";
		$result=$conexion->query($sql);

		if (!$result){
			die ("Query failed");
		}
	}
}else if($tabla==108){//CARGAR PRESUPUESTO CON FINCA Y BLOQUE////////////////////////////////
	$nombrearchivo='archivos\tabla_asignacion.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
	$sqlp = "TRUNCATE TABLE programf";
	$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){

		$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$bloque=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$producto=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$temporada_obj=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$matas=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$programa=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$producto=strtoupper($producto);
		$temporada_obj=strtoupper($temporada_obj);

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO programf (producto,variedad,temporada_obj,plantas,programa,finca,bloque)";
		$sql=$sql." VALUES ('$producto','$variedad','$temporada_obj',$matas,$programa,'$finca',$bloque)";
		$result=$conexion->query($sql);
		echo $sql;
			if (!$result){
			die ("Query failed Insert");
		}
	}
		//actualizar columnas que dependen de la tabla de temporadas
		$sqlUPD="UPDATE programf SET fecha_pico=(SELECT s.fecha_pico from seasons as s where s.nombre=temporada_obj)";
		$sqlUPD=$sqlUPD.",ciclo=(SELECT ciclo from varieties WHERE `variedad`=varieties.nombre group by 1)";
		$sqlUPD=$sqlUPD.",fecha_temporada=(SELECT s.fecha_fiesta from seasons as s where s.nombre=temporada_obj)";
		$sqlUPD=$sqlUPD.",fecha_siembra=DATE_ADD((SELECT s.fecha_pico from seasons as s where s.nombre=temporada_obj), INTERVAL -(ciclo) WEEK)";
		$sqlUPD=$sqlUPD.",fecha_ensarte=DATE_ADD((SELECT s.fecha_pico from seasons as s where s.nombre=temporada_obj), INTERVAL -(ciclo+4) WEEK)";
		$sqlUPD=$sqlUPD.",fecha_cosecha=DATE_ADD(fecha_siembra, INTERVAL -(2) DAY)";
		$sqlUPD=$sqlUPD.",ncamas=plantas/960";
		$sqlUPD=$sqlUPD.",tipo=(SELECT s.tipo FROM seasons as s WHERE s.nombre=temporada_obj)";
		$sqlUPD=$sqlUPD.",color=(SELECT v.color FROM varieties as v WHERE v.nombre=variedad)";
		echo $sqlUPD;
		$resultUPD=$conexion->query($sqlUPD);
		if (!$resultUPD){
			die ("Query failed Update");
		}
}
else if($tabla==109){//CARGAR PRESUPUESTO CON FINCA Y BLOQUE////////////////////////////////
	$nombrearchivo='archivos\tabla_hplano.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
	$sqlp = "delete from hplane where year(fecha_siembra)>2019";
	$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){

		$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$bloque=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$temporada=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$variedad_rem=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$temporada_rem=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$tipo_siembra=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
		$fecha_siembra=$objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
		$plantas=$objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();

		//$fecha_siembra=date('Y-m-d',$fechai);
		$sql="INSERT INTO hplane (finca,bloque,variedad,temporada,variedad_rem,temporada_rem,tipo_siembra,fecha_siembra,plantas)";
		$sql=$sql." VALUES ('$finca',$bloque,'$variedad','$temporada','$variedad_rem','$temporada_rem','$tipo_siembra','$fecha_siembra',$plantas)";
		$result=$conexion->query($sql);
		echo $sql;
			if (!$result){
			die ("Query failed Insert");
		}
	}

}else if($tabla==116){
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
	
}else if($tabla==117){
	$nombrearchivo='archivos\tabla_calidades.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE table_qualities";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$finca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$producto=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$fuente=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$grado=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		$fecha=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
		$valor=$objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

		$sql="INSERT INTO table_qualities (finca,producto,variedad,fuente,grado,fecha,valor)";
		$sql=$sql." VALUES ('$finca','$producto','$variedad','$fuente','$grado','$fecha',$valor)";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed: ".$sql);
		}
	}	
}else if($tabla==118){
	$nombrearchivo='archivos\tabla_causas_nacional.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();


	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE table_nalcauses";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$fecha=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$causa=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$muestra=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$valor=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

		$sql="INSERT INTO table_nalcauses (fecha,variedad,causa,muestra,valor)";
		$sql=$sql." VALUES ('$fecha','$variedad','$causa',$muestra,$valor)";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed: ".$sql);
		}
	}	
}else if($tabla==119){
	$nombrearchivo='archivos\tabla_evaluaciones.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE table_evaluations";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$fecha=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$item=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$valor=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$usuario=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

		$sql="INSERT INTO table_evaluations (fecha,variedad,item,valor,usuario)";
		$sql=$sql." VALUES ('$fecha','$variedad','$item',$valor,'$usuario')";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed: ".$sql);
		}
	}		
}else if($tabla==120){
	$nombrearchivo='archivos\tabla_comentarios.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE table_comments";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$fecha=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$usuario=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$variedad=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$post=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		$comentario=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

		$sql="INSERT INTO table_comments (fecha,usuario,variedad,post,comentario)";
		$sql=$sql." VALUES ('$fecha','$usuario','$variedad','$post','$comentario')";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed: ".$sql);
		}
	}	
}else if($tabla==121){
	$nombrearchivo='archivos\tabla_curvas.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE table_curves";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$variedad=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$edad=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$fmata=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

		$sql="INSERT INTO table_curves (variedad,edad,fmata)";
		$sql=$sql." VALUES ('$variedad',$edad,$fmata)";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed: ".$sql);
		}
	}						
}else if($tabla==122){
	$nombrearchivo='archivos\tabla_caracteristicas.xlsx';
	$objPHPExcel=IOFactory::load($nombrearchivo);
	$objPHPExcel->setActiveSheetIndex(0);
	$numRows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

	//Our SQL statement. This will empty / truncate the table "plane"
$sqlp = "TRUNCATE TABLE table_features";
$conexion->query($sqlp);

	for ($i=2;$i<=$numRows;$i++){
		$variedad=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		$item=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		$medida=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		$valor=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();

		$sql="INSERT INTO table_features (variedad,item,medida,valor)";
		$sql=$sql." VALUES ('$variedad','$item','$medida',$valor)";
		$result=$conexion->query($sql);
		echo $sql;
		if (!$result){
			die ("Query failed: ".$sql);
		}
	}	
}else if($tabla==22){
	include 'views/applications.php';
}
?>
