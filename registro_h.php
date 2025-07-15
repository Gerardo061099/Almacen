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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
</head>

<body style="background: #17202A;">
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <header class="px-3 py-3">
        <div class="encabesado text-white p-2 text-center">
            <h3 class="">Registro de Herramientas</h3>
        </div>
    </header>
    <main class="d-flex justify-content-around flex-wrap px-3 py-3">
        <article class="contenedor w-auto h-25 bg-dark text-white p-2 mb-2" style="border-left: #5DADE2 7px solid;">
            <div class="">
                <form enctype="multipart/form-data">
                    <h2 class="text-center">Registrar</h2>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Cortador, Broca, Machuelo, Avellanador...">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cantidad">Stock:</label>
                            <input type="number" class="form-control form-control-sm" id="cantidad" name="cantidad1" placeholder="Stock...">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cantidadm">Stock (minimo):</label>
                            <input type="number" class="form-control form-control-sm" id="cantidadm" name="cantidad2" placeholder="Stock minimo">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="gavilanes">Gavilanes:</label>
                            <select id="gavilanes" class="form-control form-control-sm">
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="medidas">Medidas:</label>
                            <select id="medidas" class="form-control form-control-sm">
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="categoria">Categoria:</label>
                            <select id="categoria" class="form-control form-control-sm">
                                <option selected>Choose...</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="subir_imagen">Nomenclatura: img.jpg</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="subir_imagen" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="subir_imagen">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="add_categorias.php" type="submit" class="btn btn-dark btn-sm"><i class="fa-solid fa-circle-plus"></i> Categoria</a>
                    <a href="add_medidas.php" type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Medidas</a>
                    <input type="submit" value="Hecho" class="btn btn-success btn-sm" onclick=obtener(event)>
                    <button type="button" class="btn btn-danger btn-sm" onclick="borrar(event)"><i class="fa-solid fa-trash"></i></button>
                    <div id="load1" style="color: black; font-size: 20px;"></div>
                </form>
            </div>
        </article>
        <article class="bg-dark w-50 h-auto p-2 rounded">
            <div class="w-100">
                <header class="text-white text-center w-100 p-2">
                    <h4>Preview de la imagen</h4>
                </header>
                <div class="d-flex justify-content-center w-100 p-2" id="contenedor_img">
                    <div class="w-50 h-50 p-2">
                        <img class="rounded img-fluid img-thumbnail" id="etiquetaIMG" src="" alt="">
                    </div>
                </div>
                <div class="p-2 h-auto w-100 text-justify" id="datos_img">
                    <p class="text-white w-100 text-justify" id="nombre_img"></p>
                    <p class="text-white w-100 text-justify" id="tamaño_img"></p>
                    <a id="link_diss_img" href="https://www.iloveimg.com/es/comprimir-imagen/comprimir-jpg" target="_blank" hidden> Baja la calidad de la imagen aquí</a>
                </div>
            </div>
        </article>
    </main>
    <!--  -->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <!--  -->
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!--  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!---->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!---->
    <script src="js/customFile.js"></script>
    <script src="js/eliminar.js"></script>
    <script src="js/img.js"></script>
    <script src="js/app.js"></script>
    <script src="js/funciones_registro_h.js" type="module"></script>
</body>

</html>