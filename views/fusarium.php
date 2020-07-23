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

//consulta para mostrar
$sql="select
f.finca,f.bloque,f.variedad,f.ntemporada,
sum(CASE WHEN f.pico=1 THEN f.dato  END) AS ppico,
sum(CASE WHEN f.pico=2 THEN f.dato  END) AS spico,
sum(CASE WHEN f.pico=3 THEN f.dato END) AS tpico
from fusarium as f
group by
f.finca,f.bloque,f.variedad,f.ntemporada
";
$query=$conexion->query($sql);

if ($query->num_rows>0){
  ?>
  <div class="table-bordered">
    <table class="table table-responsive">
      <tr><th>Finca</th><th>Bloque</th><th>Variedad</th><th>Temporada</th><th>#camas</th><th>Primer Pico</th>
        <th>Segundo Pico</th><th>TercerPico</th>
      </tr>
      <?php
      while($f = $query->fetch_object()){
        echo "<tr><td>" .$f->finca. "</td><td>" .$f->bloque. "</td><td>" .$f->variedad. "</td><td>" .$f->ntemporada. "</td>
        <td></td><td>" .$f->ppico. "</td>
        <td>" .$f->spico. "</td><td>" .$f->tpico. "</td></tr>";
      }
      echo "</table>";
      echo "</div>";
    }
    else {
      echo "No hay datos";
    }
    $conexion->close();
    ?>
