<?php require("includes/session.php"); ?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>

<?php
	if(intval($_GET["alumno"]) == 0)
	{
		header("Location: content.php");
		exit;
	}
	
	$consulta = "DELETE FROM alumnos 
								WHERE id = " . $_GET["alumno"];
								
	mysql_query($consulta, $conexion);
	if(mysql_affected_rows() == 1)
	{
		header("Location: content.php");
		exit;
	}
	else
	{
		echo "<p>Se ha producido un error al intentar eliminar un alumno: " . 
			mysql_error() . "</p><a href='content.php'>Regresar a la página principal</a>";
	}
?>

<?php
	if(isset($conexion))
	{
		mysql_close($conexion);
	}
?>
