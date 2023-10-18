<?php
/**
 * 
 */

/**
 * 
 */

    function getUsuarios() {
        include("abrir_conexion.php");
        $Usuariosquery = mysqli_query($conexion,"SELECT id_us,Nombre,Apellidos,user,Num_empleado,Estado FROM $tbu_db1");
        include("cerrar_conexion.php");
        return $Usuariosquery;
    }
