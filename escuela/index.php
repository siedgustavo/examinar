<?php require_once("includes/connection_db.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php obtener_pagina(); ?>
<?php include("includes/header.php"); ?>
			<table id="estructura">
				<tr>
					<td id="menu">
						<?php echo menu_publico($curso_reg, $alumno_reg); ?>
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
						</div>
						<?php
							} elseif(!is_null($materia_reg))
							{
						?>
						<h2><?php echo $materia_reg["nota"]; ?></h2>
						<?php } else { ?>
						<h2>Bienvenido a Escuela</h2>
						<?php
							}
						?>
					</td>
				</tr>	
			</table>
<?php require_once("includes/footer.php"); ?>
