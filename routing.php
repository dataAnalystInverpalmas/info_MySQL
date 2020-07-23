<?php
//traer conexion
require("funciones/conexion.php");

	if (empty($_GET['menu']) & empty($_SESSION['usuario'])){
		?>
		<br>
			<div class="row justify-content-sm-center">
				<div class="col-sm-6 col-md-5 flex-column">
					<h1 class="text-center">Admin Panel</h1>
					<h2 class="text-center">Iniciar Sesión</h2>
					<div>
						<form action="login.php" method="post" name="login">
						<input type="text" class="form-control" placeholder="Username" name="email" required autofocus><br>
						<input type="password" class="form-control" placeholder="Password" name="password" required><br>
						<button class="btn btn-lg btn-primary btn-block" type="submit" name="login">
							Ingresar</button>
						</form>
					</div>
					<br>
				</div>
				<div class="col-sm-6 col-md-5 flex-column">
					<div class="text-center">
						<img src="img/Inverpalmas.png" class="rounded mx-auto img-fluid d-block" alt="...">
					</div>
				</div>
			</div>

		<?php
	} else {
		
		if (empty($_GET['menu'])) {
			echo "<h1>Bienvenido ".$_SESSION['usuario']." </h1";
		}
		else {
			require_once('dist/tables.php');
		}
		
}
 ?>
