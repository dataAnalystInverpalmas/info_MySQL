<?php
//lamar conexion
if (is_file("funciones/conexion.php")){
	include ("funciones/conexion.php");
	}
	else {
	include ("../funciones/conexion.php");
	}
require "vendor/autoload.php";

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;
?>

<!-- Begin page content -->

<div class="container-fluid">
  <h3 class="mt-5">Información para Informes Mensuales</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
<!-- Content Section --> 
<!-- crud jquery-->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="pull-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#add_new_record_modal">Agregar Información</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <br>
      <div id="records_content"></div>
    </div>
  </div>
</div>
<!-- /Content Section --> 

<!-- Bootstrap Modals --> 
<!-- Modal - Add New Record/User -->
<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="container-fluid modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agregar Datos</h4>
      </div>

      <div class="modal-body">
        <div class="form-group">
          <label for="fecha">Fecha</label>
          <input type="date" id="fecha" value=""   class="form-control"/>
        </div>
        <div class="form-group">
          <select id="finca" class="form-control">
            <option>Finca</option>
            <?php
            $select=$conexion->query("select nombre from farms group by nombre");
            while($row=mysqli_fetch_array($select))
            {
            echo "<option>".$row['nombre']."</option>";
            }
          ?>
          </select>
        </div>
        <div class="form-group">
        <select id="producto" class="form-control">
            <option>Producto</option>
            <?php
            $select=$conexion->query("select nombre from products group by nombre");
            while($row=mysqli_fetch_array($select))
            {
            echo "<option>".$row['nombre']."</option>";
            }
          ?>
          </select>
        </div>
        <div class="form-group">
          <select name="" id="tipo" class="form-control">
            <option>Tipo</option>
            <option>Real</option>
            <option>Teorico</option>
          </select>
        </div>
        <div class="form-group">
          <select id="indicador" class="form-control" onchange="fetch_select(this.value);">
            <option>Indicador</option>
            <?php
            $select=$conexion->query("select tipo from indicators group by tipo");
            while($row=mysqli_fetch_array($select))
            {
            echo "<option>".$row['tipo']."</option>";
            }
          ?>
          </select>
        </div>
        
        <div class="form-group">
          <div id="select_box">
          <select type="text" id="revision" class="form-control" value=""></select>
          </div>
        </div>
      <div class="form-group">
          <label for="valor">Valor</label>
          <input type="text" id="valor" class="form-control" value=""/>
        </div>
      
      </div> 
        
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="addRecord()">Agregar</button>
      </div>

      </div>
    </div>
  </div>
<!-- // Modal --> 
<!-- Modal - Update User details -->
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
   
      <div class="modal-header">
        <h5 class="modal-title">Actualizar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> 
      
      <div class="modal-body">

        <div class="form-group">
          <label for="fecha">Fecha</label>
          <input type="text" id="update_fecha" value=""   class="form-control"/>
        </div>
        <div class="form-group">
          <label for="finca">Finca</label>
          <input type="text" id="update_finca" class="form-control" value=""/>
        </div>   
        <div class="form-group">
          <label for="producto">Producto</label>
          <input type="text" id="update_producto" class="form-control" value=""/>
        </div>
        <div class="form-group">
          <label for="tipo">Tipo</label>
          <input type="text" id="update_tipo" class="form-control" value=""/>
        </div>
        <div class="form-group">
          <label for="indicador">Indicador</label>
          <input type="text" id="update_indicador" class="form-control" value=""/>
        </div>
        <div class="form-group">
          <label for="revision">Revision</label>
          <input type="text" id="update_revision" class="form-control" value=""/>
        </div>
      <div class="form-group">
          <label for="valor">Valor</label>
          <input type="text" id="update_valor" class="form-control" value=""/>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="UpdateUserDetails()" >Guardar Cambios</button>
        <input type="hidden" id="hidden_user_id">
      </div>
      
    </div>
  </div>
</div>
<!-- // Modal --> 
      <!-- Fin Contenido --> 
      </div>
  </div>
  <!-- Fin row --> 
  
</div>
