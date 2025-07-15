<?php
/**
 * 
 */

/**
  * 
  */

function getCategoria_H($herramienta) {
    include('abrir_conexion.php');
    $result = mysqli_query($conexion,"SELECT h.id_categoria AS id_categoria,c.material AS material,c.descripcion AS descripcion FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE nombre = '$herramienta' GROUP BY h.id_categoria");
    include('cerrar_conexion.php');
    return $result;
}

function getMedidas_H($herr,$categoriaid) {
    include('abrir_conexion.php');
    $query = mysqli_query($conexion,"SELECT h.id_medidas AS id_medidas,m.ancho AS ancho,m.largo AS largo FROM $tbherr_db7 h INNER JOIN $tbmed_db9 m ON h.id_medidas = m.id_medidas WHERE nombre = '$herr' AND id_categoria = $categoriaid GROUP BY h.id_medidas");
    include('cerrar_conexion.php');
    return $query;
}

function getGavilanes_H($herr,$categoriaid,$medidasid) {
    include('abrir_conexion.php');
    $query_medidasOp = mysqli_query($conexion,"SELECT h.id_gavilanes AS id_gavilanes,g.num_gavilanes AS num_gavilanes FROM $tbherr_db7 h INNER JOIN $tbgav_db6 g ON h.id_gavilanes = g.id_gav WHERE nombre = '$herr' AND id_categoria = $categoriaid AND id_medidas = $medidasid GROUP BY h.id_gavilanes");
    include('cerrar_conexion.php');
    return $query_medidasOp;
}

function getHerramienta_filter($herr,$categoriaid,$medidasid,$gavilanesid) {
    include('abrir_conexion.php');
    $query_herramienta = mysqli_query($conexion,"SELECT h.id_herramienta AS id_herramienta,h.nombre AS nombre,c.material AS material,c.descripcion AS descripcion,m.ancho AS ancho,m.largo AS largo,g.num_gavilanes AS num_gavilanes FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria INNER JOIN $tbmed_db9 m ON h.id_medidas = m.id_medidas INNER JOIN $tbgav_db6 g ON h.id_gavilanes = g.id_gav WHERE h.nombre = '$herr' AND h.id_categoria = $categoriaid AND h.id_medidas = $medidasid AND h.id_gavilanes = $gavilanesid");
    include('cerrar_conexion.php');
    return $query_herramienta;
}