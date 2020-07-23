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
$fecha_ensarte="";
if(isset($_POST['xprograma'])){
    $programa=$_POST['xprograma'];
  }
  if(isset($_POST['xfecha'])){
      $fecha_ensarte=new Carbon($_POST['xfecha']);
    }

if(isset($_POST['buscar'])){
  if ($programa!="" and $fecha_ensarte=="") {
    $where=" WHERE p.plantas>0 and p.programa='".$programa."' " ;
  } elseif ($programa=="" and $fecha_ensarte!="") {
    $where=" WHERE p.plantas>0 and p.fecha_ensarte between '".$fecha_ensarte->startOfWeek()."' and '".$fecha_ensarte->endOfWeek()."' " ;
  }elseif ($programa!="" and $fecha_ensarte!="") {
    $where=" WHERE p.plantas>0 and p.fecha_ensarte between '".$fecha_ensarte->startOfWeek()."' and '".$fecha_ensarte->endOfWeek()."' and p.programa='".$programa."' " ;
  }
  else {
    $where=" WHERE p.plantas>0 ";
  }
}
    //CONSULTA
    $sql="SELECT p.variedad,p.temporada_obj,p.producto,p.ciclo,
    p.fecha_siembra,p.fecha_pico,sum(p.plantas) as plantas,ROUND(sum(p.plantas)/960,0) as ncamas,
    p.fecha_temporada,p.fecha_ensarte,p.fecha_cosecha
    FROM program as p
    $where
    GROUP BY p.variedad,p.temporada_obj,p.producto
    ORDER BY p.fecha_temporada,P.fecha_siembra,p.producto,p.variedad ASC
    ";
    $result=$conexion->query($sql);

    //CONSULTA PARA COMBO
    $slqCOMBO="SELECT programa FROM program GROUP BY programa";
    $COM=$conexion->query($slqCOMBO);
    //CONSULTA PARA COMBO2
    $slqCOMBO2="SELECT fecha_ensarte FROM program where programa=2020 GROUP BY YEARWEEK(fecha_ensarte)";
    $COM2=$conexion->query($slqCOMBO2);

    //consulta para totales
    $sqlSUM="SELECT SUM(p.plantas) as plantas,ROUND(sum(p.plantas)/18000,2) as bancos
    FROM program as p
    $where
    ";
    $bancos=$conexion->query($sqlSUM);
?>

<div class="card-header d-print-none">
<form class="form-inline" action="home.php?menu=tables&report=7" method="post" enctype="multipart/form-data">
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
     </div><div class="form-group mb-2">
       <select name="xfecha" class="form-control" data-live-search="true"> <!--FINCA-->
         <option value="">Fecha Ensarte</option>
         <?php
         while($f = $COM2->fetch_object()){
           $fe=new Carbon($f->fecha_ensarte);
           if($f->fecha_ensarte==$fecha_ensarte){
           echo "<option value='".$f->fecha_ensarte."' selected='selected'>" .$fe->format('Y-W'). "</option>";
         }else{
           echo "<option value='".$f->fecha_ensarte."'>" .$fe->format('Y-W'). "</option>";
         }
         }
          ?>
          </select>
       </div>

          <button name="buscar" type="submit" class="btn btn-primary mb-2">Buscar</button>

          <button name="Print" type="submit" class="btn btn-success mb-2" onclick="window.print();">Imprimir</button>

</form>
</div>
<div class="row">
<div class="col">
<table class="table table-responsive table-sm">
<?php

if ($result->num_rows>0){
    ?>
<div class="row">
<div class="col">
<table class="table table-responsive table-sm">
       <thead>
         <tr><th colspan="15">Formato de fecha ddmmyyyy/semana</th></tr>
         <tr>
           <th colspan="9"><h1>Programa de Ensartes y Cosechas</h1></th>
           <?php while ($b=$bancos->fetch_object()) {
             echo "<th colspan='3'><h5>";
             echo "No Esquejes: ".number_format($b->plantas,0,',','.');
             echo "</h5></th>";
             echo "<th colspan='3'><h5>";
             echo "Bancos a Usar: ".$b->bancos;
             echo "</h5></th>";
           } ?>
       </tr>
       <tr>
         <th>Fecha_Ensarte</th><th>Producto</th><th>No Banco</th>
         <th>Variedad</th><th>Temporada</th><th>Variedad Rem</th><th>No Plantas Programa</th>
         <th>Fecha Ensarte Real</th><th>No Plantas Ensarte</th>
         <th>Observación</th><th>Fecha Cosecha Teorica</th><th>Fecha Cosecha Real</th>
         <th>#Plantas Real</th><th>No Plantas Perdidas</th><th>Observación</th>
     </tr>
   </thead>
     <?php

while ($f=$result->fetch_object()){
  $fecha=new carbon($f->fecha_siembra);
  $fechae=new carbon($f->fecha_ensarte);
  $fechac=new carbon($f->fecha_cosecha);
    if (isset($_POST['buscar'])){

            echo "<tr class='h'><td>".$fechae->startOfWeek()->addDays(3)->format('d-m-Y/W')."</td>
            <td>" .$f->producto. "</td><td></td><td>" .$f->variedad. "</td>
            <td>" .$f->temporada_obj. "</td>
            <td></td> <td>" .number_format($f->plantas,0,',','.'). "</td>
            <td></td><td></td>
       <td></td>
       <td>" .$fechac->startOfWeek()->format('d-m-Y/W'). "</td><td></td><td></td><td></td><td></td>
       </tr>";

    }else{
    //pintar todas las filas filas
          echo "<tr class='h'><td>".$fechae->startOfWeek()->addDays(3)->format('d-m-Y/W')."</td>
          <td>" .$f->producto. "</td><td></td><td>" .$f->variedad. "</td>
          <td>" .$f->temporada_obj. "</td>
          <td></td> <td>" .number_format($f->plantas,0,',','.'). "</td>
          <td></td><td></td>
      <td></td>
      <td>" .$fechac->startOfWeek()->format('d-m-Y/W'). "</td><td></td><td></td><td></td>
      </tr>";
    }
}
?>
</div>
</div>
<?php
//cerrar divs
    echo "</table>";
    echo "</div>";
}
?>
</div>
</div>
<?php
//$conexion->close();
?>
