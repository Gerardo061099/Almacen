<?php

/**
 * 
 */


/**
 * 
 */

function busquedaEmpleado()
{
    include "abrir_conexion.php";
    $stmt = $conexion->prepare("SELECT id_Empleado FROM $tbem_db5 WHERE id_Empleado = (SELECT MAX(id_Empleado) FROM $tbem_db5)");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data['id_Empleado'];
}

function insertEmpleado($nombre, $apellidos, $n_empleado)
{
    include "abrir_conexion.php";
    $stmt = $conexion->prepare("INSERT INTO $tbem_db5 (Nombre,Apellidos,N_Empleado) values (?,?,?)");
    $stmt->bind_param("ssi", $nombre, $apellidos, $n_empleado);
    $stmt->execute();
    $stmt->close();
    $conexion->close();
}

function getIdEmpleado($nombre, $apellidos)
{
    include "abrir_conexion.php";
    $stmt = $conexion->prepare("SELECT id_Empleado FROM $tbem_db5 WHERE Nombre = ? AND Apellidos = ?");
    $stmt->bind_param("ss", $nombre, $apellidos);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $result->num_rows > 0 ? $data['status'] = true : $data['status'] = false;
    $stmt->close();
    $conexion->close();
    return $data;
}
function insertSolicitud($idEmpleado)
{
    include "abrir_conexion.php";
    $stmt = $conexion->prepare("INSERT INTO $tbsoli_db10 (id_Empleado,Fecha) VALUES (?, now())");
    $stmt->bind_param("i", $idEmpleado);
    $stmt->execute();
    $stmt->close();
    $conexion->close();
}

function getIdSolicitud()
{
    include "abrir_conexion.php";
    $stmt = $conexion->prepare("SELECT MAX(id_solicitud) AS id_solicitud FROM $tbsoli_db10 ");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data['id_solicitud'];
}

function verificaStock($stock, $idHerramienta)
{
    include "abrir_conexion.php";
    $stock = (int)$stock;
    $stmt = $conexion->prepare("SELECT cantidad FROM $tbherr_db7 WHERE id_Herramienta = ?");
    $stmt->bind_param("i", $idHerramienta);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $data['cantidad'] = (int)$data['cantidad'];
    $stmt->close();
    $conexion->close();
    if ($data['cantidad'] >= $stock) {
        return $data['cantidad'] - $stock;
    } else {
        return $data['message'] = "La cantidad solicitada es mayor a la cantidad en existencia";
    }
}
