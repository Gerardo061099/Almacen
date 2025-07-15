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
    <title>Agregar Usuarios</title>
    <link rel="shortcut icon" href="img/add_user.png">
    <!-- Bootstrap  v5.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <!-- Icons Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.0/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.css" rel="stylesheet" integrity="sha384-eZlplTHZHKCt8IkuN6tjrGBm+++iLYntms+lz6jkOUakaxdmjKxQswceH1LbirZr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-dark bg-dark ">
            <article class="container">
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
                    <button class="btn btn-dark" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="pagina_principal.php"><i class="fa-solid fa-house"></i> Inicio</a>
                        <?php
                        if ($_SESSION['usuario'] == "@admin06") {
                            echo "<a class='dropdown-item active' href='#'><i class='fa-solid fa-user-gear'></i> Administrar usuarios</a>";
                        }
                        ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a>
                    </div>
                </div>
            </article>
        </nav>
    </header>
    <main class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="pagina_principal.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Usuarios</li>
            </ol>
        </nav>
        <article>
            <!-- Modal -->
            <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal_title"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="frm_add_user">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nombre_u">Nombre</label>
                                        <input type="text" class="form-control form-control-sm" id="nombre_u">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="apellidos_u">Apellidos</label>
                                        <input type="text" class="form-control form-control-sm" id="apellidos_u">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email_u">Email</label>
                                        <input type="text" class="form-control form-control-sm" id="email_u" placeholder="1234 Main St">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pass_u">Password</label>
                                        <input type="password" class="form-control form-control-sm" id="pass_u" placeholder="**********">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="num_e">N° Empleado</label>
                                        <input type="number" class="form-control form-control-sm" id="num_e" min="1">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="estado_u">State</label>
                                        <select id="estado_u" class="form-control form-control-sm">
                                            <option selected>Choose...</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">Show Password</label>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary btn-sm me-1" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary btn-sm" id="btn-action">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <section class="card">
            <article class="card-header">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light btn-sm" id="btn_open_modal"><i class="bi bi-person-plus"></i></button>
                </div>
            </article>
            <article class="card-body">
                <table class="table table-striped table-dark table-hover px-1" id="tabla_usuarios">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">N° empleado</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">N° empleado</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </article>
        </section>
    </main>
    <!--
    <footer class="w-100 h-100 " style="background-color: aliceblue;">
        ALUXSA S.A DE C.V Todos los Derechos Reservados
    </footer>
        -->
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Javascript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <!-- DataTables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.3.0/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.js" integrity="sha384-qjhFxzk66oKUXIYCVboqAL4Rltw1UDdDP5IHbsgDdH83uVKkvB+fFOwJcm9P7Nwb" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!--CDN swal(sweatalert)-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="module" src="js/tabla_usuarios.js"></script>
</body>

</html>