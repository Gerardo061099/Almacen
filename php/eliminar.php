<?php
/**
 * 
 */
include("abrir_conexion.php");
/**
 * 
 */
$datos = file_get_contents('php://input');
$contenido = json_decode($datos);
$id_delete = $contenido->id_delete;
    try {
        $sql = mysqli_query($conexion,"DELETE FROM $tbherr_db7 where id_herramienta = $id_delete ");
        $data['response'] = '1';
    } catch (Exception $e) {
        $data['response'] = '0';
    }
print json_encode($data,JSON_UNESCAPED_UNICODE);
include("cerrar_conexion.php");
?>