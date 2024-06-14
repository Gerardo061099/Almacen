<?php

/**
*
*/
include( 'funciones_factura.php' );
/**
*
*/

$data_js = file_get_contents( 'php://input' );
$data_json = json_decode( $data_js );
$n_factura = $data_json -> n_factura;
$data_array = $data_json -> data_array;
$fecha = $data_json -> fecha;
$option = $data_json -> option;
switch ( $option ) {
    case 1:
    # code...
    break;
    case 2:
    $result = InsertFactura( $n_factura, $data_array, $fecha );
    if ( $result == 1 ) {
        $data[ 'status' ] = 'Registro completo';
    } else {
        $data[ 'status' ] = 'Error';
    }
    break;
    default:
    # code...
    break;
}

print json_encode( $data, JSON_UNESCAPED_UNICODE );

