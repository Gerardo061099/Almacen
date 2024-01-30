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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body style="background: #17202A;">
    <header>
        <nav class="navbar navbar-dark bg-dark ">
            <div class="navbar-brand" >
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
                    <a class="dropdown-item" href="#"><i class="fa-solid fa-user-plus"></i> Agregar usuario</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="px-3 py-3">
        <header class="encabesado text-white p-2">
            <h3 class="text-center">Agregar Usuario</h3>
        </header>
        <article class="p-2">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-dark" id="btn_open_modal"><i class="fa-regular fa-square-plus"></i></button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal_title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="frm_add_user">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre_u">Nombre</label>
                                        <input type="text" class="form-control form-control-sm" id="nombre_u">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="apellidos_u">Apellidos</label>
                                        <input type="text" class="form-control form-control-sm" id="apellidos_u">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email_u">Email</label>
                                        <input type="text" class="form-control form-control-sm" id="email_u" placeholder="1234 Main St">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="pass_u">Password</label>
                                        <input type="password" class="form-control form-control-sm" id="pass_u" placeholder="**********" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="num_e">N° Empleado</label>
                                        <input type="number" class="form-control form-control-sm" id="num_e" min="1">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="estado_u">State</label>
                                        <select id="estado_u" class="form-control form-control-sm">
                                            <option selected>Choose...</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="gridCheck">
                                        <label class="form-check-label" for="gridCheck">Show Password</label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <section class="rounded py-3 px-2 bg-dark table-responsive">
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
        </section>
    </main>
    <!--
    <footer class="w-100 h-100 " style="background-color: aliceblue;">
        ALUXSA S.A DE C.V Todos los Derechos Reservados
    </footer>
        -->
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--CDN swal(sweatalert)-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>

    <script type="module" src="js/tabla_usuarios.js"></script>
</body>
</html>