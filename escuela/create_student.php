<?php require("includes/session.php"); ?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(intval($_GET['curso']) == 0)
	{
		header("Location: content.php");
		exit;
	}
	$errores = validarCamposObligatorios(array("nombre", "apellido", "direccion"));
	
	if(!empty($errores))
	{
		header("Location: new_student.php?curso=" . $_GET["curso"]);
		exit;
	}
?>
<?php
	$curso_id = $_GET["curso"];
	$nombre = $_POST["nombre"];
	$apellido = $_POST["apellido"];
	$direccion = $_POST["direccion"];
	
	$consulta = "INSERT INTO alumnos (
								nombre, apellido, direccion, curso_id
								) VALUES (
								'{$nombre}', '{$apellido}', '{$direccion}', {$curso_id}
								)";
								
	if(mysql_query($consulta, $conexion))
	{
		header("Location: content.php");
		exit;
	}
	else
	{
		echo "No se ha podido crear el alumno: " . mysql_error();
	}
?>
<?php
	mysql_close($conexion);
?>
