<?php require("includes/session.php"); ?>
<?php verificar_sesion(); ?>
<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
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
						<?php
							if(!is_null($curso_reg))
							{
						?>
						<h2><?php	echo $curso_reg["descripcion"]; ?></h2>
						<?php
							} elseif(!is_null($alumno_reg))
							{
						?>
						<h2><?php echo $alumno_reg["apellido"] . " " . $alumno_reg["nombre"]; ?></h2>
						<div id="pagina-contenido">
						<?php echo $alumno_reg["direccion"]; ?>
						<p>
							<a href="edit_student.php?alumno=<?php echo $alumno_reg['id']; ?>">Editar alumno</a>
						</p>
						<?php
							} elseif(!is_null($materia_reg))
							{
						?>
						<h2><?php echo $_POST["nombre"] . " " . $materia_reg["nota"]; ?></h2>
						<?php } else { ?>
						<h2>Selecciona alg�n curso o alumno</h2>
						<?php
							}
						?>
					</td>
				</tr>	
			</table>
<?php require_once("includes/footer.php"); ?>
