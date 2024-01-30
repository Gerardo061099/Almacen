<?php
//importante
    session_start();
    include("php/abrir_conexion.php");
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $queryUser = mysqli_query($conexion,"SELECT user FROM $tbu_db1 WHERE id_us = $id");
        $result = mysqli_fetch_assoc($queryUser);

        $user = null;
        if (mysqli_num_rows($queryUser) > 0) {
            $user = $result;
            $_SESSION['usuario'] = $user['user'];
        }
    } else {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <link rel="apple-touch-icon" href="img/pie-chart.png">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body class="pag" onload="mueveReloj()" style="background: #17202A;">
    <!-- Image and text -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="navbar-brand">
            ALUXSA S.A de C.V
        </div>
        <form name="form_reloj">
            <input type="text" name="reloj" size="10" onfocus="window.document.form_reloj.reloj.blur()" style="background-color : #283747; color : White; font-family : Verdana, Arial, Helvetica; font-size : 12pt; text-align : center;">
        </form>
        <div class="dropdown d-flex align-items-center pr-4">
            <div class="px-2"> 
                <img src="img/login_profile_user.png" alt="">
            </div>
            <p class="mb-0 px-1">
                <span class="text-white"><?php echo $_SESSION['usuario'];?></span>
            </p>
            <button class="btn btn-dark btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#"><i class="fa-solid fa-house"></i> Inicio</a>
                <a class="dropdown-item" href="add_user.php"><i class="fa-solid fa-user-plus"></i> Agregar usuario</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a>
            </div>
        </div>
    </nav>
    <center>
        <div class="box-1 p-3">
            <div class="encabesado text-white p-2">
                <h1 class="">¡Bienvenido  al sistema de inventario de ALUXSA!</h1>
            </div>
        </div>
    </center>
    <center>
    <div class="card-categorias">
        <div class="card text-white bg-primary mb-3" id="card1" style="max-width: 18rem;">
            <div class="card-header">Herramientas</div>
            <div class="card-body">
                <h5 class="card-title">Lista de herramientas</h5>
                <p class="card-text"><center><a href="inventario.php"><img src="img/drilling.png" alt=""></a></center></p>
            </div>
        </div>
        <div class="card text-white bg-success mb-3" id="card1" style="max-width: 18rem;">
            <div class="card-header">Categorias</div>
            <div class="card-body">
                <h5 class="card-title">Lista de Categorias</h5>
                <p class="card-text"><center><a href="registros.php"><img src="img/categ.png" alt=""></a></center></p>
            </div>
        </div>
        <div class="card text-white bg-danger mb-3" id="card1" style="max-width: 18rem;">
            <div class="card-header">Reportes</div>
            <div class="card-body">
                <h5 class="card-title">Herramientas agotadas</h5>
                <p class="card-text"><center><a href="herramienta_agotada.php"><img src="img/report.png" alt=""></center></a></p>
            </div>
        </div>
        <div class="card text-white bg-info mb-3" id="card1" style="max-width: 18rem;">
            <div class="card-header">Solicitudes</div>
            <div class="card-body">
                <h5 class="card-title">Registrar solicitud</h5>
                <p class="card-text"><center><a href="solicitudes.php"><img src="img/responsive.png" alt=""></center></a></p>
            </div>
        </div>
        <div class="card text-white bg-dark mb-3" id="card1" style="max-width: 18rem;">
            <div class="card-header">Salidas del almacén</div>
            <div class="card-body">
                <h5 class="card-title">Salidas del almacén</h5>
                <p class="card-text"><center><a href="salidas_almacen.php"><img src="img/out.png" alt=""></center></a></p>
            </div>
        </div>
    </div>
    </center>
    
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="js/reloj.js"></script>
</body>
</html>