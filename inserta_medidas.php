<?php

$ancho_post = $_POST['Ancho'];
$largo_post = $_POST['Largo'];
try {
    $query = verifymedidas($ancho_post, $largo_post);
    if ($query != '') {
        $data['status'] = 'info';
        $data['datos'] = $query;
    } else {
        include "php/abrir_conexion.php";
        mysqli_query($conexion, "INSERT INTO $tbmed_db9 (Ancho,Largo) VALUES ('$ancho_post','$largo_post')");
        $data['status'] = 'ok';
        $data['response'] = 'Medidas registradas';
        include 'php/cerrar_conexion.php';
    }
} catch (Exception $e) {
    $data['status'] = 'error';
    $data['response'] = $e;
}
function verifymedidas($ancho, $largo)
{
    include 'php/abrir_conexion.php';
    $verifyc = mysqli_query($conexion, "SELECT id_Medidas AS id,Ancho,Largo FROM $tbmed_db9 WHERE Ancho = '$ancho' AND Largo = '$largo'");
    $res = mysqli_fetch_assoc($verifyc);
    include 'php/cerrar_conexion.php';
    return $res;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
include "php/cerrar_conexion.php";
