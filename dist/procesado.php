<?php

include ('funciones/conexion.php');
//combos para buscar
//variables filtrar datos
$where="";
//ano
$year=date('Y');

if(empty($_POST['xfinca'])){
  $finca="";
}else{
  $finca=$_POST['xfinca'];
}
if(empty($_POST['xfuente'])){
  $fuente="";
}else{
  $fuente=$_POST['xfuente'];
}
if (empty($_POST['xproducto'])){
  $producto="";
}else{
  $producto=$_POST['xproducto'];
}

//boton buscar
if(isset($_POST['buscar'])){
  if (!Empty($_POST['xfinca']) and Empty($_POST['xproducto']) and Empty($_POST['xfuente'])){
    $where=" WHERE finca='".$finca."' ";
  }
  else if (Empty($_POST['xfinca']) and !Empty($_POST['xproducto']) and Empty($_POST['xfuente'])){
    $where=" WHERE producto='".$producto."' ";
  }
  else if (Empty($_POST['xfinca']) and Empty($_POST['xproducto']) and !Empty($_POST['xfuente'])){
    $where=" WHERE fuente='".$fuente."' ";
  }
  else{
    $where="";
  }
}

/////////////////////consultas///////////////////////
$cons="SELECT mes,semana,producto,finca,fuente,SUM(CASE WHEN ano=($year-1)THEN tallos ELSE 0 END) AS 'anoanterior',SUM(CASE WHEN ano=$year THEN tallos ELSE 0 END) AS 'anoactual' FROM procesados $where GROUP BY 1,2,3,4,5";
$res = $conexion->query($cons);
    //consulta producto
    $p="SELECT producto FROM procesados WHERE producto<>'' GROUP BY producto";
    $resp=$conexion->query($p);
    //consulta documento
    $f="SELECT finca FROM procesados GROUP BY finca";
    $resf=$conexion->query($f);
    //consulta causa
    $fu="SELECT fuente FROM procesados GROUP BY fuente";
    $resfu=$conexion->query($fu);
?>
<!--pintar card-->
<div class="row">
  <div class="col-11">
  <div class="card card-header">
    <form class="form-inline" action="home.php?menu=pp" method="post">
      <div class="form-group mx-sm-3 mb-2">
        <select name="xfinca" class="form-control" data-live-search="true">
          <option value="">Finca</option>
          <?php
          while($rfi = $resf->fetch_object()){
            if ($rfi->finca == $finca) {
              echo "<option value='".$rfi->finca."' selected='selected'>" .$rfi->finca. "</option>";
            }else {
              echo "<option value='".$rfi->finca."'>" .$rfi->finca. "</option>";
            }
          }
           ?>
           </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
           <select name="xproducto" class="form-control" data-live-search="true">
             <option value="">Producto</option>
             <?php
             while($rp = $resp->fetch_object()){
               if($rp->producto==$producto){
               echo "<option value='".$rp->producto."' selected='selected'>" .$rp->producto. "</option>";
               }else{
               echo "<option value='".$rp->producto."'>" .$rp->producto. "</option>";
             }
             }
              ?>
            </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <select name="xfuente" class="form-control" data-live-search="true">
              <option value="">Fuente</option>
              <?php
              while($rfu = $resfu->fetch_object()){
                if($rfu->fuente==$fuente){
                echo "<option value='".$rfu->fuente."' selected='selected'>" .$rfu->fuente. "</option>";
                }else{
                echo "<option value='".$rfu->fuente."'>" .$rfu->fuente. "</option>";
              }
              }
               ?>
              </select>
        </div>
              <button name="buscar" type="submit" class="btn btn-primary mb-2">Buscar</button>
   </form>
 </div></div>
 <div class="col-1">

       <div class="dropdown dropleft float-right"><br>
         <button type="button" class="btn btn-primary dropdown-toggle " data-toggle="dropdown">
           Reports
         </button>
         <div class="dropdown-menu">
           <a class="dropdown-item" href="index.php?menu=pp&inf=1">Analisis Produccion</a>
           <a class="dropdown-item" href="index.php?menu=pp&inf=2">Calidades y procesados</a>
           <a class="dropdown-item" href="index.php?menu=pp&inf=3">Link 3</a>
         </div>
       </div>

  </div>
</div>
<!--pintar tabla-->
      <div class="table table-bordered">
        <table class="table">
        <thead>
          <tr><th>mes</th><th>producto</th><th>finca</th><th>fuente</th><th>2018</th><th>2019</th></tr>
        </thead>
        <tbody>
<?php
if ($res->num_rows>0){
        while($f = $res->fetch_object()){
          echo "<tr><td>". $f->mes. "</td><td>" . $f->producto. "</td><td>" .$f->finca."</td><td>" .$f->fuente."</td><td>" .number_format($f->year2018,0,'',',')."</td><td>" .$f->year2019."</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
      echo "</div>";
    }
    else {
        echo "0 results";
    }

        $conexion->close();

?>
