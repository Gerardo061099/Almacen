<?php
//importante
session_start();
include("php/abrir_conexion.php");
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
    <title>Registro de nuevas herramientas</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">


</head>

<body style="background: #17202A;">
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <main class="p-3">
        <div class="box-1 p-2">
            <div class="encabesado text-white p-2">
                <h1 class="text-center">Registro de medidas</h1>
            </div>
        </div>
        <div class="aside1 d-flex justify-content-center p-2">
            <div class="contenedor" style="border-top: #5DADE2 7px solid;">
                <div class="aside">
                    <form enctype="multipart/form-data">
                        <h3 class="text-center">Medidas:</h3>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="ancho">Ancho:</label>
                                <input type="text" class="form-control form-control-sm" id="ancho" required>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="unidad_ancho">Unidad de medida:</label>
                                <select class="form-control form-control-sm" id="unidad_ancho" required>
                                    <option selected> Choose option...</option>
                                    <option value="in">pulgadas</option>
                                    <option value="mm">milimetros</option>
                                </select>
                            </div>
                        </div>
                        <article class="form-row">
                            <div class="form-group col-md-5">
                                <label for="largo">Largo:</label>
                                <input type="text" class="form-control form-control-sm" id="largo" required>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="unidad_largo">Unidad de medida:</label>
                                <select class="form-control form-control-sm" id="unidad_largo" required>
                                    <option selected> Choose option...</option>
                                    <option value="in">pulgadas</option>
                                    <option value="mm">milimetros</option>
                                </select>
                            </div>
                        </article>
                        <input type="submit" value="Agregar" class="btn btn-block btn-outline-success btn-sm" onclick="medidas(event)">
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>