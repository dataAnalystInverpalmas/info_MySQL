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

	//inicializa variable vacia
	$where="";
	$fini=fini()->format('Y-m-d');
	$ffin=ffin()->format('Y-m-d');
	//consulta para combos
	if(empty($_POST['xfinca'])){
		$finca="";
	}else{
	  $finca=$_POST['xfinca'];
	}

	if(isset($_POST['buscar']) || isset($_POST['Exportar'])){
		if (!Empty($_POST['xfinca'])){
			$fini=$_POST['fini'];
			$ffin=$_POST['ffin'];
			$where=" WHERE p.finca='".$finca."' ";
		}
		else{
			$fini=$_POST['fini'];
			$ffin=$_POST['ffin'];
			$where="";
		}
	}
		//CONSULTA
		$sql="SELECT p.finca,p.bloque,p.variedad,p.temporada,p.producto,
		v.color,p.fecha_siembra,sum(p.plantas) as plantas,sum(p.plantas)*a.porcentaje as cambiar,a.sem
		FROM plane as p
		INNER JOIN addxvariety as a ON a.finca=p.finca AND a.variedad=p.variedad
		INNER JOIN varieties as v ON v.nombre=p.variedad
		$where
		GROUP BY p.finca,p.bloque,p.variedad,p.temporada,p.producto,v.color,p.fecha_siembra
		";

		$result=$conexion->query($sql);
		//consulta para exportar a excel
		$sqlX="SELECT p.finca,p.bloque,p.variedad,p.temporada,p.producto,
		v.color,p.fecha_siembra,sum(p.plantas) as plantas,sum(p.plantas)*a.porcentaje as cambiar
		FROM plane as p
		INNER JOIN addxvariety as a ON a.finca=p.finca AND a.variedad=p.variedad
		INNER JOIN varieties as v ON v.nombre=p.variedad
		$where
		GROUP BY p.finca,p.bloque,p.variedad,p.temporada,p.producto,v.color,p.fecha_siembra
		";

		$resultX=$conexion->query($sqlX);
		//CONSULTA PARA COMBO
		$slqCOMBO="SELECT finca FROM plane GROUP BY finca";
		$fincaC=$conexion->query($slqCOMBO);
?>

	<div class="card">
  <div class="card-header">
    <form class="form-inline" action="index.php?menu=tables&report=3" method="post" enctype="multipart/form-data">
	<div class="form-group mb-2">
        <select name="xfinca" class="form-control" data-live-search="true">
          <option value="">Finca</option>
          <?php
          while($f = $fincaC->fetch_object()){
            if($f->finca==$finca){
			echo "<option value='".$f->finca."' selected='selected'>" .$f->finca. "</option>";
          }else{
            echo "<option value='".$f->finca."'>" .$f->finca. "</option>";
          }
          }
           ?>
           </select>
		   </div>
		   <div class="form-group mb-2">
		   <label for="formGroupExampleInput2">Fecha Inicial</label>
		   <input class="form-control" type="date" value="<?php echo $fini; ?>" name="fini" id="fini">
		   </div>
		   <div class="form-group mb-2">
		   <label for="formGroupExampleInput2">Fecha Final</label>
		   <input class="form-control" type="date" value="<?php echo $ffin; ?>" name="ffin" id="ffin">
        </div>
        <div class="form-group mx-sm-3 mb-2">
              <button name="buscar" type="submit" class="btn btn-primary mb-2">Buscar</button>
        </div>
		<div class="form-group mx-sm-3 mb-2">
              <button name="Exportar" type="submit" class="btn btn-success mb-2">Exportar</button>
        </div>
   </form>
  </div>
</div>
<?php

	if ($result->num_rows>0){

		?>
	   <div class="row">
	   <div class="col">
		 <table class="table table-responsive table-sm">
		 <tr><th>Finca</th><th>Bloque</th><th>Variedad</th><th>Temporada</th><th>fecha_siembra</th><th>plantas</th>
		   <th>Edad</th><th>Cambiar</th><th>Fecha Necesidad Finca</th><th>Fecha Ensarte</th><th>Fecha Cosecha</th><th>Fecha Nueva Siembra</th>
		   </tr>

		 <?php

	while ($f=$result->fetch_object()){
		$semVilla=5;
		$semEnsarte=4;
		$sem=$f->sem;
		$edad=carbon::now()->diffInWeeks($f->fecha_siembra);
		$fechai=new Carbon($f->fecha_siembra);
		//a las 72 semanas se programa nueva siembra
		$edadlimite=$fechai->addWeeks($sem);//con esta edad se hacen los calculos
		//variables para mostrar resultados
		$edadS=new carbon ($edadlimite->startOfWeek()->format('Y-m-d'));///fecha de siembra
		$fechaVilla=new carbon($edadlimite->subWeeks($semVilla));//fecha de llegada esqueje a la finca

		if (isset($_POST['buscar']) || isset($_POST['Exportar'])){
			$fi=new carbon($_POST['fini']);//inicia variable con valor en combo
			$ff=new carbon($_POST['ffin']);//variable fin
			if($edadS->between($fi,$ff)){//valida si esta entre las dos fechas
				echo "<tr><td>" .$f->finca. "</td><td>" .$f->bloque. "</td><td>" .$f->variedad. "</td>
				<td>" .$f->temporada. "</td>
				<td>" .$f->fecha_siembra. "</td><td>" .$f->plantas. "</td><td>" .$edad. "</td>
				<td>" .round($f->cambiar,0). "</td>
				<td>" .$fechaVilla->format('Y-m-d'). "</td>
				<td>" .$fechaVilla->addWeeks(1)->format('Y-m-d'). "</td>
				<td>" .$fechaVilla->addWeeks(4)->format('Y-m-d'). "</td>
				<td>" .$edadS->format('Y-m-d'). "</td>
				</tr>";
			}
		}else{
		//pintar todas las filas filas
		echo "<tr><td>" .$f->finca. "</td><td>" .$f->bloque. "</td><td>" .$f->variedad. "</td><td>" .$f->temporada. "</td>
		   <td>" .$f->fecha_siembra. "</td><td>" .$f->plantas. "</td><td>" .$edad. "</td><td>" .$edadS. "</td><td>" .$f->cambiar. "</td>
		   </tr>";
		}
	}

		echo "</table>";
		echo "</div>";
	   }
	   else{
		echo "</table>";
		
	   }
	   ?>
	   </div>
	   </div>
	   <?php
	   	   //Exportar a excel////////////////////////////////////////

			  if (isset($_POST['Exportar'])) {
				  //

				$spreadsheet=new Spreadsheet();
				$sheet=$spreadsheet->getActiveSheet();
				$i=2;
				$fi=new carbon($_POST['fini']);//inicia variable con valor en combo
				$ff=new carbon($_POST['ffin']);//variable fin

				//titulos de columnas
				$sheet->setCellValueByColumnAndRow(1,1,'Finca');
				$sheet->setCellValueByColumnAndRow(2,1,'Bloque');
				$sheet->setCellValueByColumnAndRow(3,1,'Variedad');
				$sheet->setCellValueByColumnAndRow(4,1,'Temporada');
				$sheet->setCellValueByColumnAndRow(5,1,'Fecha de Siembra');
				$sheet->setCellValueByColumnAndRow(6,1,'No Plantas');
				$sheet->setCellValueByColumnAndRow(7,1,'Edad');
				$sheet->setCellValueByColumnAndRow(8,1,'No Plantas a Cambiar');
				$sheet->setCellValueByColumnAndRow(9,1,'Fecha Nueva Siembra');
				$sheet->setCellValueByColumnAndRow(10,1,'Fecha LLegada Finca');
				$sheet->setCellValueByColumnAndRow(11,1,'Fecha Ensarte');
				$sheet->setCellValueByColumnAndRow(12,1,'Fecha Cosecha');

			while ($fX=$resultX->fetch_object()){
	//ASOCIAR A VARIABLES PARA XSL
				$fincaX=$fX->finca;
				$bloqueX=$fX->bloque;
				$variedadX=$fX->variedad;
				$temporadaX=$fX->temporada;
				$fecha_siembraX=$fX->fecha_siembra;
				$plantasX=$fX->plantas;
				$cambiar=$fX->cambiar;
				$edadX=carbon::now()->diffInWeeks($fecha_siembraX);
				$fechaiX=new Carbon($fecha_siembraX);
				$edadlimiteX=$fechaiX->addWeeks(70);

				if($edadlimiteX->between($fi,$ff) AND $cambiar>0){//valida si esta entre las dos fechas
	//LLEVAR A LA HOJA DE CALCULO
				$sheet->setCellValueByColumnAndRow(1,$i,$fincaX);
				$sheet->setCellValueByColumnAndRow(2,$i,$bloqueX);
				$sheet->setCellValueByColumnAndRow(3,$i,$variedadX);
				$sheet->setCellValueByColumnAndRow(4,$i,$temporadaX);
				$sheet->setCellValueByColumnAndRow(5,$i,$fecha_siembraX);
				$sheet->setCellValueByColumnAndRow(6,$i,$plantasX);
				$sheet->setCellValueByColumnAndRow(7,$i,$edadX);
				$sheet->setCellValueByColumnAndRow(8,$i,round($cambiar,0));
				$sheet->setCellValueByColumnAndRow(9,$i,$edadlimiteX->addDays(4)->format('Y-m-d'));
				$sheet->setCellValueByColumnAndRow(10,$i,$edadlimiteX->subWeeks(5)->format('Y-m-d'));
				$sheet->setCellValueByColumnAndRow(11,$i,$edadlimiteX->addWeeks(1)->format('Y-m-d'));
				$sheet->setCellValueByColumnAndRow(12,$i,$edadlimiteX->format('Y-m-d'));

	//INCREMENTO
				$i++;
				}
			}
				$writer=new Xlsx($spreadsheet);
				$writer->save("Datos.xlsx");
				exit;
			}
	   $conexion->close();
?>
