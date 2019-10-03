<?php
	function verificar_consulta($consulta)
	{
		if(!$consulta)
		{
			die("No se ha podido realizar la consulta: " . mysql_error());
		}
	}
	
	function obtener_cursos($publico)
	{
		global $conexion;
		$consulta = "SELECT * 
									FROM cursos ";
		if($publico)
		{
			$consulta .= "WHERE visibilidad = 1 ";
		}
		$consulta .= "ORDER BY posicion ASC";
		$cursos = mysql_query($consulta, $conexion);
		verificar_consulta($cursos);
		return $cursos;
	}
	
	function obtener_alumnos_por_curso($curso_id)
	{
		global $conexion;
		$consulta = "SELECT * 
									FROM alumnos 
									WHERE curso_id= {$curso_id}
									ORDER BY apellido ASC";
		$alumnos = mysql_query($consulta, $conexion);
		verificar_consulta($alumnos);
		return $alumnos;
	}
	
	function obtener_materias_por_alumno($alumno_id)
	{
		global $conexion;
		$consulta = "SELECT a.nota, m.nombre, a.id_materia
									FROM alumnos_materias a, materias m
									WHERE a.id_alumno = {$alumno_id} AND a.id_materia = m.id
									ORDER BY m.nombre ASC";
		$materias = mysql_query($consulta, $conexion);
		verificar_consulta($materias);
		return $materias;
	}
	
	function obtener_curso_por_id($curso_id)
	{
		global $conexion;
		$consulta = "SELECT * 
									FROM cursos
									WHERE id = " . $curso_id . " LIMIT 1";
		$respuesta = mysql_query($consulta, $conexion);
		verificar_consulta($respuesta);
		if($curso = mysql_fetch_array($respuesta))
		{
			return $curso;
		}
		else
		{
			return NULL;
		}
	}

	function obtener_alumno_por_id($alumno_id) 
	{
		global $conexion;
		$consulta = "SELECT * 
									FROM alumnos
									WHERE id=" . $alumno_id . " LIMIT 1";
		$respuesta = mysql_query($consulta, $conexion);
		verificar_consulta($respuesta);
		if ($alumno = mysql_fetch_array($respuesta))
		{
			return $alumno;
		}
		else
		{
			return NULL;
		}
	}
	
	function obtener_materia_por_id($materia_id, $alumno_id) 
	{
		global $conexion;
		$consulta = "SELECT * 
									FROM alumnos_materias
									WHERE id_alumno = " . $alumno_id . 
									" AND id_materia = " . $materia_id .
									" LIMIT 1";
		$respuesta = mysql_query($consulta, $conexion);
		verificar_consulta($respuesta);
		if ($materia = mysql_fetch_array($respuesta))
		{
			return $materia;
		}
		else
		{
			return NULL;
		}
	}
	
	function obtener_pagina() 
	{
		global $curso_reg;
		global $alumno_reg;
		global $materia_reg;
		
		if (isset($_GET["curso"]))
		{
			$curso_reg = obtener_curso_por_id($_GET["curso"]);
			$alumno_reg = NULL;
			$materia_reg = NULL;
		}
		elseif (isset($_GET["alumno"]))
		{
			$alumno_reg = obtener_alumno_por_id($_GET["alumno"]);
			$curso_reg = NULL;
			$materia_reg = NULL;
		}
		elseif (isset($_GET["materia"]))
		{
			$materia_reg = obtener_materia_por_id($_GET["materia"], $_GET["idalumno"]);
			$curso_reg = NULL;
			$alumno_reg = NULL;
		}
		else
		{
			$curso_reg = NULL;
			$alumno_reg = NULL;
			$materia_reg = NULL;
		}
	}
	
	function menu($curso_reg, $alumno_reg)
	{
		$salida = "<ul class=\"cursos\">";
		$cursos = obtener_cursos(false);
		while($curso = mysql_fetch_array($cursos))
		{
			$salida .= "<li";
			if ($curso["id"] == $curso_reg["id"])
			{
				$salida .= " class=\"selected\"";
			}
			$salida .= "><a href=\"edit_course.php?curso=" . $curso["id"] . "\">" . 
					$curso['descripcion'] . "</a></li><ul class='alumnos'>";
			$alumnos = obtener_alumnos_por_curso($curso["id"]);
			while($alumno = mysql_fetch_array($alumnos))
			{
				$salida .= "<li";
				if ($alumno["id"] == $alumno_reg["id"])
				{
					$salida .= " class=\"selected\"";
				}
				$salida .= "><a href=\"content.php?alumno=" . $alumno["id"] . "\">" . 
						$alumno["apellido"] . " " . $alumno["nombre"] . "</a></li>";
			
			}
			$salida .= "</ul>";
		}
		$salida .= "</ul>";
		return $salida;
	}
	
	function menu_publico($curso_reg, $alumno_reg)
	{
		$salida = "<ul class=\"cursos\">";
		$cursos = obtener_cursos(true);
		while($curso = mysql_fetch_array($cursos))
		{
			$salida .= "<li";
			if ($curso["id"] == $curso_reg["id"])
			{
				$salida .= " class=\"selected\"";
			}
			$salida .= "><a href=\"index.php?curso=" . $curso["id"] . "\">" . 
					$curso['descripcion'] . "</a></li>";
			if($curso['id'] == $curso_reg['id'])
			{
				$salida .= "<ul class='alumnos'>";
				$alumnos = obtener_alumnos_por_curso($curso["id"]);
				while($alumno = mysql_fetch_array($alumnos))
				{
					$salida .= "<li";
					if ($alumno["id"] == $alumno_reg["id"])
					{
						$salida .= " class=\"selected\"";
					}
					$salida .= "><a href=\"index.php?alumno=" . $alumno["id"] . "\">" . 
							$alumno["apellido"] . " " . $alumno["nombre"] . "</a></li>";
					$materias = obtener_materias_por_alumno($alumno["id"]);
					while($materia = mysql_fetch_array($materias))
					{
						$salida .= "<li><a href=\"index.php?materia=" . $materia["id_materia"] . 
							"&idalumno=" . $alumno["id"] . "\">" . $materia["nombre"] . "</a></li>";
					}
				}
				$salida .= "</ul>";
			}
		}
		$salida .= "</ul>";
		return $salida;
	}
	
	function validarCamposObligatorios($campos_obligatorios)
	{
		$errores = array();
		
		foreach($campos_obligatorios as $campo)
		{
			if(!isset($_POST[$campo]) || (empty($_POST[$campo])
				&& !is_numeric($_POST[$campo])))
			{
				$errores[] = $campo;
			}
		}
		return $errores;
	}
?> 
