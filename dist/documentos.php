<?php

include ('funciones/conexion.php');
//variables filtrar datos
$where="";
if(empty($_POST['xproducto'])){
  $producto="";
}else{
  $producto=$_POST['xproducto'];
}
if(empty($_POST['xdocumento'])){
  $documento="";
}else{
  $documento=$_POST['xdocumento'];
}
if (empty($_POST['xcausa'])){
  $causa="";
}else{
  $causa=$_POST['xcausa'];
}

//boton buscar
if(isset($_POST['buscar'])){
  if (!Empty($_POST['xproducto']) and Empty($_POST['xdocumento']) and Empty($_POST['xcausa'])){
    $where=" WHERE producto='".$producto."' ";
  }
  else if (Empty($_POST['xproducto']) and !Empty($_POST['xdocumento']) and Empty($_POST['xcausa'])){
    $where=" WHERE documento='".$documento."' ";
  }
  else if (Empty($_POST['xproducto']) and Empty($_POST['xdocumento']) and !Empty($_POST['xcausa'])){
    $where=" WHERE causa='".$causa."' ";
  }
  else if (Empty($_POST['xproducto']) and !Empty($_POST['xdocumento']) and !Empty($_POST['xcausa'])){
    $where=" WHERE causa='".$causa."' and documento='".$documento."' ";
  }
  else if (!Empty($_POST['xproducto']) and !Empty($_POST['xdocumento']) and Empty($_POST['xcausa'])){
    $where=" WHERE producto='".$producto."' and documento='".$documento."' ";
  }
  else if (!Empty($_POST['xproducto']) and Empty($_POST['xdocumento']) and !Empty($_POST['xcausa'])){
    $where=" WHERE producto='".$producto."' and causa='".$causa."' ";
  }
  else if (!Empty($_POST['xproducto']) and !Empty($_POST['xdocumento']) and !Empty($_POST['xcausa'])){
    $where=" WHERE causa='".$causa."' and documento='".$documento."' and producto='".$producto."' ";
  }
  else{
    $where="";
  }
}
//variables de consulta combos
    $cons="SELECT mes,producto,documento,causa,sum(CASE WHEN ano=2018 THEN tallos ELSE 0 END) as year2018,sum(CASE WHEN ano=2019 THEN tallos ELSE 0 END) as year2019 FROM documentos $where GROUP BY mes,producto,documento,causa";
    $res = $conexion->query($cons);
    //consulta producto
    $p="SELECT DISTINCT producto FROM documentos";
    $resp=$conexion->query($p);
    //consulta documento
    $d="SELECT DISTINCT documento FROM documentos";
    $resd=$conexion->query($d);
    //consulta causa
    $c="SELECT DISTINCT causa FROM documentos where causa<>''";
    $resc=$conexion->query($c);
?>
<!--formulario de fi-->
<div class="card">
  <div class="card-header">
    <form class="form-inline" action="home.php?menu=doc" method="post" enctype="multipart/form-data">
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
           <select name="xdocumento" class="form-control" data-live-search="true">
             <option value="">Documento</option>
             <?php
             while($rd = $resd->fetch_object()){
               if($rd->documento==$documento){
                echo "<option value='".$rd->documento."' selected='selected'>" .$rd->documento. "</option>";
               }else{
                echo "<option value='".$rd->documento."'>" .$rd->documento. "</option>";
               }
             }
              ?>
            </select>
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <select name="xcausa" class="form-control" data-live-search="true">
              <option value="">Causa</option>
              <?php
              while($rc = $resc->fetch_object()){
                if($rc->causa==$causa){
                  echo "<option value='".$rc->causa."' selected='selected'>" .$rc->causa. "</option>";
                }else{
                  echo "<option value='".$rc->causa."'>" .$rc->causa. "</option>";
                }
              }
              ?>
              </select>

        </div>
        <div class="form-group mx-sm-3 mb-2">
              <button name="buscar" type="submit" class="btn btn-primary mb-2">Buscar</button>
        </div>
   </form>
  </div>
</div>
<!--fIN DE FORM FILTROS---------------------------------------------------------------------->
      <?php
     if ($res->num_rows>0){
       ?>
      <div class="table-bordered">
        <table class="table">
          <tr><th>mes</th><th>producto</th><th>documento</th><th>causa</th><th>2018</th><th>2019</th></tr>
<?php
        while($f = $res->fetch_object()){
          echo "<tr><td>" .$f->mes. "</td><td>" .$f->producto. "</td><td>" .$f->documento. "</td><td>" .$f->causa. "</td>
          <td>" .number_format($f->year2018,0,'','.'). "</td><td>" .number_format($f->year2019,0,'','.'). "</td></tr>";
        }
        echo "</table>";
      echo "</div>";
    }
    else {
        echo "0 results";
    }

        $conexion->close();

?>
