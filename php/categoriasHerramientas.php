<?php

/**
 * 
 */

/**
 * 
 */

function getAveCarburo()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Avellanadores_Carburo FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Avellanador' AND c.material = 'Carburo'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getAveHSS()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Avellanadores_HSS FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Avellanador' AND c.material = 'ACERO ALTA VELOCIDAD'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getBrocasCarburo()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Brocas_Carburo FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Broca' AND c.material = 'Carburo'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getBrocasHSS()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Brocas_HSS FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Broca' AND c.material = 'Carburo'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getBurilesCarburo()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Buriles_Carburo FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Buril' AND c.material = 'Carburo'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getBurilesHSS()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Buriles_HSS FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Buril' AND c.material = 'ACERO ALTA VELOCIDAD'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getCortadoresCarburo()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Cortadores_Carburo FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Cortador' AND c.material = 'Carburo'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getCortadoresHSS()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Cortadores_HSS FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Cortador' AND c.material = 'ACERO ALTA VELOCIDAD'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getMachuelosCarburo()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Machuelos_Carburo FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Machuelo' AND c.material = 'Carburo'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}

function getMachuelosHSS()
{
    include './abrir_conexion.php';
    $stmt = $conexion->prepare("SELECT COUNT(h.id_herramienta) AS Machuelos_HSS FROM $tbherr_db7 h INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria WHERE h.nombre = 'Machuelo' AND c.material = 'ACERO ALTA VELOCIDAD'");
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $conexion->close();
    return $data;
}


getAveCarburo();
getAveHSS();
getBrocasCarburo();
getBrocasHSS();
getBurilesCarburo();
getBurilesHSS();
getCortadoresCarburo();
getCortadoresHSS();
getMachuelosCarburo();
getMachuelosHSS();
