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

////////////producto='".$producto."' ";
//inicializa variable vacia
$where=" WHERE p.plantas>0 ";
$programa="";
if(isset($_POST['xprograma'])){
    $programa=$_POST['xprograma'];
  }

if(isset($_POST['buscar']) || isset($_POST['Exportar'])){
        $where=" WHERE p.plantas>0 and p.programa='".$programa."' " ;
}
    //CONSULTA
    $sql="SELECT p.variedad,p.temporada_obj,p.producto,p.ciclo,
    p.fecha_siembra,p.fecha_pico,sum(p.plantas) as plantas,ROUND(sum(p.plantas)/960,0) as ncamas,
    p.fecha_temporada,p.fecha_ensarte,p.fecha_cosecha
    FROM program as p
    $where
    GROUP BY p.variedad,p.temporada_obj,p.producto,p.fecha_siembra,p.fecha_pico
    ORDER BY p.fecha_temporada,P.fecha_siembra,p.producto,p.variedad ASC
    ";
    $result=$conexion->query($sql);
    //consulta para exportar a excel
    $sqlX="SELECT p.variedad,p.temporada_obj,p.producto,p.ciclo,
    p.fecha_siembra,p.fecha_pico,sum(p.plantas) as plantas,ROUND(sum(p.plantas)/960,0) as ncamas,
    p.fecha_temporada,p.fecha_ensarte,p.fecha_cosecha
    FROM program as p
    $where
    GROUP BY p.variedad,p.temporada_obj,p.producto,p.fecha_siembra,p.fecha_pico
    ORDER BY p.fecha_temporada,P.fecha_siembra,p.producto,p.variedad ASC
    ";

    $resultX=$conexion->query($sqlX);

    //CONSULTA PARA COMBO
    $slqCOMBO="SELECT programa FROM program GROUP BY programa";
    $COM=$conexion->query($slqCOMBO);

?>

<div class="card">
<div class="card-header ">
<form class="form-inline" action="home.php?menu=tables&report=4" method="post" enctype="multipart/form-data">
<div class="form-group mb-2">
    <select name="xprograma" class="form-control" data-live-search="true"> <!--FINCA-->
      <option value="">Año Programa</option>
      <?php
      while($f = $COM->fetch_object()){
        if($f->programa==$programa){
        echo "<option value='".$f->programa."' selected='selected'>" .$f->programa. "</option>";
      }else{
        echo "<option value='".$f->programa."'>" .$f->programa. "</option>";
      }
      }
       ?>
       </select>
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
     <tr><th>Variedad</th><th>Ciclo</th><th># Camas</th><th># Plantas</th><th>Cosecha Deseada</th>
     <th>Fecha Siembra Teo</th><th>Fecha Temporada</th><th>Fecha Pico</th>
     <th>AAAA-SS Teo</th><th>AAAA-SS Ensarte</th>
     </tr>

     <?php

while ($f=$result->fetch_object()){
  $fecha=new carbon($f->fecha_siembra);
  $fechae=new carbon($f->fecha_ensarte);
    if (isset($_POST['buscar']) || isset($_POST['Exportar'])){

            echo "<tr><td>" .$f->variedad. "</td><td>" .$f->ciclo. "</td><td>" .$f->ncamas. "</td>
            <td>" .$f->plantas. "</td> <td>" .$f->temporada_obj. "</td><td>" .$f->fecha_siembra. "</td>
            <td>" .$f->fecha_temporada. "</td><td>" .$f->fecha_pico. "</td>
       <td>" .$fecha->year.'-'.$fecha->format('W'). "</td>
       <td>" .$fechae->year.'-'.$fechae->format('W'). "</td>
       </tr>";

    }else{

    //pintar todas las filas filas
            echo "<tr><td>" .$f->variedad. "</td><td>" .$f->ciclo. "</td><td>" .$f->ncamas. "</td>
            <td>" .$f->plantas. "</td> <td>" .$f->temporada_obj. "</td><td>" .$f->fecha_siembra. "</td>
        <td>" .$fecha->year.'-'.$fecha->format('W'). "</td>
        <td>" .$fechae->year.'-'.$fechae->format('W'). "</td>
        </tr>";
    }
}

    echo "</table>";
    echo "</div>";
    echo "</div>";
   }
   else{
    echo "</table>";
    echo "</div>";
    echo "</div>";
   }
          //Exportar a excel
/////////////////////////////////PENDIENTE HACIA ABAJO
          if (isset($_POST['Exportar'])) {
            $spreadsheet=new Spreadsheet();
            $sheet=$spreadsheet->getActiveSheet();
            $i=2;
        //encabezados de campos para exportar
        				//titulos de columnas
        $sheet->setCellValueByColumnAndRow(3,1,'Producto');
				$sheet->setCellValueByColumnAndRow(4,1,'Variedad');
				$sheet->setCellValueByColumnAndRow(5,1,'Temporada');
				$sheet->setCellValueByColumnAndRow(6,1,'Fecha de Siembra');
				$sheet->setCellValueByColumnAndRow(7,1,'Fecha Ensarte');
				$sheet->setCellValueByColumnAndRow(8,1,'Fecha Cosecha');
				$sheet->setCellValueByColumnAndRow(9,1,'Fecha de Pico');
				$sheet->setCellValueByColumnAndRow(10,1,'Fecha Temporada');
				$sheet->setCellValueByColumnAndRow(11,1,'# Plantas');
				$sheet->setCellValueByColumnAndRow(12,1,'Sembrar en...');
				$sheet->setCellValueByColumnAndRow(13,1,'Edad Limite');

        while ($fX=$resultX->fetch_object()){
//ASOCIAR A VARIABLES PARA XSL
            $variedadX=$fX->variedad;
            $temporadaX=$fX->temporada_obj;
            $fecha_siembraX=$fX->fecha_siembra;
            $plantasX=$fX->plantas;
            $fecha_temporadaX=$fX->fecha_temporada;
            $fecha_ensarteX=$fX->fecha_ensarte;
            $fecha_cosechaX=$fX->fecha_cosecha;
            $fecha_picoX=$fX->fecha_pico;
            $productoX=$fX->producto;
            $edadX=carbon::now()->diffInWeeks($fecha_siembraX);
            $fechaiX=new Carbon($fecha_siembraX);
            $edadlimiteX=$fechaiX->addWeeks(72);
//LLEVAR A LA HOJA DE CALCULO
            $sheet->setCellValueByColumnAndRow(3,$i,$productoX);
            $sheet->setCellValueByColumnAndRow(4,$i,$variedadX);
            $sheet->setCellValueByColumnAndRow(5,$i,$temporadaX);
            $sheet->setCellValueByColumnAndRow(6,$i,$fecha_siembraX);
            $sheet->setCellValueByColumnAndRow(7,$i,$fecha_ensarteX);
            $sheet->setCellValueByColumnAndRow(8,$i,$fecha_cosechaX);
            $sheet->setCellValueByColumnAndRow(9,$i,$fecha_picoX);
            $sheet->setCellValueByColumnAndRow(10,$i,$fecha_temporadaX);
            $sheet->setCellValueByColumnAndRow(11,$i,$plantasX);
            $sheet->setCellValueByColumnAndRow(12,$i,$edadX);
            $sheet->setCellValueByColumnAndRow(13,$i,$edadlimiteX);
//INCREMENTO
            $i++;
            }
            $writer=new Xlsx($spreadsheet);
            $writer->save("DatosPrograma.xlsx");
            exit;
        }
   $conexion->close();
?>
