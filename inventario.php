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
include "php/cerrar_conexion.php";
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
    <!-- Datatables -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/datatables.min.css" rel="stylesheet" integrity="sha384-82g2Ku/PYsKjzsW7eA4hbCXzIcYsdJC7FIcyCjrz4yB8sR3lKcDE4cGhxCuzw3AZ" crossorigin="anonymous">
    <!-- Personal CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/stylesBootstrap.css">
</head>

<body>
    <!-- Image and text -->
    <?php include "nav/navbar.php" ?>
    <main class="container">
        <nav style="--bs-breadcrumb-divider: '>'; color: white;" aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="pagina_principal.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Herramientas</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Listado de herramientas</h5><button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalNewH"><i class="bi bi-plus-square-dotted"></i></button></span>
            </div>
            <div class="card-body">
                <table class="table table-striped table-borderless table-hover table-sm table-dark" id="herramientas">
                    <thead class="sticky-top headtableline thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Material</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Gavilanes</th>
                            <th scope="col">Ancho</th>
                            <th scope="col">Largo</th>
                            <th scope="col">Stock min</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Status</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="body-tb">
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Material</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Gavilanes</th>
                            <th scope="col">Ancho</th>
                            <th scope="col">Largo</th>
                            <th scope="col">Stock min</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Status</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalNewH" tabindex="-1" aria-labelledby="modalNewHLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalNewHLabel">Nueva herramienta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <header>
                            <h5>Registro de una nueva herramienta</h5>
                        </header>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" placeholder="Cortador, Broca, Machuelo, Avellanador...">
                            </div>
                            <div class="col-md-4">
                                <label for="categoria">Categoria:</label>
                                <select id="categoria" class="form-select form-select-sm">
                                    <option selected>Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="medidas">Medidas:</label>
                                <select id="medidas" class="form-select form-select-sm">
                                    <option selected>Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="gavilanes">Gavilanes:</label>
                                <select id="gavilanes" class="form-select form-select-sm">
                                    <option selected>Choose...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="cantidad">Stock:</label>
                                <input type="number" class="form-control form-control-sm" id="cantidad" min="1" name="cantidad1" placeholder="Stock...">
                            </div>
                            <div class="col-md-2">
                                <label for="cantidadm">Stock (minimo):</label>
                                <input type="number" class="form-control form-control-sm" id="cantidadm" min="1" name="cantidad2" placeholder="Stock minimo">
                            </div>
                            <div class="col-md-6">
                                <label for="subir_imagen">Agrega una imagen de referencia:</label>
                                <input class="form-control form-control-sm" type="file" id="subir_imagen">
                            </div>
                        </div>
                        <header>
                            <h5>Visualizacion de la imagen</h5>
                        </header>
                        <main>
                            <section id="section-img"></section>
                            <p id="nombre_img"></p>
                            <p id="tamaño_img"></p>
                            <a id="link_diss_img" href="https://www.iloveimg.com/es/comprimir-imagen" target="_blank" hidden>Debes comprimir la imagen</a>
                        </main>
                        <button type="button" class="btn btn-primary btn-sm" id="createNewTool">Guardar</button>
                        <hr>
                        <main class="row row-cols-1 row-cols-md-3 g-4">
                            <article class="col">
                                <div class="card " style="width: 27rem;">
                                    <header class="card-header">
                                        <h5>Gestion de Medidas</h5>
                                    </header>
                                    <main class="card-body">
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <label for="ancho">Ancho:</label>
                                                <input type="text" class="form-control form-control-sm" id="ancho" required>
                                            </div>
                                            <div class="col-auto">
                                                <label for="unidad_ancho">Unidad de medida:</label>
                                                <select class="form-control form-select form-select-sm" id="unidad_ancho" required>
                                                    <option selected> Choose option...</option>
                                                    <option value="in">pulgadas</option>
                                                    <option value="mm">milimetros</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-auto">
                                                <label for="largo">Largo:</label>
                                                <input type="text" class="form-control form-control-sm" id="largo" required>
                                            </div>
                                            <div class="col-auto">
                                                <label for="unidad_largo">Unidad de medida:</label>
                                                <select class="form-control form-select form-select-sm" id="unidad_largo" required>
                                                    <option selected> Choose option...</option>
                                                    <option value="in">pulgadas</option>
                                                    <option value="mm">milimetros</option>
                                                </select>
                                            </div>
                                        </div>
                                    </main>
                                    <footer class="card-footer">
                                        <section class="d-flex justify-content-end align-items-center">
                                            <button type="button" class="btn btn-success btn-sm" id="btn_add_medida">Agregar</button>
                                            <div id="cargando_medida"></div>
                                        </section>
                                    </footer>
                                </div>
                            </article>
                        </main>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <article class="d-flex flex-wrap my-3">
            <article class="card bg-white text-black me-3" style="width: 18rem;">
                <div class="card-body">
                    <i class="fa-solid fa-circle-info"></i> Detalles
                    <hr>
                    <ul class="ps-0">
                        <li>1.- Avellanadores de carburo: <span id="1" class="badge text-bg-dark"></span></li>
                        <li>2.- Avellanadores <i>HSS</i>: <span id="2" class="badge text-bg-warning"></span></li>
                        <li>3.- Brocas de carburo: <span id="3" class="badge text-bg-dark"></span></li>
                        <li>4.- Brocas <i>HSS</i>: <span id="4" class="badge text-bg-warning"></span></li>
                        <li>5.- Buriles de carburo <span id="5" class="badge text-bg-dark"></span></li>
                        <li>6.- Buriles <i>HSS</i>: <span id="6" class="badge text-bg-warning"></span></li>
                        <li>7.- Cortadores de carburo: <span id="7" class="badge text-bg-dark"></span></li>
                        <li>8.- Cortadores <i>HSS</i>: <span id="8" class="badge text-bg-warning"></span></li>
                        <li>9.- Machuelos de carburo: <span id="9" class="badge text-bg-dark"></span></li>
                        <li>10.- Machuelos <i>HSS</i>: <span id="10" class="badge text-bg-warning"></span></li>
                    </ul>
                </div>
            </article>
            <article class="card bg-danger me-3 " style="width: 22rem;">
                <div class="card-body">
                    <i class="bi bi-patch-exclamation"></i> Sin stock
                    <hr>
                    <ul id="lista-Order-agotadas" class="ps-0">
                    </ul>
                    <div id="linkA"></div>
                </div>
            </article>
            <article class="card bg-warning me-3" style="width: 22rem;">
                <div class="card-body">
                    <i class="bi bi-shield-fill-exclamation"></i> Por debajo del stock minimo
                    <hr>
                    <ul id="lista-Order-stockBajo" class="ps-0">
                    </ul>
                    <div id="linkS"></div>
                </div>
            </article>
        </article>
        <article class="card mb-3">
            <div class="card-body">
                <i class="bi bi-grid-3x2-gap-fill"></i> Articulos
                <hr>
                <aside class="card mb-3" style="width: 15rem;">
                    <div class="card-body">
                        <i class="bi bi-search"></i> Buscar
                        <form id="frm_buscar" class="form-inline">
                            <hr>
                            <div class="form-row align-items-center">
                                <div class="col-12 my-1">
                                    <label for="herra_b">Herramienta:</label>
                                    <select class="form-control form-control-sm" id="herra_b" name="herramienta">
                                        <option selected>Choose...</option>
                                        <?php
                                        include "php/abrir_conexion.php";
                                        $queryH = mysqli_query($conexion, "SELECT nombre FROM $tbherr_db7 GROUP BY nombre");
                                        while ($res = mysqli_fetch_array($queryH)) {
                                            echo '<option value="' . $res['nombre'] . '">' . $res['nombre'] . '</option>';
                                        }
                                        include "php/cerrar_conexion.php";
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 my-1">
                                    <label for="medida_b">Medida:</label>
                                    <select class="form-control form-control-sm" id="medida_b" name="medida">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <button class="btn btn-info btn-sm" type="button" id="btn_buscar"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                                <div id="cargando"></div>
                            </div>
                            <div class="col-12 my-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                    <label class="form-check-label" for="checkAll">
                                        Todas las herramientas
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>
                <main id="main-container-Cards">
                    <div class="row row-cols-1 row-cols-md-3 g-4" id="card-container">
                    </div>
                </main>
            </div>
            <div class=""></div>
        </article>
        <div class="modal fade" id="modal101" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title title-modal"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="frm_update_h" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row g-3 mb-3">
                                <div class="col-md-2">
                                    <label for="idmodal">id: </label>
                                    <input type="text" id="idmodal" class="form-control form-control-sm" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="nombremodal">Nombre:</label>
                                    <input type="text" id="nombremodal" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label for="medidasmodal">Medidas:</label>
                                    <select class="form-select form-select-sm" id="medidasmodal">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-9">
                                    <label for="descripcionmodal">Categoria:</label>
                                    <select class="form-select form-select-sm" id="descripcionmodal">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="gavilanesmodal">Gavilanes:</label>
                                    <select class="form-select form-select-sm" id="gavilanesmodal">
                                        <option selected>Elije el numero de gavilanes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-3">
                                    <label for="stock">Stock:</label>
                                    <input type="text" id="stock" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label for="stockminimo">Stock minimo:</label>
                                    <input type="text" id="stockminimo" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label for="status">Status:</label>
                                    <input type="text" id="status" class="form-control form-control-sm " disabled>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Default file input example</label>
                                        <input class="form-control form-control-sm" type="file" id="file_img" accept="image/png,image/jpg,image/jpeg">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="option">
                            <img src="" class="rounded mx-auto d-block" id="previa" width="400">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success btn-sm btnSendData">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!--  -->
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!-----------CDN Sweet Alert----------------------->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Javascript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/datatables.min.js" integrity="sha384-Qsz/vvFUQ4Klb555rHLCrjX94joA5yzYciiRBCdM86EPgxggPXiD1ARh8hY+XtZI" crossorigin="anonymous"></script>
    <!-- Personal scripts  -->
    <script src="js/tb_herramientas.js" type="module"></script>
    <script src="js/funciones_herramientas.js" type="module"></script>
    <script src="js/buscar_app.js" type="module"></script>
    <script src="js/funciones_Modal_H.js" type="module"></script>
    <script src="js/img.js"></script>
    <script src="js/funciones_registro_h.js" type="module"></script>
</body>

</html>