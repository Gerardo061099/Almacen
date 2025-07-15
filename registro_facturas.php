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
    <!-- Bootstrap  v5.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Icons Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/sp-2.3.3/datatables.min.css" rel="stylesheet" integrity="sha384-FryOG7wb1fNDidyiPqbwQgRj/+m5ZZ0cesQMDICzuKOaOzM/M6tEjRRiXo9tHFIi" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesBootstrap.css">
</head>

<body>
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <main class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="pagina_principal.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Facturas</li>
            </ol>
        </nav>
        <section class="card text-bg-dark mt-3 mb-3 w-100">
            <div class="card-header">
                <ul class="nav nav-underline" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-white active" id="home-tab" data-bs-toggle="tab" data-bs-target="#add_fact" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Registrando factura</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#show_fact" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Ultima Factura Registrada</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#others_facts" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Otras facturas</button>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active text-white mt-3" id="add_fact" role="tabpanel" aria-labelledby="home-tab">
                    <article class="d-flex justify-content-center">
                        <div class="card text-white bg-dark mb-3" style="max-width: 28rem;">
                            <div class="card-body">
                                <form id="frm-facturas">
                                    <div class="row g-3">
                                        <div class="col-4">
                                            <label for="n_factura">N° Factura: </label>
                                            <input type="text" class="form-control form-control-sm" id="n_factura" placeholder="Solo numeros" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="fecha">Fecha: </label>
                                            <input type="date" class="form-control form-control-sm" id="fecha" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="herramienta">Herramienta:</label>
                                            <select class="form-control form-control-sm" id="herramienta">
                                                <option selected>Choose...</option>
                                                <?php
                                                include "php/abrir_conexion.php";
                                                $consulta = mysqli_query($conexion, "SELECT Nombre FROM $tbherr_db7 GROUP BY Nombre");
                                                while ($res = mysqli_fetch_array($consulta)) {
                                                    echo '<option value=' . $res['Nombre'] . '>' . $res['Nombre'] . '</option>';
                                                }
                                                include "php/cerrar_conexion.php";
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12" id="categoria" hidden>
                                            <label for="categorias">Categoria:</label>
                                            <select class="form-control form-control-sm" id="categorias">
                                                <option selected>Choose...</option>
                                            </select>
                                        </div>
                                        <div class="col-7" id="medida" hidden>
                                            <label for="medidas">Medidas:</label>
                                            <select class="form-control form-control-sm" id="medidas">
                                                <option selected>Choose...</option>
                                            </select>
                                        </div>
                                        <div class="col-5" id="gavilan" hidden>
                                            <label for="gavilanes">Gavilanes:</label>
                                            <select class="form-control form-control-sm" id="gavilanes">
                                                <option selected>Choose...</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="cantidad">Cantidad: </label>
                                            <input type="number" class="form-control form-control-sm" id="cantidad" min="1" placeholder="solo numeros" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="v_unitario">Valor unitario: </label>
                                            <input type="text" class="form-control form-control-sm" id="v_unitario" placeholder="$84.00" required>
                                        </div>
                                        <div class="col-4">
                                            <label for="importe">Importe: </label>
                                            <input type="text" class="form-control form-control-sm" id="importe" placeholder="$164.15" required>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a type="button" class="btn btn-success btn-sm me-2 d-block" id="btn_agregar" href="#info_factura">Agregar a la tabla</a>
                                <button type="button" class="btn btn-primary btn-sm" id="btn_insert">Enviar datos</button>
                                <div class="mt-2">
                                    <input type="hidden" id="id-herramienta">
                                </div>
                                </form>
                            </div>
                        </div>
                    </article>
                    <section class="table-responsive">
                        <table class="table table-dark" id="info_factura">
                            <thead>
                                <tr>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Id Art.</th>
                                    <th scope="col">Articulo</th>
                                    <th scope="col">Precio unitario</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="body_tb_factura">
                            </tbody>
                        </table>
                    </section>
                </div>
                <div class="tab-pane fade text-white mt-3 w-100" id="show_fact" role="tabpanel" aria-labelledby="profile-tab">
                    <article>
                        <h5>
                            <p>N° Factura: <span class="badge text-bg-light" id="Numfact"></span> </p>
                            <p>Fecha de la factura: <span class="badge text-bg-light" id="fechaFactura"></span> </p>
                        </h5>
                    </article>
                    <table class="table table-dark display nowrap" width="100%" id="data_factura">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Articulo</th>
                                <th scope="col">Existencia</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Valor unitario</th>
                                <th scope="col">Importe</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-success"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <article class="tab-pane fade text-white " id="others_facts" role="tabpanel" aria-labelledby="">
                    <div class="row g-3">
                        <div class="col-3">
                            <div class="input-group input-group-sm my-3 ms-2 flex-nowrap">
                                <label class="input-group-text" for="yearSelectFilter">Facturas del:</label>
                                <select class="form-select" id="yearSelectFilter">
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group input-group-sm my-3 ms-2">
                                <label class="input-group-text" for="facturasOption">N° Facturas:</label>
                                <select class="form-select" id="facturasOption">
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group input-group-sm my-3 ms-2">
                                <button class="btn btn-primary btn-sm" id="btn_filter" type="button"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <table class="table table-dark display nowrap" width="100%" id="tablaOtrasFacturas">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Articulo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Valor unitario</th>
                                    <th scope="col">Importe</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-success"></th>
                                </tr>
                            </tfoot>
                        </table>
                </article>
            </div>
        </section>
    </main>
    <!-----------Scripts y librerias -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Javascript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-----------DataTables ---------------------->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/sp-2.3.3/datatables.min.js" integrity="sha384-GCHH+EOYKIBGqNBtmw1geYN2F9h829dVWiXDSwSyib0aBsMlBD+HZrHzEyw7rcy5" crossorigin="anonymous"></script>
    <!-- Moment js -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <!----------- scripts  -->
    <script src="js/getCategoria.js"></script>
    <script src="js/funciones_solicitud.js"></script>
    <script src="assets/facturas.js" type="module"></script>
    <script src="js/tableOtrasFact.js" type="module"></script>
</body>

</html>