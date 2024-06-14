<?php

/**
*
*/

/**
*
*/

function InsertFactura( $n_factura, $data_array, $fecha )
 {
    include( 'abrir_conexion.php' );
    try {
        $insertInfo = mysqli_query( $conexion, "INSERT INTO $tbfact_db11 (n_factura) VALUES ($n_factura)" );
        if ( $insertInfo == true ) {
            $IdFactura = QueryidFactura( $n_factura );
            InsertDetalleFact( $IdFactura, $data_array, $fecha );
            $result = 1;
        }
    } catch ( Exception $e ) {
        $result = 2;
    }
    include( 'cerrar_conexion.php' );
    return $result;
}

function QueryidFactura( $n_factura )
 {
    include( 'abrir_conexion.php' );
    $SelectidFactura = mysqli_query( $conexion, "SELECT id FROM $tbfact_db11 WHERE n_factura = $n_factura" );
    $res = mysqli_fetch_assoc( $SelectidFactura );
    $IdFactura = ( int ) $res[ 'id' ];
    include( 'cerrar_conexion.php' );
    return $IdFactura;
}

function InsertDetalleFact( $idFactura, $data_array, $fecha )
 {
    include( 'abrir_conexion.php' );
    for (
        $i = 0; $i < sizeof( $data_array );
        $i++
    ) {
        $cantidad = ( int ) $data_array[ $i ][ 0 ];
        $articulo = $data_array[ $i ][ 1 ];
        $precio_u = ( float ) substr( $data_array[ $i ][ 2 ], 1 );
        $importe = ( float ) substr( $data_array[ $i ][ 3 ], 1 );
        mysqli_query( $conexion, "INSERT INTO $tbdetfact_db12 (descripcion_articulo,cantidad,valor_u,importe,id_factura,fecha) VALUES ('$articulo',$cantidad,$precio_u,$importe,$idFactura,'$fecha')" );
    }
}
//InsertFactura( 25097, [ [ '2', 'CORTADOR CARBURO VERTICAL RECTO 2 GAV 1/8', "$176.51", "$353.02" ], [ '4', 'BROCA ZR N° 30 ', "$27.60", "$110.40" ], [ '3', 'MACHUELO MILIM USO GRAL 3x0.50mm', "$96.00", "$288.00" ] ], '2023-07-11' );