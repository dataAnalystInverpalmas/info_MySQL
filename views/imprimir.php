<?php
//lamar conexion
include ('funciones/conexion.php');
//funciones personalizadas
//carbon
require "vendor/autoload.php";
require "dist/data.php";
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

$mpdf = new \Mpdf\Mpdf();
$resultado=$conexion->query($sqlVariedadesV);
$var="Hola PHP";
$mpdf->Bookmark('Start of the document');
$html="";
$html.=
"
<div>
$var
</div>
";

$mpdf->WriteHTML($html);

$mpdf->Output('prueba.pdf');

?>
Prueba
<canvas id="barcode"></canvas>
<script>
JsBarcode("#barcode", "CODE39 Barcode", {
  format: "CODE39"
});
</script>