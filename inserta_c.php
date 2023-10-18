<?php
    include("php/abrir_conexion.php");
    $Descripcion = $_POST['descripcion'];
    $Material = $_POST['material'];
    if ($Descripcion != "" || $Material != "") {
        mysqli_query($conexion,"INSERT INTO $tbcat_db3 (Descripcion,Material) values ('$Descripcion','$Material')");
        echo "Proceso exitoso";
    }else {
        echo "Los datos recibidos estan vacios";
    }
    include("php/cerrar_conexion.php");
?>

