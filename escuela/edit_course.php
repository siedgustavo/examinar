<?php require("includes/session.php"); ?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(intval($_GET["curso"]) == 0)
	{
		header("Location: content.php");
		exit;
	}
	
	if(isset($_POST["descripcion"]))
	{
		$campos_obligatorios = array("descripcion", "posicion", "visibilidad");
		
		$errores = validarCamposObligatorios($campos_obligatorios);
		
		if(empty($errores))
		{
			$curso_id = $_GET["curso"];
			$descripcion = $_POST["descripcion"];
			$posicion = $_POST["posicion"];
			$visibilidad = $_POST["visibilidad"];
			
			$consulta = "UPDATE cursos SET
										descripcion = '{$descripcion}',
										posicion = {$posicion},
										visibilidad = {$visibilidad}
										WHERE id = {$curso_id}";
								
			$resultado = mysql_query($consulta, $conexion);
			if(mysql_affected_rows() == 1)
			{
				$mensaje = "Se ha actualizado correctamente el curso.";
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
					</td>
					<td id="pagina">
						<h2>Editar curso: <?php echo $curso_reg['descripcion']; ?></h2>
						<form action="edit_course.php?curso=<?php echo $curso_reg['id']; ?>" method="post">
							<p>Descripción del Curso: <input name="descripcion" value="<?php echo $curso_reg['descripcion']; ?>"></p>
							<p>Posición:
								<select name="posicion">
									<?php
										$todos_los_cursos = obtener_cursos();
										$num_cursos = mysql_num_rows($todos_los_cursos);
										for($i=1; $i <= $num_cursos + 1; $i++)
										{
											echo "<option value=\"{$i}\"";
											if($curso_reg["posicion"] == $i)
											{
												echo " selected";
											}
											echo ">{$i}</option>";
										}
									?>
								</select>
							</p>
							<p>Visible:
								<input type="radio" name="visibilidad" value="0"
								<?php if($curso_reg["visibilidad"] == 0) { echo " checked"; } ?>
								>No</input>
								<input type="radio" name="visibilidad" value="1"
								<?php if($curso_reg["visibilidad"] == 1) { echo " checked"; } ?>
								>Si</input>
							</p>
							<input type="submit" name="submit" value="Editar curso">
							<a href="delete_course.php?curso=<?php echo $curso_reg['id']; ?>">Borrar Curso</a>
						</form>
						<a href="content.php">Cancelar</a>
						<p>
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
						</p>
						<hr>
						<h3>Alumnos del curso</h3>
						<ul>
						<?php
							$alumnos = obtener_alumnos_por_curso($curso_reg['id']);
							while($alumno = mysql_fetch_array($alumnos))
							{
								echo "<li><a href=\"content.php?alumno=" . $alumno['id'] . "\">" . 
									$alumno['apellido'] . " " . $alumno['nombre'] . "</a></li>";
							}
						?>
						</ul>
						<br>
						<a href="new_student.php?curso=<?php echo $curso_reg['id']; ?>">
							Agregar un nuevo alumno a este curso
						</a>
					</td>
				</tr>	
			</table>
<?php require_once("includes/footer.php"); ?>
