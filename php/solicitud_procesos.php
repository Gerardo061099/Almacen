<?php

/**
 * 
 */
include 'funciones_solicitud.php';
/**
 * 
 */
$request = file_get_contents('php://input');
$requestdata = json_decode($request);
$option = $requestdata->option;
$herramienta = $requestdata->herramienta;
$categoriaid = $requestdata->categoriaid;
$medidasid = $requestdata->medidasid;
$gavilanesid = $requestdata->gavilanesid;
switch ($option) {
    case 1:
        $categorias = getCategoria_H($herramienta);
        if (mysqli_num_rows($categorias) > 0) {
            $data = mysqli_fetch_all($categorias, MYSQLI_ASSOC);
        }
        if (mysqli_num_rows($categorias) < 1) {
            $data['status'] = 'error';
            $data['result'] = '';
        }
        break;
    case 2:
        $idcate = (int) $categoriaid;
        $medidas = getMedidas_H($herramienta, $idcate);
        if (mysqli_num_rows($medidas) > 0) {
            $data = mysqli_fetch_all($medidas, MYSQLI_ASSOC);
        }
        if (mysqli_num_rows($medidas) < 1) {
            $data['status'] = 'error';
            $data['result'] = '';
        }
        break;
    case 3:
        $idcate = (int) $categoriaid;
        $idmedidas = (int) $medidasid;
        $gavilanes = getGavilanes_H($herramienta, $idcate, $idmedidas);
        if (mysqli_num_rows($gavilanes) > 0) {
            $data = mysqli_fetch_all($gavilanes, MYSQLI_ASSOC);
        }
        if (mysqli_num_rows($gavilanes) < 1) {
            $data['status'] = 'error';
            $data['result'] = '';
        }
        break;
    case 4:
        $idcate = (int) $categoriaid;
        $idmedidas = (int) $medidasid;
        $idgavilanes = (int) $gavilanesid;
        $herramienta = getHerramienta_filter($herramienta, $idcate, $idmedidas, $idgavilanes);
        if (mysqli_num_rows($herramienta) > 0) {
            $data = mysqli_fetch_assoc($herramienta);
        }
        if (mysqli_num_rows($herramienta) < 1) {
            $data['status'] = 'error';
            $data['result'] = '';
        }
        break;
    default:
        $data['status'] = 'Error';
        break;
}
if ($option == 2) print json_encode($data, JSON_UNESCAPED_SLASHES);

if ($option != 2 && $option != 4) print json_encode($data, JSON_UNESCAPED_UNICODE);

if ($option == 4) print json_encode($data, JSON_UNESCAPED_SLASHES);
