<?php
include ('funciones/conexion.php');

//variables filtrar datos
if(empty($_POST['xproducto'])){
  $producto="";
}else{
  $producto=$_POST['xproducto'];
}
if(empty($_POST['xanno'])){
  $anno="";
}else{
  $anno=$_POST['xanno'];
}
if(empty($_POST['xvariedad'])){
  $variedad="";
}else{
  $variedad=$_POST['xvariedad'];
}
//ahora $where
$where="";
//ano
$ano=date('Y');
//boton buscar
if(isset($_POST['search'])){
  if (!Empty($_POST['xproducto']) and (Empty($_POST['xanno'])) and (Empty($_POST['xvariedad']))){
    $where=" WHERE producto='".$producto."' ";
  }else if(Empty($_POST['xproducto']) and (!Empty($_POST['xanno'])) and (Empty($_POST['xvariedad']))){
    $where=" WHERE ano='".$anno."' ";
  }else if(Empty($_POST['xproducto']) and (Empty($_POST['xanno'])) and (!Empty($_POST['xvariedad']))){
    $where=" WHERE variedad='".$variedad."' ";
  }else if(!Empty($_POST['xproducto']) and (!Empty($_POST['xanno'])) and (Empty($_POST['xvariedad']))){
    $where=" WHERE producto='".$producto."' AND ano='".$anno."' ";
  }else if(Empty($_POST['xproducto']) and (!Empty($_POST['xanno'])) and (!Empty($_POST['xvariedad']))){
    $where=" WHERE variedad='".$variedad."' AND ano='".$anno."' ";
  }
  else {
    $where="";
  }
}

?>
<div class="card">
  <div class="card-header">
    <div class="dropdown dropleft float-right">
      <button type="button" class="btn btn-primary dropdown-toggle " data-toggle="dropdown">
        Reports
      </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="index.php?menu=pr&inf=1">Analisis Produccion</a>
        <a class="dropdown-item" href="index.php?menu=pr&inf=2">Calidades y procesados</a>
        <a class="dropdown-item" href="index.php?menu=pr&inf=3">Indices Anuales</a>
      </div>
  </div>
  <!--Filtros de acuerdo a la pagina--------------------------------------------------->
  <?php if (empty($_GET['inf'])){ ?>
  </div>
  </div>
  <?php }else if (($_GET['inf'])==1){ //si tiene el valor 1 traera el primer informe ?>
    <div class="dropdown dropleft float-left">
      <form class="form-inline" action="index.php?menu=pr&inf=1" method="post" enctype="multipart/form-data">
        <div class="form-group mx-sm-3 mb-2">
          <select name="xproducto" class="form-control" data-live-search="true">
            <option value="">Producto</option>
            <?php
            //consulta producto
            $p="SELECT DISTINCT producto FROM produccion";
            $resp=$conexion->query($p);
            while($rp = $resp->fetch_object()){
              if($rp->producto==$producto){
                echo "<option value='".$rp->producto."' selected='selected'>" .$rp->producto. "</option>";
              }else {
                echo "<option value='".$rp->producto."'>" .$rp->producto. "</option>";
              }
            }
             ?>
             </select>
             <select name="xanno" class="form-control" data-live-search="true">
               <option value="">Año</option>
               <?php
               //consulta producto
               $a="SELECT DISTINCT ano FROM produccion";
               $resa=$conexion->query($a);
               while($ra = $resa->fetch_object()){
                 if($ra->ano==$anno){
                  echo "<option value='".$ra->ano."' selected='selected'>" .$ra->ano. "</option>";
                 }else {
                  echo "<option value='".$ra->ano."'>" .$ra->ano. "</option>";
                 }
               }
                ?>
              </select>
          </div>
          <button name="search" type="submit" class="btn btn-primary mb-2">Search</button>
      </form>
    </div>
  </div>
  </div>
  <?php }else if (($_GET['inf'])==2){ //si tiene el valor 1 traera el primer informe ?>
    <div class="dropdown dropleft float-left">
      <form class="form-inline" action="index.php?menu=pr&inf=1" method="post" enctype="multipart/form-data">
        <div class="form-group mx-sm-3 mb-2">
          <select name="xproducto" class="form-control" data-live-search="true">
            <option value="">Producto</option>
            <?php
            //consulta producto
            $p="SELECT DISTINCT producto FROM produccion";
            $resp=$conexion->query($p);
            while($rp = $resp->fetch_object()){
              if($rp->producto==$producto){
                echo "<option value='".$rp->producto."' selected='selected'>" .$rp->producto. "</option>";
              }else {
                echo "<option value='".$rp->producto."'>" .$rp->producto. "</option>";
              }
            }
             ?>
             </select>
             <select name="xanno" class="form-control" data-live-search="true">
               <option value="">Año</option>
               <?php
               //consulta producto
               $a="SELECT DISTINCT ano FROM produccion";
               $resa=$conexion->query($a);
               while($ra = $resa->fetch_object()){
                 if($ra->ano==$anno){
                   echo "<option value='".$ra->ano."' selected='selected'>" .$ra->ano. "</option>";
                 }else {
                   echo "<option value='".$ra->ano."'>" .$ra->ano. "</option>";
                 }
               }
                ?>
              </select>
          </div>
          <button name="search" type="submit" class="btn btn-primary mb-2">Search</button>
      </form>
    </div>
  </div>
  </div>
<?php }else if (($_GET['inf'])==3){ //si tiene el valor 1 traera el primer informe  ?>
  <div class="dropdown dropleft float-left">
    <form class="form-inline" action="index.php?menu=pr&inf=3" method="post" enctype="multipart/form-data">
      <div class="form-group mx-sm-3 mb-2">
        <select name="xproducto" class="form-control" data-live-search="true">
          <option value="">Producto</option>
          <?php
          //consulta producto
          $p="SELECT DISTINCT producto FROM produccion";
          $resp=$conexion->query($p);
          while($rp = $resp->fetch_object()){
            if ($rp->producto==$producto){
                echo "<option value='".$rp->producto."' selected='selected'>" .$rp->producto. "</option>";
            }else {
                echo "<option value='".$rp->producto."'>" .$rp->producto. "</option>";
            }
          }
           ?>
           </select>
           <select name="xanno" class="form-control" data-live-search="true">
             <option value="">Año</option>
             <?php
             //consulta producto
             $a="SELECT DISTINCT ano FROM produccion";
             $resa=$conexion->query($a);
             while($ra = $resa->fetch_object()){
               if($ra->ano==$anno){
                echo "<option value='".$ra->ano."' selected='selected'>" .$ra->ano. "</option>";
               }else {
                echo "<option value='".$ra->ano."'>" .$ra->ano. "</option>";
               }
             }
              ?>
            </select>
            <select name="xvariedad" class="form-control" data-live-search="true">
              <option value="">Variedad</option>
              <?php
              //consulta producto
              $v="SELECT DISTINCT variedad FROM produccion";
              $reva=$conexion->query($v);
              while($rv = $reva->fetch_object()){
                if($rv->variedad==$variedad){
                 echo "<option value='".$rv->variedad."' selected='selected'>" .$rv->variedad. "</option>";
                }else {
                 echo "<option value='".$rv->variedad."'>" .$rv->variedad. "</option>";
                }
              }
               ?>
             </select>
        </div>
        <button name="search" type="submit" class="btn btn-primary mb-2">Search</button>
    </form>
  </div>
</div>
</div>
<?php }
//CONSULTA FLOR MATA
$sqlFM="SELECT mes,ano,producto,sum(produccion) as produccion,sum(exptble) as exptble,
sum(case when grado='j.NAL' then 0 else exptdo end) as exptdo, round(avg(ha_total),2) as ha_total,
round(SUM(produccion)/avg(ha_total)/10000,2) as FMT2_PROD,round(SUM(exptble)/avg(ha_total)/10000,2) as FMT2_EXPTBLE,
round(SUM(case when grado='j.NAL' then 0 else exptdo end)/avg(ha_total)/10000,2) as FMT2_EXPTDO,
round(SUM(produccion)/avg(plantas),2) as FMTA_PROD, round(SUM(exptble)/avg(plantas),2) as FMTA_EXPBLE,
round(SUM(case when grado='j.NAL' then 0 else exptdo end)/avg(plantas),2) as FMTA_EXPTDO from exportados $where group by 1,2,3 order by 1,3";

if (empty($_GET['inf'])){ ?>
    <div class="card card-body">
    <div class="row">
      <div class="col-sm-6">
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
      </div>
      <div class="col-sm-6">
      <canvas class="my-4 w-100" id="myChart2" width="900" height="380"></canvas>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
      <canvas class="my-4 w-100" id="myChart3" width="900" height="380"></canvas>
      </div>
    <div class="col-sm-6">
    <canvas class="my-4 w-100" id="myChart4" width="900" height="380"></canvas>
    </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
      <canvas class="my-4 w-100" id="myChart5" width="900" height="380"></canvas>
      </div>
    <div class="col-sm-6">
    <canvas class="my-4 w-100" id="myChart6" width="900" height="380"></canvas>
    </div>
    </div>
    </div>
  <?php }else if (($_GET['inf'])==1){ //si tiene el valor 1 traera el primer informe ?>
    <div class="row">
      <?php
      //hacer Query
      $res = $conexion->query($sqlFM);
      if ($res->num_rows>0) { ?>
            <table class="table table-bordered table-hover table-sm"> <!--div de tablas y tabla-->
        <!--Encabezado tabla-->
             <thead><tr>
               <th scope="col">mes</th><th scope="col">ano</th><th scope="col">producto</th><th scope="col">produccion</th><th scope="col">exptble</th>
               <th scope="col">exptdo</th><th scope="col">ha total</th><th scope="col">FMT2_PROD</th><th scope="col">FMT2_EXPTBLE</th><th scope="col">FMT2_EXPTDO</th>
               <th scope="col">FM_PROD</th><th scope="col">FM_EXPTBLE</th><th scope="col">FM_EXPTDO</th>
             </tr></thead>
        <?php
         while ($row=$res->fetch_object()) {
          echo "<tbody><tr>";
          echo "<td>" .$row->mes. "</td><td>" .$row->ano. "</td><td>" .$row->producto. "</td>";
          echo "<td>" .number_format($row->produccion,0,'','.'). "</td><td>" .number_format($row->exptble,0,'','.'). "</td>";
          echo "<td>" .number_format($row->exptdo,0,'','.'). "</td><td>" .$row->ha_total. "</td><td>" .$row->FMT2_PROD. "</td>";
          echo "<td>" .$row->FMT2_EXPTBLE. "</td><td>" .$row->FMT2_EXPTDO. "</td>";
          echo "<td>" .$row->FMTA_PROD. "</td><td>" .$row->FMTA_EXPBLE. "</td><td>" .$row->FMTA_EXPTDO. "</td>";
          echo "</tr>";
        }
      echo "</tbody></table></div>";
      }else{
        echo "Without results";
      }

  } else if (($_GET['inf'])==2){ //si tiene el valor 1 traera el primer informe

  }
 else if (($_GET['inf'])==3){ //si tiene el valor 1 traera el primer informe
$sqli3="SELECT producto,variedad,ano,
round((sel70cm/ttallos*100),2) as sel70cm,round((fan60cm/ttallos*100),2) as fan60cm,round((std50cm/ttallos*100),2) as std50cm,
round((shr40cm/ttallos*100),2) as shr40cm,round((nal/ttallos*100),2) as nal,
ttallos,exptble,bajas,fplanta,fplantamt2
FROM indicespro $where";

//hacer Query
$res = $conexion->query($sqli3);
if ($res->num_rows>0) { ?>

      <table class="table table-bordered table-hover table-sm"> <!--div de tablas y tabla-->
  <!--Encabezado tabla-->
       <thead><tr>
         <th scope="col">PRODUCTO</th><th scope="col">VARIEDAD</th><th scope="col">AÑO</th><th scope="col">SEL-70CM+ (%)</th><th scope="col">FAN-60CM (%)</th>
         <th scope="col">STD-50CM (%)</th><th scope="col">SHR-40CM (%)</th><th scope="col">NAL (%)</th><th scope="col">TOTAL</th><th scope="col">EXPORTABLE</th>
         <th scope="col">BAJAS</th><th scope="col">FPLANTA</th><th scope="col">FPLANTAMT2</th>
       </tr></thead>
  <?php
   while ($row=$res->fetch_object()) {
    echo "<tbody><tr>";
    echo "<td>" .$row->producto. "</td><td>" .$row->variedad. "</td><td>" .$row->ano. "</td>";
    echo "<td>" .$row->sel70cm. "</td><td>" .$row->fan60cm. "</td>";
    echo "<td>" .$row->std50cm. "</td><td>" .$row->shr40cm. "</td><td>" .$row->nal. "</td>";
    echo "<td>" .number_format($row->ttallos,0,'','.'). "</td><td>" .number_format($row->exptble,0,'','.'). "</td>";
    echo "<td>" .number_format($row->bajas,0,'','.'). "</td><td>" .number_format($row->fplanta,2,',','.'). "</td><td>" .number_format($row->fplantamt2,2,',','.'). "</td>";
    echo "</tr>";
  }
echo "</tbody></table></div>";
}else{
  echo "Without results";
  echo $sqli3;
}

 }
////////////////////////////////SQL PARA GRAFICOS/////////////////////////////
/*
$sqlpalermocla=SELECT producto,tipo,ano,SUM(CASE WHEN mes=1 then tallos else 0 end) as ene,SUM(CASE WHEN mes=2 then tallos else 0 end) as feb,
SUM(CASE WHEN mes=3 then tallos else 0 end) as mar,SUM(CASE WHEN mes=4 then tallos else 0 end) as abr,
SUM(CASE WHEN mes=5 then tallos else 0 end) as may,SUM(CASE WHEN mes=6 then tallos else 0 end) as jun,
SUM(CASE WHEN mes=7 then tallos else 0 end) as jul,SUM(CASE WHEN mes=8 then tallos else 0 end) as ago,
SUM(CASE WHEN mes=9 then tallos else 0 end) as sep,SUM(CASE WHEN mes=10 then tallos else 0 end) as oct,
SUM(CASE WHEN mes=11 then tallos else 0 end) as nov,SUM(CASE WHEN mes=12 then tallos else 0 end) as dic
FROM PRODUCCION WHERE producto='CLAVEL' AND finca='PALERMO' GROUP BY 1,2,3 */

////////////////////////////////////////////ultimo periodo////////////////////////////////////////////////////////////
$periodoactual=date("Y").date('m')-1;
$periodoanterior=(date("Y")-1).date('m')-1;

$pact=(int)$periodoactual;
$pant=(int)$periodoanterior;

///CONSULTA GRAFICO 1
$sqlpalermocla="SELECT finca,producto,aaaamm,sum(case WHEN tipo='PRESUPUESTO' THEN tallos ELSE 0 END) as 'presupuesto',
sum(case WHEN tipo='PROYECCION' THEN tallos ELSE 0 END) as 'proyeccion', sum(case WHEN tipo='REAL' THEN tallos ELSE 0 END) as 'real'
FROM PRODUCCION WHERE producto='CLAVEL' AND aaaamm<=$pact AND aaaamm>$pant AND finca='PALERMO' GROUP BY 1,2,3";
///CONSULTA GRAFICO 2
$sqlpalermomc="SELECT finca,producto,aaaamm,sum(case WHEN tipo='PRESUPUESTO' THEN tallos ELSE 0 END) as 'presupuesto',
sum(case WHEN tipo='PROYECCION' THEN tallos ELSE 0 END) as 'proyeccion', sum(case WHEN tipo='REAL' THEN tallos ELSE 0 END) as 'real'
FROM PRODUCCION WHERE producto='MINICLAVEL' AND aaaamm<=$pact AND aaaamm>$pant AND finca='PALERMO' GROUP BY 1,2,3";

///CONSULTA GRAFICO 3
$sqlpalmascla="SELECT finca,producto,aaaamm,sum(case WHEN tipo='PRESUPUESTO' THEN tallos ELSE 0 END) as 'presupuesto',
sum(case WHEN tipo='PROYECCION' THEN tallos ELSE 0 END) as 'proyeccion', sum(case WHEN tipo='REAL' THEN tallos ELSE 0 END) as 'real'
FROM PRODUCCION WHERE producto='CLAVEL' AND aaaamm<=$pact AND aaaamm>$pant AND finca='INVERPALMAS' GROUP BY 1,2,3";

///CONSULTA GRAFICO 4
$sqlpalmasmc="SELECT finca,producto,aaaamm,sum(case WHEN tipo='PRESUPUESTO' THEN tallos ELSE 0 END) as 'presupuesto',
sum(case WHEN tipo='PROYECCION' THEN tallos ELSE 0 END) as 'proyeccion', sum(case WHEN tipo='REAL' THEN tallos ELSE 0 END) as 'real'
FROM PRODUCCION WHERE producto='MINICLAVEL' AND aaaamm<=$pact AND aaaamm>$pant AND finca='INVERPALMAS' GROUP BY 1,2,3";

///CONSULTA GRAFICO 5
$sqlpalmasros="SELECT finca,producto,aaaamm,sum(case WHEN tipo='PRESUPUESTO' THEN tallos ELSE 0 END) as 'presupuesto',
sum(case WHEN tipo='PROYECCION' THEN tallos ELSE 0 END) as 'proyeccion', sum(case WHEN tipo='REAL' THEN tallos ELSE 0 END) as 'real'
FROM PRODUCCION WHERE producto='ROSAS ROJAS' AND aaaamm<=$pact AND aaaamm>$pant AND finca='INVERPALMAS' GROUP BY 1,2,3";

///CONSULTA GRAFICO 6
$sqlpalmasroc="SELECT finca,producto,aaaamm,sum(case WHEN tipo='PRESUPUESTO' THEN tallos ELSE 0 END) as 'presupuesto',
sum(case WHEN tipo='PROYECCION' THEN tallos ELSE 0 END) as 'proyeccion', sum(case WHEN tipo='REAL' THEN tallos ELSE 0 END) as 'real'
FROM PRODUCCION WHERE producto='ROSAS COLORES' AND aaaamm<=$pact AND aaaamm>$pant AND finca='INVERPALMAS' GROUP BY 1,2,3";

?>
<!--A continuacion JavaScript el grafico 1------------------------------------------------->
<script>
var ctx = document.getElementById('myChart')
// eslint-disable-next-line no-unused-vars
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:
    [
      <?php
      //labels para el grafico
      $res = $conexion->query($sqlpalermocla);
      while($f = $res->fetch_object()){
        ?>
          '<?php echo $f->aaaamm; ?>',
        <?php
        }
       ?>
    ],
    datasets: [{
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalermocla);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->presupuesto; ?>',
          <?php
          }
         ?>
      ],
      label: 'Presupuesto',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#33FFE5',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalermocla);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->proyeccion; ?>',
          <?php
          }
         ?>
      ],
      label: 'Proyeccion',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#007bff',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalermocla);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->real; ?>',
          <?php
          }
         ?>
      ],
      label: 'Real',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#4DFF33 ',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    title: {
          display: true,
          text: 'Clavel Presupuesto vs Proyeccion Vs Real Palermo Año Corrido'
        },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: true
    }
  }
})
</script>

<!--A continuacion JavaScript el grafico 2------------------------------------------------->
<script>
var ctx = document.getElementById('myChart2')
// eslint-disable-next-line no-unused-vars
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:
    [
      <?php
      //labels para el grafico
      $res = $conexion->query($sqlpalermomc);
      while($f = $res->fetch_object()){
        ?>
          '<?php echo $f->aaaamm; ?>',
        <?php
        }
       ?>
    ],
    datasets: [{
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalermomc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->presupuesto; ?>',
          <?php
          }
         ?>
      ],
      label: 'Presupuesto',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#33FFE5',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalermomc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->proyeccion; ?>',
          <?php
          }
         ?>
      ],
      label: 'Proyeccion',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#007bff',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalermomc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->real; ?>',
          <?php
          }
         ?>
      ],
      label: 'Real',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#4DFF33 ',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    title: {
          display: true,
          text: 'Miniclavel Presupuesto vs Proyeccion Vs Real Palermo Año Corrido'
        },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: true
    }
  }
})
</script>

<!--A continuacion JavaScript el grafico 3------------------------------------------------->
<script>
var ctx = document.getElementById('myChart3')
// eslint-disable-next-line no-unused-vars
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:
    [
      <?php
      //labels para el grafico
      $res = $conexion->query($sqlpalmascla);
      while($f = $res->fetch_object()){
        ?>
          '<?php echo $f->aaaamm; ?>',
        <?php
        }
       ?>
    ],
    datasets: [{
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmascla);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->presupuesto; ?>',
          <?php
          }
         ?>
      ],
      label: 'Presupuesto',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#33FFE5',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmascla);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->proyeccion; ?>',
          <?php
          }
         ?>
      ],
      label: 'Proyeccion',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#007bff',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmascla);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->real; ?>',
          <?php
          }
         ?>
      ],
      label: 'Real',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#4DFF33 ',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    title: {
          display: true,
          text: 'Clavel Presupuesto vs Proyeccion Vs Real Palmas Año Corrido'
        },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: true
    }
  }
})
</script>

<!--A continuacion JavaScript el grafico 4------------------------------------------------->
<script>
var ctx = document.getElementById('myChart4')
// eslint-disable-next-line no-unused-vars
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:
    [
      <?php
      //labels para el grafico
      $res = $conexion->query($sqlpalmasmc);
      while($f = $res->fetch_object()){
        ?>
          '<?php echo $f->aaaamm; ?>',
        <?php
        }
       ?>
    ],
    datasets: [{
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasmc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->presupuesto; ?>',
          <?php
          }
         ?>
      ],
      label: 'Presupuesto',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#33FFE5',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasmc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->proyeccion; ?>',
          <?php
          }
         ?>
      ],
      label: 'Proyeccion',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#007bff',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasmc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->real; ?>',
          <?php
          }
         ?>
      ],
      label: 'Real',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#4DFF33 ',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    title: {
          display: true,
          text: 'Miniclavel Presupuesto vs Proyeccion Vs Real Palmas Año Corrido'
        },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: true
    }
  }
})
</script>

<!--A continuacion JavaScript el grafico 5------------------------------------------------->
<script>
var ctx = document.getElementById('myChart5')
// eslint-disable-next-line no-unused-vars
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:
    [
      <?php
      //labels para el grafico
      $res = $conexion->query($sqlpalmasroc);
      while($f = $res->fetch_object()){
        ?>
          '<?php echo $f->aaaamm; ?>',
        <?php
        }
       ?>
    ],
    datasets: [{
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasroc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->presupuesto; ?>',
          <?php
          }
         ?>
      ],
      label: 'Presupuesto',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#33FFE5',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasroc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->proyeccion; ?>',
          <?php
          }
         ?>
      ],
      label: 'Proyeccion',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#007bff',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasroc);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->real; ?>',
          <?php
          }
         ?>
      ],
      label: 'Real',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#4DFF33 ',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    title: {
          display: true,
          text: 'Rosas Rojas Presupuesto vs Proyeccion Vs Real Año Corrido'
        },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: true
    }
  }
})
</script>

<!--A continuacion JavaScript el grafico 6------------------------------------------------->
<script>
var ctx = document.getElementById('myChart6')
// eslint-disable-next-line no-unused-vars
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels:
    [
      <?php
      //labels para el grafico
      $res = $conexion->query($sqlpalmasros);
      while($f = $res->fetch_object()){
        ?>
          '<?php echo $f->aaaamm; ?>',
        <?php
        }
       ?>
    ],
    datasets: [{
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasros);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->presupuesto; ?>',
          <?php
          }
         ?>
      ],
      label: 'Presupuesto',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#33FFE5',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasros);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->proyeccion; ?>',
          <?php
          }
         ?>
      ],
      label: 'Proyeccion',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#007bff',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    },
    {
      data: [
        <?php
        //labels para el grafico
        $res = $conexion->query($sqlpalmasros);
        while($f = $res->fetch_object()){
          ?>
            '<?php echo $f->real; ?>',
          <?php
          }
         ?>
      ],
      label: 'Real',
      lineTension: 0,
      backgroundColor: 'transparent',
      borderColor: '#4DFF33 ',
      borderWidth: 4,
      pointBackgroundColor: '#007bff'
    }]
  },
  options: {
    title: {
          display: true,
          text: 'Rosas colores Presupuesto vs Proyeccion Vs Real Año Corrido'
        },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: false
        }
      }]
    },
    legend: {
      display: true
    }
  }
})
</script>
