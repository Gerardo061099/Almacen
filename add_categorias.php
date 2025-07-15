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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body style="background: #17202A;">
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <main class="p-3">
        <header class="encabesado text-white p-2">
            <h1 class="titulo">Registro de Categorías</h1>
        </header>
        <section class="aside1 py-2 w-100 d-flex justify-content-center ">
            <div class="contenedor" style="border-top: #5DADE2 7px solid;">
                <div class="aside">
                    <form enctype="multipart/form-data">
                        <h3 class="text-center ">Agrega una categoria</h3>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="desc">Descripcion:</label>
                                <input type="text" class="form-control form-control-sm" id="desc">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="material">Material:</label>
                                <input type="text" class="form-control form-control-sm" id="material">
                            </div>
                        </div>
                        <input type="submit" value="Agregar" class="btn btn-outline-primary btn-sm" onclick="addcategorias(event)">
                        <div id="cargando"></div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!--  -->
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!--  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!---->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="js/categorias.js"></script>
</body>

</html>