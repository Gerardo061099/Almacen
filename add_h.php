<?php

/**
 *
 */
include 'php/abrir_conexion.php';
/**
 *
 */
//ajax
$categoriaT = $_POST['categoriaText'];
$arrayCategorias = explode(' ', $categoriaT);
$material = $arrayCategorias[0];
$descripcion = "{$arrayCategorias[1]} {$arrayCategorias[2]}";
$medidasT = $_POST['medidasText'];
$arrayMedidas = explode('x', $medidasT);
$ancho = $arrayMedidas[0];
$largo = $arrayMedidas[1];
$gavilanesT = intval($_POST['gavilanesText']);
$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$cantidadm = $_POST['cantidadm'];
$medidas = $_POST['medidas'];
$categoria = $_POST['categoria'];
$n_gavilanes = $_POST['gavilanes'];
//-------------------subimos foto--------------------------------
$nombre_img = $_FILES['img']['name'];
$extencion = pathinfo($nombre_img, PATHINFO_EXTENSION);
// obtenemos la extencion del archivo
$formatos = ['png', 'jpeg', 'jpg'];
//así obtiene el nombre del archivo FILE
$temporal = $_FILES['img']['tmp_name'];
// obtenemos el peso de la imagen
$img_size = $_FILES['img']['size'];
//así obtiene el archivo FILE
$carpeta = 'img2';
$ruta = "{$carpeta}/{$nombre_img}";
try {
    if (in_array($extencion, $formatos)) {
        if ($img_size < 3000000) { // sea menor a 3 MB
            $stmt = mysqli_query($conexion, "SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE h.Nombre = '$nombre' AND c.material = '$material' AND c.descripcion = '$descripcion' AND g.Num_gavilanes = $gavilanesT AND m.Ancho = '$ancho' AND m.Largo = '$largo'");
            if (mysqli_num_rows($stmt) > 0) {
                echo 'La herramienta ya existe';
            } else {
                if (move_uploaded_file($temporal, $ruta)) {
                    $insertaH = mysqli_query($conexion, "INSERT INTO $tbherr_db7 (id_categoria,nombre,id_gavilanes,id_medidas,cantidad_minima,cantidad,rutaimg,fecha_hora) values ($categoria,'$nombre',$n_gavilanes,$medidas,$cantidadm,$cantidad,'$ruta',now())");
                    if ($insertaH == true) {
                        echo 'Insercion exitosa';
                    }
                    if ($insertaH == false) {
                        echo 'Error al insertar la informacion';
                    }
                } else {
                    echo 'Error al subir la imagen al servidor';
                }
            }
        } else {
            echo 'La imagen pesa demasiado';
        }
    }
    if (!in_array($extencion, $formatos)) {
        echo 'La extencion del archivo no es permitida';
    }
} catch (Exception $e) {
    echo $e;
}
include 'php/cerrar_conexion.php';
