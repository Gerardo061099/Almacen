<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuarios</title>
    <link rel="shortcut icon" href="img/add_user.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
</head>
<body style="background: #17202A;">
    <?php
        session_start();
        ob_start();
            if (isset($_POST['btn1'])) {
                $_SESSION['sesion']=0;//No a inisiado sesion
                $mail = $_POST['user'];
                $pwd = $_POST['pass'];
                if ($mail == "" || $pwd == "") {//Revisamos si algun campo está vacio
                    $_SESSION['sesion']=2;
                }
                else{
                    include("php/abrir_conexion.php");
                    $_SESSION['sesion']=3;
                    $resultado = mysqli_query($conexion,"SELECT * FROM $tbu_db1 WHERE user = '$mail' AND pass = PASSWORD('$pwd')");
                    while($consulta = mysqli_fetch_array($resultado)){
                        //echo "Bienvenido ".$consulta['user']." has iniciado sesion";
                        $_SESSION['sesion']=1;
                    }
                    include("php/cerrar_conexion.php");
                }
            }
            if ($_SESSION['sesion']<>1) {
                header("Location:index.php");
            }
    ?>
    <header>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="pagina_principal.php">
                ALUXSA S.A de C.V
            </a>
        </nav>
    </header>
    <main class="px-3 py-3">
        <header class="box-1">
            <div class="encabesado">
                <h1 class="titulo">Agregar Usuario</h1>
            </div>
        </header>
        <article class="d-felx">
            <div class=" justify-content-start">
                <button type="button" class="btn btn-dark" id="btn_open_modal"><i class="fa-regular fa-square-plus"></i></button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nombre_u">Nombre</label>
                                        <input type="text" class="form-control" id="nombre_u">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="contraseña_u">Apellidos</label>
                                        <input type="password" class="form-control" id="contraseña_u">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="num_e">N° Empleado</label>
                                    <input type="text" class="form-control" id="num_e">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email_u">Email</label>
                                        <input type="email" class="form-control" id="email_u" placeholder="1234 Main St">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZip">Zip</label>
                                        <input type="text" class="form-control" id="inputZip">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        Check me out
                                    </label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary btn-sm">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <section class="rounded py-3 px-2 bg-light">
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
    <footer class="w-100 h-100 " style="background-color: aliceblue;">
        ALUXSA S.A DE C.V Todos los Derechos Reservados
    </footer>

    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!--CDN swal(sweatalert)-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    
    <script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>
    <script type="module" src="js/tabla_usuarios.js"></script>
</body>
</html>