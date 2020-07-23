<!DOCTYPE html>
<html lang="es">
	<head>
	<title>Inverpalmas</title>
    <!-- Required meta tags -->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->

	<link href="vendor\twbs\bootstrap\dist\css\bootstrap.min.css" rel="stylesheet">
	<link href="vendor\twbs\bootstrap\dist\css\print.css" rel="stylesheet">
	<link href="scripts\myStyles.css" rel="stylesheet" media="screen" type="text/css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
	<script src="bootstrap\dist\js\JsBarcode.all.min.js"></script>
	<script>
	$(document).ready(function(){
	  $("#myInput").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#myTable tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	  });
	});
	</script>
	<script>
	$(document).ready(function(){
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#myDIV *").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	});
	</script>
	<script>
	$(document).ready(function(){
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#myList li").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	});

	function fetch_select(val)
	{
	$.ajax({
		type: 'post',
		url: 'CRUD/fetchData.php',
		data: {
		get_option:val
		},
		success: function (response) {
		document.getElementById("revision").innerHTML=response; 
		}
	});
	}
</script>
<script type="text/javascript">
var pepe;
function ini() {
  pepe = setTimeout('location="http://172.10.18.133/info/logout.php"',915000); // 5 segundos
  }
function parar() {
  clearTimeout(pepe);
  pepe = setTimeout('location="http://172.10.18.133/info/logout.php"',915000); // 5 segundos
}
</script>
</head>
<body onload="ini()" onkeypress="parar()" onclick="parar()">
	<style>      
	  @media screen
		{
			body 
			{
				padding-top: 5rem;
			}
		}
	</style>
<header>
	<?php
		require_once('header.php');
	?>
</header>
<section>
	<div class="container-fluid">
	<?php
			// carga el archivo routing.php para direccionar a la página .php que se incrustará entre la header y el footer
			require_once('routing.php');
	 ?>
	</div>
</section>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="vendor\twbs\bootstrap\dist\js\bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Custom JS file --> 
<script type="text/javascript" src="scripts/script.js"></script>
<!---footer-->
<footer>
	<?php
		include_once('footer.php');
	?>
</footer>
</body>
</html>
