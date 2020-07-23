<?php
//lamar conexion
include ('funciones/conexion.php');
//funciones personalizadas
include ('funciones/funciones.php');
//carbon
require "vendor/autoload.php";
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mpdf\Mpdf;

//verificar los roles	


if (isset($_GET['table'])){

if ($_GET['table']==1)
{
	$dir="tables/plane.php";//directorio a buscar
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";//consulta
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)//si tiene permisos...
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==2)
{
	$dir="tables/varieties.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==3)
{
	$dir="tables/program.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==4)
{
	$dir="tables/seasons.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==5)
{
	$dir="tables/fusarium.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==6)
{
	$dir="tables/arrangements.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==7)
{
	$dir="tables/companys.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==8)
{
	$dir="tables/farms.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==9)
{
	$dir="tables/products.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==10)
{
	$dir="tables/addxvariety.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==11)
{
	$dir="tables/areas.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==12)
{
	$dir="tables/programf.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==13)
{
	$dir="tables/hplane.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==14)
{
	$dir="tables/viewReportsP.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']==15)
{
//disponible
}
else if ($_GET['table']==16)
{
	$dir="tables/laborsSowing.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadQualities')
{
	$dir="tables/qualities.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadNalcauses')
{
	$dir="tables/nalCauses.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadEvaluations')
{
	$dir="tables/evaluations.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadComments')
{
	$dir="tables/comments.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadCurves')
{
	$dir="tables/curves.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadFeatures')
{
	$dir="tables/features.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadEmployees')
{
	$dir="tables/employees.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else if ($_GET['table']=='loadSupervisors')
{
	$dir="tables/supervisors.php";	
	$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
			AND dir='".$dir."' ";
	$resQ=$conexion->query($query);
	if ($resQ->num_rows>0)
	{
		include "$dir";
	}else{
		echo "<h1>No tiene permisos</h1>";
	}
}
else{
	echo "Tables";
}
}

//reportes////////////////////////////////////////////////////////////////////////
if (isset($_GET['report']))
{
	if ($_GET['report']==1)
	{
		$dir="views/formBautizo.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==2)
	{
		$dir="views/applications.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==3)
	{
		$dir="views/addvarietys.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==4)
	{
		$dir="views/program.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==5)
	{
		$dir="views/programView.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
		
	else if ($_GET['report']==6)
	{
		$dir="views/print.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==7)
	{
		$dir="views/growroot.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==8)
	{
		$dir="views/growplanting.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==9)
	{
		$dir="scripts/compare.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==50)
	{
		$dir="views/fusarium.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==51)
	{
		$dir="views/agronomist.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==52)
	{
		$dir="views/showcase.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==100)
	{
		$dir="views/management.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==101)
	{
		$dir="views/modal.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==1000)
	{
		$dir="covid/covid.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==1001)
	{
		$dir="covid/settings.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
	else if ($_GET['report']==1002)
	{
		$dir="covid/report.php";	
		$query="SELECT dir FROM roles WHERE users_role=".$_SESSION['role']." 
				AND dir='".$dir."' ";
		$resQ=$conexion->query($query);
		if ($resQ->num_rows>0)
		{
			include "$dir";
		}else{
			echo "<h1>No tiene permisos</h1>";
		}
	}
}
?>
