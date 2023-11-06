<?php
/**
 * 
 */
include("abrir_conexion.php");
/**
 * 
 */
$datos = file_get_contents("php://input");
$get_datos_dec = json_decode($datos);
$option = $get_datos_dec -> option;
$type_data;
switch ($option) {
    case 1:
        $consultaGav = mysqli_query($conexion,"SELECT * FROM $tbgav_db6 ORDER BY Num_gavilanes");
        if (mysqli_num_rows($consultaGav) > 0) {
            $data = mysqli_fetch_all($consultaGav, MYSQLI_ASSOC);
        }
        if (mysqli_affected_rows($conexion) == 0) {
            $data = '';
        }
        $type_data = 'gavilanes';
        break;
    case 2:
        $consultMed = mysqli_query($conexion,"SELECT * FROM $tbmed_db9");
        if (mysqli_num_rows($consultMed) > 0) {
            $data = mysqli_fetch_all($consultMed, MYSQLI_ASSOC);
        }
        if (mysqli_affected_rows($conexion) == 0) {
            $data = '';
        }
        $type_data = 'medidas';
        break;
    case 3:
        $consultCatergoria = mysqli_query($conexion,"SELECT * FROM $tbcat_db3");
        if (mysqli_num_rows($consultCatergoria) > 0) {
            $data = mysqli_fetch_all($consultCatergoria, MYSQLI_ASSOC);
        }
        if (mysqli_affected_rows($conexion) == 0) {
            $data = '';
        }
        $type_data = 'categorias';
        break;
    default:
        $type_data = 'sin datos';
        $data = 'sin datos';
        break;
}

if($type_data == 'gavilanes' || $type_data == 'categorias' || $type_data == 'sin datos') {
print json_encode($data,JSON_UNESCAPED_UNICODE);
}
if($type_data == 'medidas') {
print json_encode($data,JSON_UNESCAPED_SLASHES);
}
include('cerrar_conexion.php');
?>