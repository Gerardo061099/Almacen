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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herramientas</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesBootstrap.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body style="background: #17202A;">
    <!-- Image and text -->
    <nav class="navbar sticky-top headline navbar-dark bg-dark ">
        <div class="navbar-brand">
            ALUXSA S.A de C.V
        </div>
        <div class="dropdown d-flex align-items-center pr-4">
            <div class="px-2">
                <img src="img/login_profile_user.png" alt="">
            </div>
            <p class="mb-0 px-1">
                <span class="text-white"><?php echo $_SESSION['usuario']; ?></span>
            </p>
            <button class="btn btn-dark btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
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
    <main class="px-3 py-3">
        <header class="encabesado p-2 text-white">
            <h1 class=" text-center">Facturas de productos entrantes.</h1>
        </header>
        <section class="container mt-3">
            <article class="d-flex justify-content-center">
                <div class="card text-white bg-dark mb-3" style="max-width: 28rem;">
                    <div class="card-header">Agrega los datos de la factura</div>
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-4 col-md-4">
                                    <label for="n_factura">N° Factura: </label>
                                    <input type="text" class="form-control form-control-sm" id="n_factura" placeholder="Solo numeros" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a type="button" class="btn btn-success btn-sm mr-2" id="btn_agregar" href="#info_factura">Agregar</a>
                                <a type="button" class="btn btn-danger btn-sm" id="btn_eliminar" href="#info_factura">Eliminar registro</a>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-9">
                                    <label for="articulo">Descripcion del articulo: </label>
                                    <input type="text" class="form-control form-control-sm" id="articulo" required>
                                </div>
                                <div class="form-group col-4 col-md-3">
                                    <label for="cantidad">Cantidad: </label>
                                    <input type="number" class="form-control form-control-sm" id="cantidad" min="1" placeholder="solo numeros" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-4 col-md-4">
                                    <label for="v_unitario">Valor unitario: </label>
                                    <input type="text" class="form-control form-control-sm" id="v_unitario" placeholder="$84.00" required>
                                </div>
                                <div class="form-group col-4 col-md-4">
                                    <label for="importe">Importe: </label>
                                    <input type="text" class="form-control form-control-sm" id="importe" placeholder="$164.15" required>
                                </div>
                                <div class="form-group col-4 col-md-4">
                                    <label for="fecha">Fecha: </label>
                                    <input type="date" class="form-control form-control-sm" id="fecha" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-sm" id="btn_insert">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </article>
            <table class="table table-dark table-bordered" id="info_factura">
                <thead>
                    <tr>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Articulo</th>
                        <th scope="col">Precion unitario</th>
                        <th scope="col">Importe</th>
                    </tr>
                </thead>
                <tbody id="body_tb_factura">
                </tbody>
            </table>
        </section>
    </main>



    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="js/getCategoria.js"></script>
    <script src="assets/facturas.js" type="module"></script>
</body>

</html>