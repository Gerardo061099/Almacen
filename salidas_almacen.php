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
    <title>Salidas del almacen</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <!-- <link rel="stylesheet" href="css/navbar.css"> -->
    <!-- Bootstrap  v5.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- iconos bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <main class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="pagina_principal.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Salidas del almacen</li>
            </ol>
        </nav>
        <section class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card text-white bg-dark mb-3">
                    <header class="card-header d-flex justify-content-between">
                        <h5>Salidas del almacen</h5><button type="button" class="btn btn-primary btn-sm" id="btnShowModal">
                            Registrar Salida
                        </button>
                    </header>
                    <section class="card-body">
                        <table class="display responsive nowrap" width="100%" id="h">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Herramienta</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Gav</th>
                                    <th scope="col">Ancho</th>
                                    <th scope="col">Largo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Herramienta</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Material</th>
                                    <th scope="col">Gav</th>
                                    <th scope="col">Ancho</th>
                                    <th scope="col">Largo</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </tfoot>
                        </table>
                    </section>
                </div>
            </div>
        </section>
        <!-- Modal Resgistro Empleado Salias-->
        <div class="modal fade" id="modalSalidas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id=""><i class="bi bi-person-vcard"></i> Datos del solicitante</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm-solicitante">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Juan, Luis Javier...">
                                </div>
                                <div class="col-md-6">
                                    <label for="cantidad">Apellidos:</label>
                                    <input type="text" class="form-control form-control-sm" id="ap" placeholder="Hernández López">
                                </div>
                                <div class="col-md-4">
                                    <label for="cantidad">N° Empleado:</label>
                                    <input type="number" class="form-control form-control-sm" id="n_empleado" maxlength="5" min="1">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btnGuardar">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Registro herramienta Salidas -->
        <div class="modal fade" id="modalHerramienta" tabindex="-1" aria-labelledby="modalHerramienta">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Informacion de las herramientas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm-herramientas-outside">
                            <div class="row g-3 mb-3">
                                <div class="col-6 col-sm-4 col-md-3">
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
                                <div class="col-12 col-sm-8 col-md-6" id="categoria" hidden>
                                    <label for="categorias">Categoria:</label>
                                    <select class="form-control form-control-sm" id="categorias">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                                <div class="col-7 col-sm-4 col-md-3" id="medida" hidden>
                                    <label for="medidas">Medidas:</label>
                                    <select class="form-control form-control-sm" id="medidas">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                                <div class="col-5 col-sm-3 col-md-2" id="gavilan" hidden>
                                    <label for="gavilanes">Gavilanes:</label>
                                    <select class="form-control form-control-sm" id="gavilanes">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                                <div class="form-group col-4 col-sm-4 col-md-2">
                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number" class="form-control form-control-sm" id="cantidad" min="1">
                                </div>
                            </div>
                            <table class="table table-striped table-hover table-sm" id="tableResumen">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Herramienta</th>
                                        <th scope="col">Descripcion</th>
                                        <th scope="col">Material</th>
                                        <th scope="col">Gav</th>
                                        <th scope="col">Dimenciones</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <input type="hidden" id="id-herramienta">
                            </div>
                            <div id="load"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalSalidas">Regresar</button>
                        <button type="button" class="btn btn-primary btn-sm" id="registrarSolicitud">Registrar</button>
                        <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal" id="finalizar">Finalizar Registro</button>
                    </div>
                </div>
            </div>
        </div>
        <aside class="row">
            <div class="col-8 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                <div class="card text-white bg-primary w-100 mb-3">
                    <header class="card-header">Datos registrados</header>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item active"><img src="img/profile.png" alt="Sin respuesta del servidor">
                            <span id="nombre_empleado"></span>
                        </li>
                        <li class="list-group-item active">N° empleado: <span id="num_e"></span>
                        </li>
                        <li class="list-group-item active">Stock solicitado: <span id="stocks_req"></span>
                        </li>
                    </ul>
                    <div class="card-footer">
                        N° de solicitud <span id="n_req"></span>
                    </div>
                </div>
            </div>
        </aside>
    </main>

    <!----------- CDN swal(sweatalert)-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!----------- CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!---------- Javascript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!---------- CDN DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.js"></script>
    <!---------- Scripts or fuctions -->
    <script src="assets/salidas_table.js" type="module"></script>
    <script src="js/funciones_solicitud.js"></script>
</body>

</html>