<?php

//lamar conexion
include ('funciones/conexion.php');
//funciones personalizadas
//carbon
require "vendor/autoload.php";
use Carbon\Carbon;

	$di=Carbon::now('-5:00');
	$de=Carbon::now('-5:00');
	$dateEnd=new Carbon();
	$dateIni=new Carbon();

	$dateIni=$di->format('Y-m-d');
	$dateEnd=$de->endOfWeek()->format('Y-m-d');
	//consulta para combos
	$where=" WHERE t3.codigo = 0 ";

	if(empty($_POST['xq']))
	{//las dos estan vacias
		$xq="";
	}
	else//en caso de que esten seteadas las dos, asignar valores
	{
		$xq=$_POST['xq'];
	}

	if(isset($_POST['buscar'])){
		$dateIni=$_POST['dateIni'];
		$dateEnd=$_POST['dateEnd'];
		if ($xq=='')//condicion para filtrar tipo de aplicacion
		{
			$where.='';
		}
		else
		{
			$where.=" AND T3.pregunta='".$xq."' ";
		}
		//resto de la condicion que siempre se cumple
		$where.=" AND  t1.fecha between
			  '$dateIni' AND '$dateEnd' 		  
			  ";
	}else
	{//en caso de no haber presionado  buscar, hace...
		$where.=" AND
		t1.fecha between
		'$dateIni' AND '$dateEnd' 		  
		";
	}

	//consulta para tabla
	$sql="SELECT 
        t1.fecha,
        t2.nombre,
        if(t1.turno=1,'Entrada','Salida') as turno,
        t3.pregunta,
        t1.valor,
        t2.finca,
        t4.nombre as supervisor
    FROM
        datacovid as t1
    LEFT JOIN
        employees as t2
    ON
        t2.codigo=t1.codigo
    LEFT JOIN
         questions as t3
    ON
        t3.codigo=t1.pregunta
    LEFT JOIN
        supervisors as t4
    ON
        t4.codigo=t2.jefe_inmediato
    $where
    ORDER BY t1.fecha,t2.nombre asc
		";

	$res=$conexion->query($sql);

	//consulta pregunta
	$sqlXQ="SELECT DISTINCT pregunta FROM questions";
	$resXQ=$conexion->query($sqlXQ);
?>
	<!--formulario de fi-->
<style>
	@media print
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
    <form class="form-inline" action="home.php?menu=tables&report=1002" method="post" enctype="multipart/form-data">
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
			<select name="xq" class="form-control" data-live-search="true">
				<option value="">Pregunta</option>
				<?php
					while($rp = $resXQ->fetch_object())
					{
						if($rp->pregunta==$xq)
						{
							echo "<option value='".$rp->pregunta."' selected='selected'>" .$rp->pregunta. "</option>";
						}else
						{
							echo "<option value='".$rp->pregunta."'>" .$rp->pregunta. "</option>";
						}
					}
				?>
			</select>
		</div>
		<div class="form-group mx-sm-3 mb-2">
			<button name="buscar" type="submit" class="btn btn-secondary mb-2">Buscar</button>
			<button name="imprimir" type="submit" class="btn btn-primary mb-2" onclick="window.print();">Imprimir</button>
		</div>
        <div class="input-group input-group-sm-3 mb-2">            
        <input class="form-control" id="myInput" type="text" placeholder="Busqueda...">
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
		echo "<h5>Reporte de Datos Entre el: ".$finicial->format('d-m-Y')." y el ".$ffinal->format('d-m-Y')."</h3>";
		?>

		<div class="row">
			<div class="col-12">
				<table class="table table-responsive table-sm">
				<thead>
                <tr>
					<th>Fecha</th>
                    <th>Nombre</th>
                    <th>Pregunta</th>
                    <th>Turno</th>
                    <th>Valor</th>
                    <!-- <th>Finca</th>
                    <th>Supervisor</th> -->
				</tr>
                </thead>
				<?php
				while($f = $res->fetch_object())
				{
                    ?>
				<tbody id='myTable'>
                <tr>
					<td><?php echo $f->fecha; ?></td>
                    <td><?php echo $f->nombre; ?></td>
                    <td><?php echo $f->pregunta; ?></td>
                    <td><?php echo $f->turno; ?></td>
					<td>
						<?php 
						if ($f->valor==='0')
						{
							echo 'No';
						}
						else if ($f->valor==='1')
						{
							echo 'Si';
						}
						else
						{
							echo $f->valor; 
						}
						?>
					</td>
                    <!-- <td><?php echo $f->finca; ?></td>
                    <td><?php echo $f->supervisor; ?></td> -->
				</tr>
                </tbody>
                    <?php
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