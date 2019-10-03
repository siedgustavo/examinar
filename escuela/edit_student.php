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
	
	if(isset($_POST["nombre"]))
	{
		$errores = validarCamposObligatorios(array("nombre", "apellido", "direccion"));
		
		if(empty($errores))
		{
			$alumno_id = $_GET["alumno"];
			$nombre = $_POST["nombre"];
			$apellido = $_POST["apellido"];
			$direccion = $_POST["direccion"];
			
			$consulta = "UPDATE alumnos SET
										nombre = '{$nombre}',
										apellido = '{$apellido}',
										direccion = '{$direccion}'
										WHERE id = {$alumno_id}";
								
			$resultado = mysql_query($consulta, $conexion);
			if(mysql_affected_rows() == 1)
			{
				$mensaje = "Se ha actualizado correctamente el alumno.";
			}
			else
			{
				$mensaje = "Se ha obtenido un error. <br>" . mysql_error();
			}
		}
		else
		{
			$mensaje = "Se han obtenido " . count($errores) . " errores";
		}
	}
?>
<?php obtener_pagina(); ?>
<?php include("includes/header.php"); ?>
			<table id="estructura">
				<tr>
					<td id="menu">
						<?php echo menu($curso_reg, $alumno_reg); ?>
						<br>
						<a href="new_course.php">Agregar un nuevo curso</a>
					</td>
					<td id="pagina">
						<h2>Editar alumno: <?php echo $alumno_reg['apellido'] . " " . $alumno_reg['nombre']; ?></h2>
						<?php
							if(isset($mensaje))
							{
								echo $mensaje;
								foreach($errores as $error)
								{
									echo "<br> - " . $error;
								}
							}
						?>
						<form action="edit_student.php?alumno=<?php echo $alumno_reg['id']; ?>" method="post">
							<p>Nombre del alumno: <input name="nombre" value="<?php echo $alumno_reg['nombre']; ?>"></p>
							<p>Apellido del alumno: <input name="apellido" value="<?php echo $alumno_reg['apellido']; ?>"></p>
							<p>Dirección del alumno: <input name="direccion" value="<?php echo $alumno_reg['direccion']; ?>"></p>
							<input type="submit" value="Editar alumno">
							<a href="delete_student.php?alumno=<?php echo $alumno_reg['id']; ?>">Borrar alumno</a>
						</form>

						<a href="edit_course.php?curso=<?php echo $curso_reg['id']; ?>">Cancelar</a>
						
					</td>
				</tr>	
			</table>
<?php require_once("includes/footer.php"); ?>
