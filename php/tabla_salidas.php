<?php

/**
 * 
 */

/**
 * 
 */
$dataRequest = json_decode(file_get_contents("php://input"));

$option = $dataRequest->option;

switch ($option) {
    case 1:
        try {
            include "abrir_conexion.php"; // conexion con la BD
            $query = "SELECT s.id_solicitud AS id,CONCAT(e.nombre,' ',e.apellidos) AS solicitante,h.Nombre AS herramienta,c.Descripcion AS descripcion,c.Material As material,g.Num_gavilanes AS gav,m.Ancho AS ancho,m.Largo AS largo,d.cantidad AS cantidad,s.Fecha AS fecha from $tbsoli_db10 s inner join $tbdet_db4 d on s.id_solicitud = d.id_solicitud inner join $tbherr_db7 h on d.id_herramientas = h.id_herramienta inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas inner join $tbem_db5 e on s.id_empleado = e.id_empleado ORDER BY s.id_solicitud DESC";
            $resultados = mysqli_query($conexion, $query);
            $data = mysqli_fetch_all($resultados, MYSQLI_ASSOC);
            include "cerrar_conexion.php";
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        break;
    case 2:
        try {
            include "abrir_conexion.php";
            $query = mysqli_query($conexion, "SELECT ds.id_Solicitud AS id_solicitud,CONCAT(e.Nombre,' ',e.apellidos) as solicitante,e.N_Empleado AS n_empleado,SUM(ds.cantidad) AS stock_solicitado FROM $tbdet_db4 ds INNER JOIN $tbsoli_db10 s ON ds.id_Solicitud = s.id_Solicitud INNER JOIN $tbem_db5 e ON s.id_Empleado = e.id_Empleado WHERE ds.id_Solicitud = (SELECT MAX(ds.id_Solicitud) FROM $tbdet_db4) GROUP BY ds.id_Solicitud");
            if ($query->num_rows > 0) {
                $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
            } else {
                $data['message'] = 'No hay solicitudes registradas';
            }
            include 'cerrar_conexion.php';
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        break;
    default:
        $data['message'] = 'Opcion no valida';
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
