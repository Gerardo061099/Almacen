<?php
/**
 * 
 */
    include("abrir_conexion.php");
/**
  * 
  */
    $datos = file_get_contents("php://input");
    $datos = json_decode($datos);
    $option = $datos -> option;
    $registro_id = $datos -> id_registro;
    $nombre_h = $datos -> nombre_h;
    $medidas_id = $datos ->medidas_id;
    $categoria_id = $datos ->categoria_id;
    $gavilanes_id = $datos -> gavilanes_id;
    $stock = $datos -> stock;
    $stock_min = $datos -> stock_min;
    $tipedata;
switch ($option) {
    case 1:
        try {
            $consultaCategoria = mysqli_query($conexion,"SELECT * FROM $tbcat_db3 ");
            $data = mysqli_fetch_all($consultaCategoria, MYSQLI_ASSOC);
            $tipedata = 'categorias';
        } catch (Exception $e) {
            echo $e;
        }
        break;
    case 2:
        try {
            $consultaMedidas = mysqli_query($conexion,"SELECT * FROM $tbmed_db9");
            $data = mysqli_fetch_all($consultaMedidas, MYSQLI_ASSOC);
            $tipedata = 'medidas';
        } catch (Exception $e) {
            echo $e;
        }
        break;
    case 3:
        try {
            $queryGavilanes = mysqli_query($conexion,"SELECT * FROM $tbgav_db6 ORDER BY Num_gavilanes");
            $data = mysqli_fetch_all($queryGavilanes, MYSQLI_ASSOC);
            $tipedata = 'gavilanes';
        } catch (Exception $e) {
            echo $e;
        }
        break;
    case 4:
        try {
            $actualizarHerramienta = mysqli_query($conexion,"UPDATE $tbherr_db7 SET id_Categoria = $categoria_id, Nombre = '$nombre_h', id_Gavilanes = $gavilanes_id, id_Medidas = $medidas_id, Cantidad_Minima = $stock_min, Cantidad = $stock WHERE id_Herramienta = $registro_id");
            $tipedata = 'herramientas';
            if($actualizarHerramienta == true) {
                $data['result'] = '1';
            }
            if($actualizarHerramienta == false) {
                $data['result'] = '0';
            }
        } catch (Exception $e) {
            echo $e;
        }
        break;
    default:
        $data = '';
        break;
}
    
if($tipedata == 'categorias' || $tipedata == 'gavilanes' || $tipedata == 'herramientas') {
    print json_encode($data, JSON_UNESCAPED_UNICODE);
}
if ($tipedata == 'medidas') {
    print json_encode($data, JSON_UNESCAPED_SLASHES);
}
include("cerrar_conexion.php");
?>