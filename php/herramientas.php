<?php

/**
 * 
 */
include './imgF.php';
include './categoriasHerramientas.php';
/**
 * 
 */

$option = $_POST['option'];
$id = $_POST['id'];
$nombre = $_POST['nombreH'];
$idMedidas = $_POST['idMedidas'];
$idGavilanes = $_POST['idGavilanes'];
$idCategoria = $_POST['idCategoria'];
$cantidad = $_POST['stock'];
$cantidadMinima = $_POST['stockMinimo'];
$imagen = $_FILES['fileImage']['name'];
$tmp = $_FILES['fileImage']['tmp_name'];
$her = $_POST['herramienta'];
$med = $_POST['medida'];
$path = "../img2/";

switch ($option) {
    case 1:
        include './abrir_conexion.php';
        $stmt = $conexion->prepare("SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo,h.cantidad_minima,h.cantidad,h.fecha_hora FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas ORDER BY h.id_herramienta");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conexion->close();
        break;
    case 2:
        try {
            include './abrir_conexion.php';
            if ($tmp != "") {
                saveImage($tmp, $path, $imagen) ? true : false;
                $stmt = $conexion->prepare("UPDATE $tbherr_db7 SET Nombre = ?, id_categoria = ?, id_gavilanes = ?, id_medidas = ?, cantidad_minima = ?, cantidad = ?, rutaimg = ? WHERE id_herramienta = ?");
                $stmt->bind_param("siiiiisi", $nombre, $idCategoria, $idGavilanes, $idMedidas, $cantidadMinima, $cantidad, $imagen, $id);
            } else {
                $stmt = $conexion->prepare("UPDATE $tbherr_db7 SET Nombre = ?, id_categoria = ?, id_gavilanes = ?, id_medidas = ?, cantidad_minima = ?, cantidad = ? WHERE id_herramienta = ?");
                $stmt->bind_param("siiiiii", $nombre, $idCategoria, $idGavilanes, $idMedidas, $cantidadMinima, $cantidad, $id);
            }
            $data['status'] = 'ok';
            $data['message'] = "Herramienta actualizada correctamente. {$nombre} {$imagen}";
        } catch (Exception $e) {
            $data['status'] = 'error';
            $data['message'] = "Error al actualizar la herramienta: {$e->getMessage()}";
        }
        break;
    case 6:
        include './abrir_conexion.php';
        try {
            $stmt = mysqli_query($conexion, "SELECT h.id_herramienta AS id,h.Nombre AS Nombre,c.Descripcion AS Descripcion,c.Material AS Material,g.Num_gavilanes AS Num_gavilanes,m.Ancho AS Ancho,m.Largo AS Largo,h.Cantidad AS Stock,h.Cantidad_Minima AS Stock_minimo,h.rutaimg AS rutaimg FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE h.Nombre LIKE '%$her%' AND m.Ancho LIKE '%$med%' ORDER BY h.id_herramienta");
            $data = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        } catch (Exception $e) {
            $data['status'] = 'error';
            $data['message'] = "Error al buscar la herramienta: {$e->getMessage()}";
        }
        break;
    case 7:
        include './abrir_conexion.php';
        try {
            $stmt = mysqli_query($conexion, "SELECT h.id_herramienta AS id,h.Nombre AS Nombre,c.Descripcion AS Descripcion,c.Material AS Material,g.Num_gavilanes AS Num_gavilanes,m.Ancho AS Ancho,m.Largo AS Largo,h.Cantidad AS Stock,h.Cantidad_Minima AS Stock_minimo,h.rutaimg AS rutaimg FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas ORDER BY h.Nombre");
            $data = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        } catch (Exception $e) {
            $data['status'] = 'error';
            $data['message'] = "Error al buscar la herramienta: {$e->getMessage()}";
        }
        break;
    case 8:
        try {
            $herramientas = [];
            $objAveC = getAveCarburo();
            $objAveH = getAveHSS();
            $objBroC = getBrocasCarburo();
            $objBroH = getBrocasHSS();
            $objBurC = getBurilesCarburo();
            $objBurH = getBurilesHSS();
            $objCortC = getCortadoresCarburo();
            $objCortH = getCortadoresHSS();
            $objMachC = getMachuelosCarburo();
            $objMachH = getMachuelosHSS();
            array_push($herramientas, $objAveC);
            array_push($herramientas, $objAveH);
            array_push($herramientas, $objBroC);
            array_push($herramientas, $objBroH);
            array_push($herramientas, $objBurC);
            array_push($herramientas, $objBurH);
            array_push($herramientas, $objCortC);
            array_push($herramientas, $objCortH);
            array_push($herramientas, $objMachC);
            array_push($herramientas, $objMachH);
            $data = $herramientas;
        } catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        break;
    case 9:
        include './abrir_conexion.php';
        $stmt = $conexion->prepare("SELECT h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE h.cantidad = 0 ");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conexion->close();
        break;

    case 10:
        include './abrir_conexion.php';
        $stmt = $conexion->prepare("SELECT h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE h.cantidad < h.cantidad_minima AND h.cantidad > 0 ");
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conexion->close();
        break;
    default:
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE);
