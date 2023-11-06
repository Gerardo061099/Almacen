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
    <title>Registro de nuevas herramientas</title>
    <link rel="shortcut icon" href="img/copy.png">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
</head>
<body style="background: #17202A;">
    <nav class="navbar navbar-dark bg-dark">
        <div class="navbar-brand">
            ALUXSA S.A de C.V
        </div>
        <div class="dropdown d-flex align-items-center pr-4">
            <div class="px-2">
                <img src="img/login_profile_user.png" alt="">
            </div>
            <p class="mb-0 px-1">
                <span class="text-white"><?php echo $_SESSION['usuario'];?></span>
            </p>
            <button class="btn btn-dark" type="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="pagina_principal.php"><i class="fa-solid fa-house"></i> Inicio</a>
                <a class="dropdown-item" href="add_user.php"><i class="fa-solid fa-user-plus"></i> Agregar usuario</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a>
            </div>
        </div>
    </nav>
    <div class="box-1 px-3 py-3">
        <div class="encabesado" style="border-top: #DC7633 7px solid;">
            <h1 class="titulo">Registro de Herramientas</h1>
        </div>
    </div>
    <main class="d-flex justify-content-around px-3 py-3">
        <article class="contenedor w-auto h-25" style="border-top: #5DADE2 7px solid;">
            <div class="">
            <form enctype="multipart/form-data">
                <h1 class="text-center">Registrar:</h1>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Cortador, Broca, Machuelo, Avellanador...">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="cantidad">Stock:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad1" placeholder="Stock...">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cantidadm">Stock (minimo):</label>
                            <input type="number" class="form-control" id="cantidadm" name="cantidad2" placeholder="Stock minimo">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="gavilanes">Gavilanes:</label>
                                <select id="gavilanes" class="form-control">
                                    <option selected>Choose...</option>
                                </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="medidas">Medidas:</label>
                                <select id="medidas" class="form-control">
                                    <option selected>Choose...</option>
                                </select>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="categoria">Categoria:</label>
                            <select id="categoria" class="form-control">
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
                    <a href="add_categorias.php" type="submit" class="btn btn-dark"><img src="img/plus-withe.png" alt="sin resultados"> Categoria</a>
                    <a href="add_medidas.php" type="submit" class="btn btn-primary"><img src="img/plus-withe.png" alt="sin resultados"> Medidas</a>
                    <input type="submit" value="Hecho" class="btn btn-success" onclick=obtener(event)>
                    <button type="button" class="btn btn-danger"><img src="img/trash-can.png" alt="sin resultados" onclick="borrar(event)"></button>
                    <div id="load1" style="color: black; font-size: 20px;"></div>
                </form>
            </div>
        </article>
        <article class="bg-dark w-25 h-25 p-2 rounded">
            <header class="text-white text-center p-3"><h4>Preview de la imagen</h4></header>
            <div class="d-flex justify-content-center p-2" id="contenedor_img">
                <img class="rounded w-100" id="etiquetaIMG" src="" alt="">
            </div>
            <div class="p-2 h-auto text-justify" id="datos_img">
                <p class="text-white h-auto w-100" id="nombre_img"></p>
                <p class="text-white w-100 text-justify" id="tamaño_img"></p>
                <a id="link_diss_img" href="https://www.iloveimg.com/es/comprimir-imagen/comprimir-jpg" hidden> Baja la calidad de la imagen aquí</a>
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
    <script src="js/funciones_registro_h.js" type="module" ></script>
</body>
</html>