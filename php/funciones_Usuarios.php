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
    function encryptingPass($pass) {
        $pass_encrypt = password_hash($pass,PASSWORD_BCRYPT);
        return $pass_encrypt;
    }
    function addUsuario($nombre,$apellidos,$email,$pass,$num_e,$estado) {
        $pass_bcrypt = encryptingPass($pass);
        include("abrir_conexion.php");
        try {
            $AgregarUsuario = mysqli_query($conexion,"INSERT INTO $tbu_db1 (Nombre,Apellidos,user,pass,Num_empleado,Estado) VALUES ('$nombre','$apellidos','$email','$pass_bcrypt',$num_e,'$estado')");
            return $AgregarUsuario;
        } catch (Exception $e) {
            return false;
        }
        include("cerrar_conexion.php");
    }

    function borrarUsuario($delete_id) {
        include("abrir_conexion.php");
        try {
            $deleteUsuario = mysqli_query($conexion,"DELETE FROM $tbu_db1 WHERE id_us = $delete_id");
            return $deleteUsuario;
        } catch (Exception $e) {
            return false;
        }
        include("cerrar_conexion.php");
    } 

    function updateUsernotpass($registro_id,$nombre,$apellidos,$user,$num_e,$estado){
        include("abrir_conexion.php");
        try {
            $queryUpdate = mysqli_query($conexion,"UPDATE $tbu_db1 SET Nombre = '$nombre', Apellidos = '$apellidos', user = '$user', Num_empleado = $num_e, Estado = '$estado' WHERE id_us = $registro_id");
            return $queryUpdate;
        } catch (Exception $e) {
            return false;
        }
    }
    function actualizarUsuario($registro_id,$nombre,$apellidos,$user,$pass,$num_e,$estado) {
        $pwd_encrypt = encryptingPass($pass);
        include("abrir_conexion.php");
        try {
            $actualizarUser = mysqli_query($conexion,"UPDATE $tbu_db1 SET Nombre = '$nombre', Apellidos = '$apellidos', user = '$user', pass = '$pwd_encrypt', Num_empleado = $num_e, Estado = '$estado' WHERE id_us = $registro_id");
            return $actualizarUser;
        } catch (Exception $e) {
            return false;
        }
        include("cerrar_conexion.php");
    }

    //print encryptingPass('paz');