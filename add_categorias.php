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
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/copy.png">
    <title>Registro de nuevas herramientas</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
</head>
<body style="background: #17202A;">
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="registro_h.php">
            <img src="img/back.png" alt="sin respuesta">
        </a>
        <a class="navbar-brand" href="#">
        ALUXSA S.A de C.V
        </a>
    </nav>
    <center>
        <div class="box-1" style="border-top: #DC7633 7px solid;">
            <div class="encabesado">
                <h1 class="titulo">Registro de Categorías</h1>
            </div>
        </div>
        <div class="aside1">
                <div class="contenedor" style="border-top: #5DADE2 7px solid;">
                    <div class="aside">
                        <form enctype="multipart/form-data">
                        <h1>Categorias:</h1>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="ancho">Descripcion:</label>
                                    <input type="text" class="form-control" id="desc">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="largo">Material:</label>
                                    <input type="text" class="form-control" id="material">
                                </div>
                            </div>
                            <input type="submit" value="Agregar" class="btn btn-outline-primary" onclick="addcategorias(event)">
                            <div id="cargando"></div>
                        </form>
                    </div>
                </div>
        </div>
        <nav aria-label="Page navigation example" style="margin: 10px 10px;">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="registro_h.php">Volver</a>
                </li>
            </ul>
        </nav>
    </center>
    <script src="js/categorias.js"></script>
</body>
</html>