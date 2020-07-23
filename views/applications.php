<?php

//lamar conexion
include ('funciones/conexion.php');
//funciones personalizadas
//carbon
require "vendor/autoload.php";
use Carbon\Carbon;

	$di=Carbon::now();
	$de=Carbon::now();
	$dateEnd=new Carbon();
	$dateIni=new Carbon();
	
	$dateIni=$di->startOfWeek()->format('Y-m-d');
	$dateEnd=$de->endOfWeek()->format('Y-m-d');
	//consulta para combos
	$where=" WHERE producto in('CLAVEL','MINICLAVEL') ";

	if(empty($_POST['xtipo']) and empty($_POST['xfinca']))
	{//las dos estan vacias
		$tipo="";
		$finca="";
	}else if(!empty($_POST['xtipo']) and empty($_POST['xfinca']))
	{//solo tipo de aplicacion	
		  $tipo=$_POST['xtipo'];
		  $finca="";
	}
	else if(empty($_POST['xtipo']) and !empty($_POST['xfinca']))
	{//solo finca
		$tipo="";
		$finca=$_POST['xfinca'];
	}
	else//en caso de que esten seteadas las dos, asignar valores
	{
		$tipo=$_POST['xtipo'];
		$finca=$_POST['xfinca'];
	}

	if(isset($_POST['buscar'])){
		$dateIni=$_POST['dateIni'];
		$dateEnd=$_POST['dateEnd'];
		if ($tipo=='')//condicion para filtrar tipo de aplicacion
		{
			$where.='';
		}
		else
		{
			$where.=" AND T2.tipo='".$tipo."' ";
		}
		if ($finca=='')//condicion para filtrar finca
		{
			$where.='';	
		}
		else
		{
			$where.=" AND T2.finca='".$finca."' ";
		}
		//resto de la condicion que siempre se cumple
			  $where.=" AND  DATE_ADD(T1.fecha_siembra,interval T2.valor day) between
			  '$dateIni' AND '$dateEnd' 		  
			  ";
	}else
	{//en caso de no haber presionado  buscar, hace...
		$where.=" AND
		DATE_ADD(T1.fecha_siembra,interval T2.valor day) between
		'$dateIni' AND '$dateEnd' 		  
		";
	}

	//consulta para tabla
	$sql="SELECT T1.finca,
				T1.bloque,
				T1.variedad,
				T1.temporada,
				T2.tipo,
				T2.aplicar,
		COUNT(T1.bloque) as camas,round(sum(T1.plantas)/960,1) as ncamas,
		DATE_ADD(T1.fecha_siembra,interval T2.valor day) as fecha_aplica
		FROM plane AS T1
		INNER JOIN arrangements as T2
		ON T2.variedad=T1.variedad and T2.finca=T1.finca
		$where
		GROUP BY 1,2,3,4,5,6
		";

		//consulta para tabla
	$sql2="SELECT T1.finca,
		T1.bloque,
		COUNT(T1.bloque) as camas,round(sum(T1.plantas)/960,1) as ncamas,
		T2.tipo,T2.aplicar,
		DATE_ADD(T1.fecha_siembra,interval T2.valor day) as fecha_aplica
		FROM plane AS T1
		INNER JOIN arrangements as T2
		ON T2.variedad=T1.variedad and T2.finca=T1.finca
		$where
		GROUP BY T1.finca,T1.bloque,T2.tipo,T2.aplicar
		";
			//consulta para tabla
	$sql3="SELECT IFNULL(T2.aplicar,'Total') as aplicar,
		COUNT(T1.bloque) as camas,round(sum(T1.plantas)/960,1) as ncamas	
		FROM plane AS T1
		INNER JOIN arrangements as T2
		ON T2.variedad=T1.variedad and T2.finca=T1.finca
		$where
		GROUP BY T2.aplicar
		WITH ROLLUP
		";	

	$res=$conexion->query($sql);
	$res2=$conexion->query($sql2);
	$res3=$conexion->query($sql3);

	//consulta tipo
	$sqlTIPO="SELECT DISTINCT tipo FROM arrangements";
	$resT=$conexion->query($sqlTIPO);
	//consulta fincas
	$sqlFINCA="SELECT DISTINCT finca FROM plane";
	$resF=$conexion->query($sqlFINCA);

?>
	<!--formulario de fi-->
<style>
	@media screen, print
	{
		td,tr,th{
			border: 1px solid black;
			padding-bottom: 0em;
			height: 10px;
			margin-bottom: 0px;
 			margin-right: 0px;
 			margin-left: 0px;
		}
	}
</style>
<div class="card">
  <div class="card-header">
    <form class="form-inline" action="home.php?menu=tables&report=2" method="post" enctype="multipart/form-data">
	<div class="form-group mx-sm-3 mb-2">
        	<select name="xfinca" class="form-control" data-live-search="true">
				<option value="">Finca</option>
					<?php
					while($rf = $resF->fetch_object()){
						if($rf->finca==$finca){
						echo "<option value='".$rf->finca."' selected='selected'>" .$rf->finca. "</option>";
					}else{
						echo "<option value='".$rf->finca."'>" .$rf->finca. "</option>";
					}
					}
					?>
           </select>
        </div>
		<div class="form-group mx-sm-3 mb-2">
          <label class="sr-only" >Fecha Inicial</label>
          <input type="date" name="dateIni" value="<?php echo $dateIni; ?>" class="form-control" id="inlineFormInputName" >
        </div>
		<? echo "$dateIni"?>
        <div class="form-group mx-sm-3 mb-2">
          <label class="sr-only" >Fecha Final</label>
          <div class="input-group">
            <input type="date" name="dateEnd" value="<?php echo $dateEnd; ?>" class="form-control" id="inlineFormInputGroupUsername" >
          </div>
        </div>
	  	<div class="form-group mx-sm-3 mb-2">
        	<select name="xtipo" class="form-control" data-live-search="true">
				<option value="">Tipo</option>
					<?php
					while($rp = $resT->fetch_object()){
						if($rp->tipo==$tipo){
						echo "<option value='".$rp->tipo."' selected='selected'>" .$rp->tipo. "</option>";
					}else{
						echo "<option value='".$rp->tipo."'>" .$rp->tipo. "</option>";
					}
					}
					?>
           </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
              <button name="buscar" type="submit" class="btn btn-primary mb-2">Buscar</button>
        </div>
		<div class="form-group mx-sm-3 mb-2">
              <button name="imprimir" type="submit" class="btn btn-primary mb-2" onclick="window.print();">Imprimir</button>
        </div>
   </form>
  </div>
</div>
<br>
<?php
//echo $sql;
	if ($res->num_rows>0)
	{
		$finicial=new Carbon($dateIni);
		$ffinal=new Carbon($dateEnd);
		echo "<h5>".$finca."</h2>";
		echo "<h5>Reporte Semanal de Aplicaciones</h2>";
		echo "<h5>".$tipo."</h2>";
		echo "<h5>Entre el: ".$finicial->format('d-m-y/W')." Y ".$ffinal->format('d-m-y/W')."</h3>";
		?>
		<div class="row">
			<div class="col-12">
				<table class="table table-responsive table-sm">
				<tr>
					<th>Bloque</th><th>Aplicar</th>
					<th>Variedad</th><th>Temporada</th>
					<th>#Cama Fisica</th><th>#Cama Real</th>
					<th>Realizado</th>
				</tr>
					<?php
					while($f = $res->fetch_object())
					{
						echo "<tr><td>" .$f->bloque. "</td><td>" .$f->aplicar. "</td><td>" .$f->variedad. "</td>
						<td>" .$f->temporada. "</td>
						<td>" .number_format($f->camas,0,'','.'). "</td><td>" .number_format($f->ncamas,0,'','.'). "</td><td></td></tr>";
					}
					?>	 
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-6">
			<h7>Resumen por bloque</h7>
				<table class="table table-responsive table-sm">
				<tr>
					<th>Bloque</th><th>Aplicar</th><th>#Cama Fisica</th><th>#Cama Real</th>
				</tr>
				<?php
				while($f = $res2->fetch_object())
				{
					echo "<tr>
					<td>" .$f->bloque. "</td><td>" .$f->aplicar. "</td><td>" .number_format($f->camas,0,'','.'). "</td><td>" .number_format($f->ncamas,0,'','.'). "</td>
					</tr>";
				}
				?>	
				</table>
			</div>
			<div class="col-6">
			<h7><stong>Resumen por tipo de aplicación</strong></h7>
				<table class="table table-responsive table-sm">
				<tr>
					<th>Aplicar</th><th>#Cama Fisica</th><th>#Cama Real</th>
				</tr>
				<?php
				while($f = $res3->fetch_object())
				{
					echo "<tr>
					<td>" .$f->aplicar. "</td><td>" .number_format($f->camas,0,'','.'). "</td><td>" .number_format($f->ncamas,0,'','.'). "</td>
					</tr>";
				}
				?>	
				</table>
			</div>
		</div>
		<?php
		}
		else 
		{
			echo "0 results";
		}
			//cerrar conexion
			$conexion->close();
 	?>   