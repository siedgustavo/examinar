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
					</td>
					<td id="pagina">
						<h2>Agregar un nuevo alumno</h2>
						<form action="create_student.php?curso=<?php echo $curso_reg['id']; ?>" method="post">
							<p>Nombre del Alumno: <input name="nombre"></p>
							<p>Apellido del Alumno: <input name="apellido"></p>
							<p>Dirección del Alumno: <input name="direccion"></p>
							<input type="submit" value="Agregar alumno">
						</form>
						<a href="edit_course.php?curso=<?php echo $curso_reg['id']; ?>">Cancelar</a>
					</td>
				</tr>	
			</table>
<?php require_once("includes/footer.php"); ?>
