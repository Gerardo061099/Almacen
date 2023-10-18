<?php
/**
 * 
 */
include("funciones_Usuarios.php");
/** 
  * 
  */
$datosRecibidos = file_get_contents('php://input');
$obtenido = json_decode($datosRecibidos);
$opcion = 1;//$obtenido -> opcion;

switch ($opcion) {
    case 1:
        $datosUsuarios = getUsuarios();
        if (mysqli_num_rows($datosUsuarios) > 0) {
            $data = mysqli_fetch_all($datosUsuarios,MYSQLI_ASSOC);
        }
        if (mysqli_num_rows($datosUsuarios) < 1) {
            $data = '';
        }
        break;
    
    default:
        $data = '';
        break;
}
print json_encode($data,JSON_UNESCAPED_UNICODE);
