<?php

/**
 *
 */

/**
 *
 */

function operationsFacturas($n_factura, $data_array, $fecha)
{
    try {
        include 'abrir_conexion.php';
        mysqli_query($conexion, "INSERT INTO $tbfact_db11 (n_factura) VALUES ($n_factura)");
        $IdFactura = QueryidFactura($n_factura);
        InsertDetalleFact($IdFactura, $data_array, $fecha);
        $result['status'] = 1;
    } catch (Exception $e) {
        $result['status'] = 2;
        $result['message'] = $e;
    }
    return $result;
}


function QueryidFactura($n_factura)
{
    include 'abrir_conexion.php';
    $SelectidFactura = mysqli_query($conexion, "SELECT id FROM $tbfact_db11 WHERE n_factura = $n_factura");
    $res = mysqli_fetch_assoc($SelectidFactura);
    $IdFactura = (int) $res['id'];
    include 'cerrar_conexion.php';
    return $IdFactura;
}

function InsertDetalleFact($idFactura, $data_array, $fecha)
{
    include 'abrir_conexion.php';
    for (
        $i = 0;
        $i < sizeof($data_array);
        $i++
    ) {
        $cantidad = (int) $data_array[$i][0];
        $articulo = (int) $data_array[$i][1];
        $precio_u = (float) substr($data_array[$i][2], 1);
        $importe = (float) substr($data_array[$i][3], 1);
        mysqli_query($conexion, "INSERT INTO $tbdetfact_db12 (id_herramienta,cantidad,valor_u,importe,id_factura,fecha) VALUES ($articulo,$cantidad,$precio_u,$importe,$idFactura,'$fecha')");
        stock($articulo, $cantidad);
    }
    include 'cerrar_conexion.php';
}
function stock($id, $stockIn)
{
    include "abrir_conexion.php";
    $stockExistente = mysqli_query($conexion, "SELECT cantidad AS stock FROM $tbherr_db7 WHERE id_herramienta = $id");
    $result = mysqli_fetch_assoc($stockExistente);
    $stockExistente = (int) $result['stock'];
    $newStock = (int) $stockIn + $stockExistente;
    include "cerrar_conexion.php";
    updateStock($id, $newStock);
}
function updateStock($id, $updateStock)
{
    include "abrir_conexion.php";
    mysqli_query($conexion, "UPDATE $tbherr_db7 SET cantidad = $updateStock WHERE id_herramienta = $id");
}
function showlastFactura()
{
    include "abrir_conexion.php";
    $facturaItems = mysqli_query($conexion, "SELECT df.id AS id,CONCAT(h.nombre,' ',c.material,' ',c.descripcion,' de ',g.num_gavilanes,' gavilanes de ',m.ancho,' x ',m.largo) AS articulo,h.cantidad AS existencia,df.cantidad AS cantidad,df.valor_u AS valor_u,df.importe AS importe,f.n_factura AS n_factura,df.fecha AS fecha FROM $tbdetfact_db12 df INNER JOIN $tbherr_db7 h ON df.id_herramienta = h.id_herramienta INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria INNER JOIN $tbgav_db6 g ON h.id_gavilanes = g.id_gav INNER JOIN $tbmed_db9 m ON h.id_medidas = m.id_medidas INNER JOIN $tbfact_db11 f ON df.id_factura = f.id WHERE df.id_factura = (SELECT MAX(id_factura) FROM $tbdetfact_db12) ");
    $result = mysqli_fetch_all($facturaItems, MYSQLI_ASSOC);
    include 'cerrar_conexion.php';
    return $result;
}
function facturasList($yearFilter)
{
    include "abrir_conexion.php";
    $patron_busqueda = "%{$yearFilter}%";
    $stmt = $conexion->prepare("SELECT df.id_factura AS id,f.n_factura AS n_factura FROM $tbdetfact_db12 df INNER JOIN $tbfact_db11 f ON df.id_factura = f.id WHERE df.fecha like ? GROUP BY df.id_factura");
    $stmt->bind_param("s", $patron_busqueda);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conexion->close();
    return $data;
}

function getFacturaDetails($n_factura, $yearFactura)
{
    include "abrir_conexion.php";
    $patrob_busqueda = "%{$yearFactura}%";
    $n_factura = (int) $n_factura;
    $stmt = $conexion->prepare("SELECT df.id AS id,CONCAT(h.nombre,' ',c.material,' ',c.descripcion,' de ',g.num_gavilanes,' gavilanes de ',m.ancho,' x ',m.largo) AS articulo,df.cantidad AS cantidad,df.valor_u AS valor_u,df.importe AS importe FROM $tbdetfact_db12 df INNER JOIN $tbherr_db7 h ON df.id_herramienta = h.id_herramienta INNER JOIN $tbcat_db3 c ON h.id_categoria = c.id_categoria INNER JOIN $tbgav_db6 g ON h.id_gavilanes = g.id_gav INNER JOIN $tbmed_db9 m ON h.id_medidas = m.id_medidas INNER JOIN $tbfact_db11 f ON df.id_factura = f.id WHERE f.n_factura = ? AND df.fecha LIKE ?");
    $stmt->bind_param("is", $n_factura, $patrob_busqueda);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all();
    $stmt->close();
    $conexion->close();
    return $data;
}

//getFacturaDetails("33005", "2025");
