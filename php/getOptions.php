<?php
/**
 * 
 */
include("php/abrir_conexion.php");
/**
  * 
  */
    $datos = file_get_contents("php://input");
    $result_array = json_decode($datos);
    $name_select = $result_array -> herramienta;

    $consulta = mysqli_query($conexion,"SELECT h.id_herramienta AS id,m.ancho AS ancho FROM $tbherr_db7 h INNER JOIN $tbmed_db9 m ON h.id_Medidas = m.id_Medidas WHERE nombre = '$name_select'");
    $data = mysqli_fetch_all($consulta,MYSQLI_ASSOC);

    print json_encode($data,JSON_UNESCAPED_SLASHES);
    include("php/cerrar_conexion.php");
?>