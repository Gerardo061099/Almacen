<?php

/**
 *
 */
include 'funciones_factura.php';
/**
 *
 */

$data_js = file_get_contents('php://input');
$data_json = json_decode($data_js);
$n_factura = $data_json->n_factura;
$data_array = $data_json->data_array;
$fecha = $data_json->fecha;
$option = $data_json->option;
$yearFilter = $data_json->yearFilter;
switch ($option) {
    case 1:
        $registrosFact = showlastFactura();
        $data = $registrosFact;
        break;
    case 2:
        $result = operationsFacturas($n_factura, $data_array, $fecha);
        if ($result['status'] == 1) {
            $data['status'] = 'Registro completo';
        } else {
            $data['status'] = 'Error';
            $data['error'] = $result['message'];
        }
        break;
    case 3:
        $data = facturasList($yearFilter);
        break;
    case 4:
        $data = getFacturaDetails($n_factura, $yearFilter);
        break;
    default:
        break;
}

if ($option == 4) {
    return print json_encode($data, JSON_UNESCAPED_SLASHES);
} else {
    print json_encode($data, JSON_UNESCAPED_UNICODE);
}
