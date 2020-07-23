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
$producto="";
$temporada="";
$fecha_ensarte="";
$finca="";
$encabezado=0;
$variedad="";

if(isset($_POST['xprograma']))
{
  $programa=$_POST['xprograma'];
}
if(isset($_POST['xproducto']))
{
  $producto=$_POST['xproducto'];
}
if(isset($_POST['xtemporada']))
{
  $temporada=$_POST['xtemporada'];
}
if(isset($_POST['xfinca']))
{
  $finca=$_POST['xfinca'];
}
if(isset($_POST['xvariedad']))
{
  $variedad=$_POST['xvariedad'];
}

if(isset($_POST['buscar']))
{
  if ($programa!="" and $producto=="" and $temporada=="" and $finca=="" and $variedad="") 
  {
    $where=" WHERE p.plantas>0 and p.programa='".$programa."' " ;
  }
  elseif ($programa=="" and $producto!="" and $temporada=="" and $finca=="" and $variedad="") 
  {
    $where=" WHERE p.plantas>0 and p.producto='".$producto."' " ;
  }
  elseif ($programa!="" and $producto!="" and $temporada=="" and $finca=="" and $variedad="") 
  {
    $where=" WHERE p.plantas>0 and p.producto='".$producto."' and p.programa='".$programa."' " ;
  }
  elseif ($programa!="" and $producto!="" and $temporada!="" and $finca!="" and $variedad="") 
  {
    $where=" WHERE p.plantas>0 and p.producto='".$producto."'
    and p.programa='".$programa."' and p.temporada_obj='".$temporada."' and p.finca='".$finca."' " ;
    $encabezado=1;
  }
  elseif ($programa=="" and $producto=="" and $temporada!="" and $finca=="" and $variedad="") 
  {
    $where=" WHERE p.plantas>0 and p.temporada_obj='".$temporada."' " ;
  }
  elseif ($programa=="" and $producto!="" and $temporada!="" and $finca!="" and $variedad="") 
  {
    $where=" WHERE p.plantas>0 and p.producto='".$producto."' and p.temporada_obj='".$temporada."'
    and p.finca='".$finca."' " ;
    $encabezado=1;
  }
  else 
  {
    $where=" WHERE p.plantas>0 ";
  }
}

    //CONSULTA
    $sql="SELECT p.variedad,p.temporada_obj,p.producto,p.ciclo,
    p.fecha_siembra,p.fecha_pico,p.finca,p.bloque,
    sum(p.plantas) as plantas,ROUND(sum(p.plantas)/960,0) as ncamas
    FROM programf as p
    $where
    GROUP BY p.variedad,p.temporada_obj,p.producto,p.fecha_siembra,p.fecha_pico
    ORDER BY P.fecha_siembra,p.producto,p.variedad ASC
    ";
    $result=$conexion->query($sql);

    //CONSULTA PARA COMBO
    $slqCOMBO="SELECT programa FROM programf GROUP BY programa";
    $COM=$conexion->query($slqCOMBO);
    //CONSULTA PARA COMBO2
    $slqCOMBO2="SELECT producto FROM programf GROUP BY 1";
    $COM2=$conexion->query($slqCOMBO2);
    //CONSULTA PARA COMBO3
    $slqCOMBO3="SELECT temporada_obj FROM programf WHERE Programa=2020 GROUP BY 1";
    $COM3=$conexion->query($slqCOMBO3);
    //CONSULTA PARA COMBO4
    $slqCOMBO4="SELECT finca FROM programf GROUP BY 1";
    $COM4=$conexion->query($slqCOMBO4);
    //CONSULTA PARA COMBO5
    $slqCOMBO5="SELECT variedad FROM programf GROUP BY 1";
    $COM5=$conexion->query($slqCOMBO5);
    //CONSULTAS PARA ENCABEZADO INDEPENDIENTES
    $sqlSUM="SELECT finca,programa,producto,tipo,temporada_obj,fecha_pico,sum(plantas) as plantas,sum(plantas)/960 as ncamas
    FROM programf as p
    $where
    GROUP BY 1,2,3,4,5,6
    ";
    $bancos=$conexion->query($sqlSUM);
?>

<div class="card-header d-print-none">
<form class="form-inline" action="home.php?menu=tables&report=8" method="post" enctype="multipart/form-data">
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
       <select name="xproducto" class="form-control" data-live-search="true"> <!--FINCA-->
         <option value="">Producto</option>
         <?php
         while($f = $COM2->fetch_object()){

           if($f->producto==$producto){
           echo "<option value='".$f->producto."' selected='selected'>" .$f->producto. "</option>";
         }else{
           echo "<option value='".$f->producto."'>" .$f->producto. "</option>";
         }
         }
          ?>
          </select>
          <select name="xtemporada" class="form-control" data-live-search="true"> <!--FINCA-->
            <option value="">Temporada</option>
            <?php
            while($f = $COM3->fetch_object()){

              if($f->temporada_obj==$temporada){
              echo "<option value='".$f->temporada_obj."' selected='selected'>" .$f->temporada_obj. "</option>";
            }else{
              echo "<option value='".$f->temporada_obj."'>" .$f->temporada_obj. "</option>";
            }
            }
             ?>
             </select>
             <select name="xvariedad" class="form-control" data-live-search="true"> <!--FINCA-->
               <option value="">Variedad</option>
               <?php
               while($f = $COM5->fetch_object()){

                 if($f->variedad==$variedad){
                 echo "<option value='".$f->variedad."' selected='selected'>" .$f->variedad. "</option>";
               }else{
                 echo "<option value='".$f->variedad."'>" .$f->variedad. "</option>";
               }
               }
                ?>
                </select>
             <select name="xfinca" class="form-control" data-live-search="true"> <!--FINCA-->
               <option value="">Finca</option>
               <?php
               while($f = $COM4->fetch_object()){

                 if($f->finca==$finca){
                 echo "<option value='".$f->finca."' selected='selected'>" .$f->finca. "</option>";
               }else{
                 echo "<option value='".$f->finca."'>" .$f->finca. "</option>";
               }
               }
                ?>
                </select>
       </div>
    <div class="form-group mx-sm-3 mb-2">
          <button name="buscar" type="submit" class="btn btn-primary mb-2">Buscar</button>
    </div>
    <div class="form-group mx-sm-3 mb-2">
          <button name="Print" type="submit" class="btn btn-success mb-2" onclick="window.print();">Imprimir</button>
    </div>
</form>
</div>

<?php

if ($result->num_rows>0){
    ?>
<div class="row">
  <div class="col">
    <table class="table table-responsive table-sm">
      <thead>
        <tr><th colspan='11'><br><strong>Resumen programa de Siembras</strong><br>Formato fechas dd-mm-aaaa/Semana</th></tr>
         <?php
         if ($encabezado==1){
          ?>
         <tr>
           <?php while ($b=$bancos->fetch_object()) {
             $fecha=new carbon($b->fecha_pico);
             echo "<th colspan='2'><h6>Programa <br> Siembras ".$b->programa."</h5></th>";
             echo "<th colspan='2'><h6>";
             echo "Finca: <br>".$b->finca." ";
             echo "</h5></th>";
             echo "<th colspan='2'><h6>";
             echo "Producto: <br>".$b->producto." ";
             echo "</h5></th>";
             echo "<th colspan='2'><h6>";
             echo "Temporada: <br>".$b->temporada_obj." ";
             echo "</h5></th>";
             echo "<th colspan='2'><h6>";
             echo "Fecha de pico: <br>".$fecha->format('d-m-Y/W')."";
             echo "</h5></th>";
             echo "<th colspan='1'><h6>";
             echo "#Camas: <br>".number_format($b->ncamas,0,',','.')." ";
             echo "</h5></th>";
             echo "<th colspan='1'><h6>";
             echo "#Plantas: <br>".number_format($b->plantas,0,',','.')."";
             echo "</h5></th>";
             echo "<th colspan='1'><h6>";
             echo "Tipo: <br>".$b->tipo." ";
             echo "</h5></th>";
           } ?>
       </tr>
     <?php } ?>
       <tr>
         <th>Variedad</th><th>Variedad Reemplazo</th><th>Ciclo</th>
         <th>No Camas</th><th>No Platas Teorico</th><th>No Plantas Real</th>
         <th>Fecha Siembra Teorica</th><th>Temporada</th>
         <th>Finca Teorica</th><th>Finca Real</th>
         <th>Observaciones</th>
     </tr>
   </thead>
     <?php

while ($f=$result->fetch_object()){
  $fecha=new carbon($f->fecha_siembra);
    if (isset($_POST['buscar'])){

            echo "<tr class='h'><td>".$f->variedad."</td><td></td>
            <td>" .$f->ciclo. "</td><td>".$f->ncamas."</td><td>" .number_format($f->plantas,0,',','.'). "</td><td></td>
            <td>".$fecha->endOfWeek()->subDays(4)->format('d-m-Y/W')."</td> <td>".$f->temporada_obj."</td><td>".$f->finca."</td>
            <td></td>
       <td></td>
       </tr>";

    }else{
    //pintar todas las filas filas
    echo "<tr class='h'><td>".$f->variedad."</td><td></td>
    <td>" .$f->ciclo. "</td><td>".$f->ncamas."</td><td>" .number_format($f->plantas,0,',','.'). "</td><td></td>
    <td>".$fecha->endOfWeek()->subDays(4)->format('d-m-Y/W')."</td><td>".$f->temporada_obj."</td><td></td><td>".$f->finca."</td>
    <td></td>
<td></td><td></td><td></td>
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

<?php
//$conexion->close();
?>
