<?php
/**
*
*/
include( 'php/abrir_conexion.php' );
/**
*
*/
//ajax
$nombre = $_POST[ 'nombre' ];
$cantidad = $_POST[ 'cantidad' ];
$cantidadm = $_POST[ 'cantidadm' ];
$medidas = $_POST[ 'medidas' ];
$categoria = $_POST[ 'categoria' ];
$n_gavilanes = $_POST[ 'gavilanes' ];
//-------------------subimos foto--------------------------------
$nombre_img = $_FILES[ 'img' ][ 'name' ];
$extencion = pathinfo( $nombre_img, PATHINFO_EXTENSION );
// obtenemos la extencion del archivo
$formatos = array( 'png', 'jpeg', 'jpg' );
//así obtiene el nombre del archivo FILE
$temporal = $_FILES[ 'img' ][ 'tmp_name' ];
//así obtiene el archivo FILE
$carpeta = 'img2';
$ruta = $carpeta . '/' . $nombre_img;
if ( $nombre == '' || $cantidad == '' || $medidas == 'Choose...' || $categoria == 'Choose...' || $n_gavilanes == 'Choose...' || $nombre_img == '' ) {
    echo 'campos vacios';
} else {
    try {
        if ( in_array( $extencion, $formatos ) ) {
            if ( move_uploaded_file( $temporal, $ruta ) ) {
                $insertaH = mysqli_query( $conexion, "INSERT INTO $tbherr_db7 (id_categoria,nombre,id_gavilanes,id_medidas,cantidad_minima,cantidad,rutaimg,fecha_hora) values ($categoria,'$nombre',$n_gavilanes,$medidas,$cantidadm,$cantidad,'$ruta',now())" );
                if ( $insertaH == true ) {
                    echo 'Insercion exitosa';
                }
                if ( $insertaH == false ) {
                    echo 'Error al insertar la informacion';
                }
            } else {
                echo 'Error al subir la imagen al servidor';
            }
        }
        if ( !in_array( $extencion, $formatos ) ) {
            echo 'La extencion del archivo no es permitida';
        }
    } catch ( Exception $e ) {

        echo $e;
    }
}
include( 'php/cerrar_conexion.php' );
