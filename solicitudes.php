<?php
//importante
session_start();
include "php/abrir_conexion.php";
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $queryUser = mysqli_query($conexion, "SELECT user FROM $tbu_db1 WHERE id_us = $id");
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Salidas del almacén</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Bootstrap  v5.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <div class="px-3 py-3">
        <div class="encabesado text-white p-2">
            <h1 class="titulo">Solicitud de herramientas</h1>
        </div>
    </div>
    <div class="aside1">
        <div class="contenedor bg-dark text-white" style="border-left: #48C9B0 7px solid;">
            <div class="aside ">
                <form>
                    <img src="img/documents.png" alt=""><!-- from. Realizar una solicitud -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre :</label>
                            <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Juan, Luis Javier...">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cantidad">Apellidos:</label>
                            <input type="text" class="form-control form-control-sm" id="ap" placeholder="Hernández López">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="cantidad">N° Empleado:</label>
                            <input type="number" class="form-control form-control-sm" id="n_empleado" maxlength="5" min="1">
                        </div>
                    </div>
                    <input type="submit" value="Siguiente" class="btn btn-outline-info btn-sm" onclick="subirsolicitud(event)">
                    <a class="btn btn-outline-danger btn-sm" href="pagina_principal.php" role="button">Cancelar</a>
                    <div id="cargar"></div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Javascript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-----------  CDN JQuery  ----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-----------  CDN swal(sweatalert)  ------------->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>

</html>