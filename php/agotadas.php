<?php

/**
 * 
 */

/**
 * 
 */

$req = file_get_contents("php://input");
$dataDecode = json_decode($req);
$option = $dataDecode->option;
switch ($option) {
    case 1:
        include "abrir_conexion.php"; // conexion con la BD
        $stmt = $conexion->prepare("SELECT h.id_herramienta AS id,h.Nombre AS nombre,c.material AS material,c.descripcion AS descripcion,g.Num_gavilanes AS gavilanes,m.Ancho AS ancho,m.Largo AS largo,h.cantidad_minima AS stock_m,h.cantidad AS stock,h.fecha_hora FROM $tbherr_db7 h inner join categorias c on h.id_categoria = c.id_categoria inner join gavilanes g on h.id_gavilanes = g.id_gav inner join medidas m on h.id_medidas = m.id_medidas  WHERE cantidad < Cantidad_Minima ORDER BY id_herramienta");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conexion->close();
        break;
    default:
        # code...
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
