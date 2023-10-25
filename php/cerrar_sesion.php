<?php
	session_start();
	session_unset();
	session_destroy();
	$_SESSION['sesion_exito']=4;//error 4 cerro sesion exitosamente
	header('Location: ../login.php');
?>