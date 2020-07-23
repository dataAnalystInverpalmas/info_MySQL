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
    ?>
    <h2>Filterable Table</h2>
    <p>Type something in the input field to search the table for first names, last names or emails:</p>  
    <input id="myInput" type="text" placeholder="Search..">
    <br><br>
    <?php

    if (isset($_POST['vista'])){

    $sql="CREATE or REPLACE VIEW budget as
    SELECT p.finca,p.bloque,p.producto,p.variedad,p.temporada,v.ciclo,v.codvari,
    v.color,s.cod_temporada,
    p.fecha_siembra,'PLANO' AS tipo,sum(p.plantas) as plantas
    FROM plane as p
    LEFT JOIN Varieties AS v
    ON p.variedad=v.nombre
    LEFT JOIN seasons as s
    ON p.temporada=s.nombre
    GROUP BY p.finca,p.bloque,p.variedad,p.temporada,p.fecha_siembra
    UNION
    SELECT pf.finca,pf.bloque,pf.producto,pf.variedad,pf.temporada_obj,v.ciclo,v.codvari,
    v.color,s.cod_temporada,
    pf.fecha_siembra, pf.programa as tipo,sum(pf.plantas)
    FROM programf as pf
    LEFT JOIN Varieties AS v
    ON pf.variedad=v.nombre
    LEFT JOIN seasons as s
    ON pf.temporada_obj=s.nombre
    GROUP BY pf.finca,pf.bloque,pf.variedad,pf.temporada_obj,pf.fecha_siembra
    ";

    $query=$conexion->query($sql);

    echo "Vista Actualizada";
    }
        $sql="SELECT finca,bloque,producto,variedad,temporada,color,
        fecha_siembra,sum(plantas) as plantas,tipo,ciclo,codvari,cod_temporada
        FROM budget
        GROUP BY finca,bloque,producto,variedad,temporada,fecha_siembra,tipo
         order by fecha_siembra desc
        ";
        $result=$conexion->query($sql);

        $sqlX="SELECT finca,bloque,producto,variedad,temporada,color,
        fecha_siembra,sum(plantas) as plantas,tipo,ciclo,codvari,cod_temporada
        FROM budget
        GROUP BY finca,bloque,producto,variedad,temporada,fecha_siembra,tipo
         order by fecha_siembra desc
        ";
        $resultX=$conexion->query($sqlX);
        ?>

        <form class="form-inline" action="home.php?menu=tables&report=5" method="post" enctype="multipart/form-data">
        <input type='submit' name='vista' value='vista' id='vista'>
        <input type='submit' name='exportar' value='exportar' id='exportar'>
        </form>
        <?php
    if ($result->num_rows>0){
      if (isset($_POST['exportar'])){
        $spreadsheet=new Spreadsheet();
				$sheet=$spreadsheet->getActiveSheet();
				$i=2;
				//titulos de columnas
				$sheet->setCellValueByColumnAndRow(1,1,'Finca');
				$sheet->setCellValueByColumnAndRow(2,1,'Bloque');
				$sheet->setCellValueByColumnAndRow(3,1,'Producto');
				$sheet->setCellValueByColumnAndRow(4,1,'Variedad');
				$sheet->setCellValueByColumnAndRow(5,1,'Temporada');
				$sheet->setCellValueByColumnAndRow(6,1,'Fecha_siembra');
				$sheet->setCellValueByColumnAndRow(7,1,'Plantas');
        $sheet->setCellValueByColumnAndRow(8,1,'Tipo');
				$sheet->setCellValueByColumnAndRow(9,1,'Ciclo');
				$sheet->setCellValueByColumnAndRow(10,1,'Cod_variedad');
				$sheet->setCellValueByColumnAndRow(11,1,'Cod_Temporada');
        $sheet->setCellValueByColumnAndRow(12,1,'Color');

			while ($fX=$resultX->fetch_object()){
	//ASOCIAR A VARIABLES PARA XSL
				$fincaX=$fX->finca;
				$bloqueX=$fX->bloque;
        $productoX=$fX->producto;
				$variedadX=$fX->variedad;
				$temporadaX=$fX->temporada;
				$fecha_siembraX=$fX->fecha_siembra;
				$plantasX=$fX->plantas;
				$tipoX=$fX->tipo;
        $cicloX=$fX->ciclo;
        $codvariX=$fX->codvari;
        $cod_temporadaX=$fX->cod_temporada;
        $colorX=$fX->color;

      $sheet->setCellValueByColumnAndRow(1,$i,$fincaX);
      $sheet->setCellValueByColumnAndRow(2,$i,$bloqueX);
      $sheet->setCellValueByColumnAndRow(3,$i,$productoX);
      $sheet->setCellValueByColumnAndRow(4,$i,$variedadX);
      $sheet->setCellValueByColumnAndRow(5,$i,$temporadaX);
      $sheet->setCellValueByColumnAndRow(6,$i,$fecha_siembraX);
      $sheet->setCellValueByColumnAndRow(7,$i,$plantasX);
      $sheet->setCellValueByColumnAndRow(8,$i,$tipoX);
      $sheet->setCellValueByColumnAndRow(9,$i,$cicloX);
      $sheet->setCellValueByColumnAndRow(10,$i,$codvariX);
      $sheet->setCellValueByColumnAndRow(11,$i,$cod_temporadaX);
      $sheet->setCellValueByColumnAndRow(12,$i,$colorX);

//INCREMENTO
      $i++;
      }

      $writer=new Xlsx($spreadsheet);
      $writer->save("DatosPTO.xlsx");
      exit;
      $conexion->close();
    }
?>
<div class="row">
<div class="col">
<table class="table table-responsive table-sm">
<?php
            echo "<thead>";
                echo "<tr>";
                    echo "<th>Finca</th>
                          <th>Blqoque</th>
                          <th>Variedad</th>
                          <th>Temporada</th>
                          <th>Color</th>
                          <th>Ciclo</th>
                          <th>Codigo</th>
                          <th>Fecha Siembra</th>
                          <th>Plantas</th>
                          <th>Tipo</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody id='myTable'>";
            while ($f=$result->fetch_object()){
                echo "<tr>";
                    echo "<td>".$f->finca."</td>";
                    echo "<td>".$f->bloque."</td>";
                    echo "<td>".$f->variedad."</td>";
                    echo "<td>".$f->temporada."</td>";
                    echo "<td>".$f->color."</td>";
                    echo "<td>".$f->ciclo."</td>";
                    echo "<td>".$f->codvari."</td>";
                    echo "<td>".$f->fecha_siembra."</td>";
                    echo "<td>".$f->plantas."</td>";
                    echo "<td>".$f->tipo."</td>";
                echo "</tr>";
            }
            echo "</tbody>";
        echo "</table>";
     
    ?>
    </div>
    </div>
    <?php    
    }//cierra div en caso de que muestre resultados

   //echo "";


?>
