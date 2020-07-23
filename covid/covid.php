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

  if (empty($_SESSION['nturno']))
  {
  ?>  
    <div class="alert alert-danger"> Vaya a configuración y seleccione un turno... </div> 
  <?php
  }
  else
  {
  ?> 
  <div class="alert alert-success">
     Registro de: <?php echo $_SESSION['nturno']; ?>  
  </div>  

<div class="row">
  <div class="col-sm-12">
    <form id="formCovid" name="formCovid" method='POST'>
        <div class="form-group row">
          <label for="codigo" class="col-sm-2 col-form-label">Codigo</label>
          <div class="col-sm-10">
            <input type="number" step="any" class="form-control" id="codigo" name="codigo" autofocus="autofocus" />
          </div>
        </div>
        <div class="form-group row">
          <label for="temperatura" class="col-sm-2 col-form-label">Temperatura</label>
          <div class="col-sm-10">
            <input type="number" step="any" name="c0" class="form-control" id="temperatura" required>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2">
            <a style='cursor: pointer;' onClick="muestra_oculta('contenido')" title="" class="boton_mostrar">Sintomatologia</a>
          </div>
          <div id="contenido">
          <div class="col-sm-10">
            <div class="form-check">
              <input name="c1" id="pregunta1" class="form-check-input get_value" type="checkbox"  value="1">
              <label class="form-check-label" for="pregunta1">
                Tos Seca
              </label>
            </div>
           <div class="form-check">
              <input name="c2" id="pregunta2" class="form-check-input get_value" type="checkbox"  value="1">
              <label class="form-check-label" for="pregunta2">
                Dolor de Cabeza
              </label>
            </div>
            <div class="form-check">
              <input name="c3" id="pregunta3" class="form-check-input get_value" type="checkbox"  value="1">
              <label class="form-check-label" for="pregunta3">
                Malestar General
              </label>
            </div>
            <div class="form-check">
              <input name="c4" id="pregunta4" class="form-check-input get_value" type="checkbox" value="1">
              <label class="form-check-label" for="pregunta4">
                Congestión Nasal
              </label>
            </div>
            <div class="form-check">
              <input name="c5" id="pregunta5" class="form-check-input get_value" type="checkbox" value="1">
              <label class="form-check-label" for="pregunta5">
                Familiar con Sintomas
              </label>
            </div>
            </div>
          </div> 
      </div>
      <div class="form-group row">
        <div class="col-sm-12">
          <input type="submit" class="btn btn-primary" name="sendForm" value="Enviar"/>
        </div>
      </div>
    </form>
  </div>
</div>

<?php  } //cierra la seccion del formulario  ?>

<?php
if (isset($_POST['sendForm']))
{
  $codigo = $_POST['codigo'];
  $turno= $_SESSION['turno'];

  $q="SELECT codigo FROM employees WHERE codigo='".$codigo."' ";
  $r=$conexion->query($q);
  if($r->num_rows > 0) 
  {

//verificar si codigo existe en la base de datos

////////////////////////////////////////////////

    for($i=0;$i<=5;$i++)
    {
      if($i===0)
      {
        $valor=$_POST['c0'];
      }
      elseif(isset($_POST['c'.$i]) && $_POST['c'.$i] == '1')
      {
        $valor=1;
      }
      else
      {
        $valor=0;
      }

      //guardar datos
      $query = "INSERT INTO  datacovid (codigo,turno,pregunta,valor)
                VALUES ('$codigo',$turno,$i,$valor)";
      $result = $conexion->query($query); 
    }
  }
  else
  {
    ?>
    <script>
      alert("El codigo no existe...");
    </script>
    <?php
  }  
  //js para hacer autofocus
  $conexion-> close();

}

?>
<script>
  function muestra_oculta(id){
  if (document.getElementById){ //se obtiene el id
  var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
  el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
  }
  }
  window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
  muestra_oculta('contenido');/* "contenido_a_mostrar" es el nombre que le dimos al DIV */
  }
</script>
