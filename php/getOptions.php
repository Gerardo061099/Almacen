<?php

/**
 * 
 */
include("abrir_conexion.php");
/**
 * 
 */
$d = file_get_contents('php://input');
$result = json_decode($d);
$name_select = $result->herramienta;

$queryRes = mysqli_query($conexion, "SELECT m.ancho AS ancho FROM $tbherr_db7 h INNER JOIN $tbmed_db9 m ON h.id_Medidas = m.id_Medidas WHERE nombre = '$name_select' GROUP BY m.ancho ORDER BY m.ancho");
$data = mysqli_fetch_all($queryRes, MYSQLI_ASSOC);

print json_encode($data, JSON_UNESCAPED_SLASHES);
include("cerrar_conexion.php");
