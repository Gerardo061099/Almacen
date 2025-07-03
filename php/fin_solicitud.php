<?php

/**
 * 
 */
include "funcionesSolicitud.php";
/**
 * 
 */
$dataReq = file_get_contents("php://input");
$resDec = json_decode($dataReq);
$listaSolicitantes = $resDec->listSolicitantes; //array
$nombre = $resDec->nombre; //Juan
$apellidos = $resDec->apellidos; //Hernandez
$n_empleado = $resDec->n_emp; //12345

try {
    $n_empleado = (int)$n_empleado;
    // Verificamos si el empleado ya existe
    $idEm = getIdEmpleado($nombre, $apellidos);
    switch ($idEm['status']) {
        // Si el empleado ya existe, obtenemos su id
        case true:
            $idEmpleado = $idEm['id_Empleado'];
            break;
        case false:
            // Si el empleado no existe, lo insertamos
            // y obtenemos su id
            insertEmpleado($nombre, $apellidos, $n_empleado);
            $idEmpleado = busquedaEmpleado();
            break;
        default:
            throw new Exception("Error en la busqueda del empleado");
    }
    // 
    insertSolicitud($idEmpleado);
    $idSolicitud = getIdSolicitud();
    for ($i = 0; $i < sizeof($listaSolicitantes); $i++) {
        $cantidad = (int)$listaSolicitantes[$i]->stockS; //4
        $id_herramienta = (int)$listaSolicitantes[$i]->id_herramienta; //1
        $result = verificaStock($cantidad, $id_herramienta);
        if (is_numeric($result)) {
            include "abrir_conexion.php";
            mysqli_query($conexion, "INSERT INTO $tbdet_db4 (id_herramientas,id_Solicitud,Cantidad) values ($id_herramienta,$idSolicitud,$cantidad)");
            mysqli_query($conexion, "UPDATE $tbherr_db7 SET cantidad = $result WHERE id_Herramienta = $id_herramienta");
            include "cerrar_conexion.php";
            $data[$i]['status'] = 'ok';
            $data[$i]['id_herramienta'] = $id_herramienta;
            $data[$i]['message'] = 'Solicitud registrada con exito';
        } else {
            $data[$i]['status'] = 'error';
            $data[$i]['id_herramienta'] = $id_herramienta;
            $data[$i]['message'] = 'No hay suficiente stock';
        }
    }
} catch (Exception $e) {
    $data['message'] = $e->getMessage();
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
