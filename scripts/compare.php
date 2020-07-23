<?php
//lamar conexion
include ('funciones/conexion.php');
require "vendor/autoload.php";
?>

<h2>Validar ajustes ingreso a poscosecha vs cultivo</h2>

<div class="form-group">
<p>Tallos enviados de cultivo:</p>
<input id="cultivo" type="number" autofocus>
</div><div class="form-group">
<p>Inventario inicial cultivo:</p>
<input id="icultivo" type="number">
</div><div class="form-group">
<p>Inventario final cultivo:</p>
<input id="fcultivo" type="number">
</div><div class="form-group">
<p>Tallos poscosecha:</p>
<input id="poscosecha" type="number">
</div><div class="form-group">
<p>Tallos por unidad de medida (lonas,mallas):</p>
<input id="medida" type="number">
</div>

<button class="btn btn-primary" type="button" onclick="myFunction()">Calcular</button>
<button class="btn btn-success" type="button" onclick="limpiarFormulario()">Limpiar</button>
<div class="form-group"><br>
<h4><p id="demo"></p><h4>
</div>
<script>
function myFunction() {
  var resultado=0;
  var ajuste_menor=0.951;
  var ajuste_mayor=1.009;
  var msg='';
  // Get the value of the input field with id="numb"
  var cultivo = parseInt(document.getElementById("cultivo").value);
  var poscosecha = parseInt(document.getElementById("poscosecha").value);
  var medida = parseInt(document.getElementById("medida").value);
  var inv_inicial = parseInt(document.getElementById("icultivo").value);
  var inv_final = parseInt(document.getElementById("fcultivo").value);

  //inventairos///////////////////////////////////
  if (inv_inicial=="") {
    var inv_inicial=0;
  }
  if (inv_final=="") {
    var inv_final=0;
  }

  //formula///////////////////////
  var formula = parseFloat((cultivo + inv_final - inv_inicial) / poscosecha);
  ////////////////proceso/////////////////////////
  if (formula < 0.95 && (formula / poscosecha) < 1.01) 
  {
    resultado = formula;
    msg = "Todo está bien, no realice ajustes" + resultado;
  } else if (formula < 0.95) 
  {
    resultado = Math.round(formula / medida,2);
    msg = "Ajuste aumentando: " + resultado;
  } else if (formula > 1.009) 
  {
    resultado = Math.round(formula / medida,2);
    msg = "Ajuste reduciendo: " + resultado;
  } else 
  {
    // If x is Not a Number or less than one or greater than 10
    msg = "Error comprabar valores ingresados...";
  }
  //imprimir resultado////////////////////////////
  document.getElementById("demo").innerHTML = msg;
}

function limpiarFormulario() 
{
  msg = "";
  document.getElementById("cultivo").value=0;
  document.getElementById("poscosecha").value=0;
  document.getElementById("medida").value=0;
  document.getElementById("icultivo").value=0;
  document.getElementById("fcultivo").value=0;
}
</script>
