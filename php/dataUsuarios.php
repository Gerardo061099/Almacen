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
$opcion = $obtenido -> opcion;
$nombre = $obtenido -> nombre;
$apellidos = $obtenido -> apellidos;
$email = $obtenido -> email;
$pass = $obtenido -> pass;
$num_e = $obtenido -> num_e;
$estado = $obtenido -> estado;
$delete_id = $obtenido -> delete_id;
$registro_id = $obtenido -> registro_id;
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
    case 2:
        //$numero_e = (int)$num_e;
        $setUsuarios = addUsuario($nombre,$apellidos,$email,$pass,$num_e,$estado);
        if ($setUsuarios == true) {
            $data['result'] = '1';
        }
        if ($setUsuarios != true) {
            $data['result'] = ''; 
        }
        break;
    case 3:
        if ($pass == '') {
            $updatenotpass = updateUsernotpass($registro_id,$nombre,$apellidos,$email,$num_e,$estado);
            if ($updatenotpass == true) {
                $data['result'] = '1';
            }
            if ($updatenotpass == false) {
                $data['result'] = ''; 
            }
        }
        if ($pass != '') {
            $updateUser = actualizarUsuario($registro_id,$nombre,$apellidos,$email,$pass,$num_e,$estado);
            if ($updateUser == true) {
                $data['result'] = '1';
            }
            if ($updateUser == false) {
                $data['result'] = ''; 
            }
        }
        break;
    case 4:
        $deleteUsuario = borrarUsuario($delete_id);
        if($deleteUsuario == true) {
            $data['result'] = '1';
        }
        if ($deleteUsuario == false) {
            $data['result'] = '';
        }
        break;
    default:
        $data = '';
        break;
}
print json_encode($data,JSON_UNESCAPED_UNICODE);
