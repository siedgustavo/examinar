<?php require("includes/session.php"); ?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

	$errores = validarCamposObligatorios(array("descripcion", "posicion", "visibilidad"));
	
	if(!empty($errores))
	{
		header("Location: new_course.php");
		exit;
	}
?>
<?php
	$descripcion = $_POST["descripcion"];
	$posicion = $_POST["posicion"];
	$visibilidad = $_POST["visibilidad"];
	
	$consulta = "INSERT INTO cursos (
								descripcion, posicion, visibilidad
								) VALUES (
								'{$descripcion}', {$posicion}, {$visibilidad}
								)";
								
	if(mysql_query($consulta, $conexion))
	{
		header("Location: content.php");
		exit;
	}
	else
	{
		echo "No se ha podido crear el curso: " . mysql_error();
	}
?>
<?php
	mysql_close($conexion);
?>
