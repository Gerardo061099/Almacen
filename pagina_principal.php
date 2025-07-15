<?php
//importante
session_start();
include "php/abrir_conexion.php";
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $queryUser = mysqli_query($conexion, "SELECT u.user AS user,r.nombre_role AS roleUser FROM $tbu_db1 u INNER JOIN $roles r ON u.id_role = r.id WHERE u.id_us = $id");
    $result = mysqli_fetch_assoc($queryUser);
    $user = null;
    if (mysqli_num_rows($queryUser) > 0) {
        $user = $result;
        $_SESSION['usuario'] = $user['user'];
        $_SESSION['roleUser'] = $user['roleUser'];
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
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="shortcut icon" href="img/pie-chart.png">
    <link rel="apple-touch-icon" href="img/pie-chart.png">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
</head>

<body class="pag" onload="mueveReloj()">
    <!-- Image and text -->
    <nav class="navbar navbar-dark bg-dark">
        <article class="container">
            <div class="navbar-brand">
                ALUXSA S.A de C.V
            </div>
            <form name="form_reloj">
                <input type="text" name="reloj" size="10" onfocus="window.document.form_reloj.reloj.blur()" style="background-color : #283747; color : White; font-family : Verdana, Arial, Helvetica; font-size : 12pt; text-align : center;">
            </form>
            <div class="dropdown d-flex align-items-center pr-4">
                <div class="px-2">
                    <img src="img/login_profile_user.png" alt="">
                </div>
                <p class="mb-0 px-1">
                    <span class="text-white"><?php echo $_SESSION['usuario']; ?></span>
                </p>
                <div class="btn-group">
                    <button class="btn btn-dark btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li><a class="dropdown-item active" href="#"><i class="fa-solid fa-house"></i> Inicio</a></li>
                        <?php
                        if ($_SESSION['roleUser'] == "Administrador") {
                            echo "<li><a class='dropdown-item' href='add_user.php'><i class='fa-solid fa-user-gear'></i> Administrar usuarios</a></li>";
                        }
                        ?>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a></li>
                    </ul>
                </div>
            </div>
        </article>
    </nav>
    <main class="container">
        <nav style="--bs-breadcrumb-divider: '>'; color: white;" aria-label="breadcrumb" class=" mt-3 m-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Dashboard</li>
            </ol>
        </nav>
        <div class="row row-cols-1 row-cols-md-3 g-2">
            <div class="col">
                <div class="card text-white bg-dark mb-3" id="" style="max-width: 18rem;">
                    <div class="card-header text-center">Herramientas</div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Lista de herramientas</h5>
                        <p class="card-text">
                            <center><a href="inventario.php"><img src="img/drilling.png" alt=""></a></center>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" id="" style="max-width: 18rem;">
                    <div class="card-header text-center">Reportes</div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Herramientas agotadas</h5>
                        <p class="card-text">
                            <center><a href="herramienta_agotada.php"><img src="img/report.png" alt=""></center></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" id="" style="max-width: 18rem;">
                    <div class="card-header text-center">Salidas del almacén</div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Salidas del almacén</h5>
                        <p class="card-text">
                            <center><a href="salidas_almacen.php"><img src="img/out.png" alt=""></center></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" id="" style="max-width: 18rem;">
                    <div class="card-header text-center">Registro de factura</div>
                    <div class="card-body">
                        <h5 class="card-title text-center">Compras</h5>
                        <p class="card-text">
                            <center><a href="registro_facturas.php"><img src="img/invoice.png" alt=""></center></a>
                        </p>
                    </div>
                </div>
            </div>
            <?php
            if ($_SESSION['roleUser'] == "Administrador") {
                echo "
                    <div class='col'>
                        <div class='card text-white bg-dark mb-3' id='' style='max-width: 18rem;'>
                            <div class='card-header text-center'>Usuarios</div>
                            <div class='card-body'>
                                <h5 class='card-title text-center'>Gestion de usuarios</h5>
                                <p class='card-text'>
                                    <center><a href='add_user.php'><img src='img/user-interface.png' alt=''></center></a>
                                </p>
                            </div>
                        </div>
                    </div>";
            }
            ?>

        </div>
    </main>

    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Javascript Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="js/reloj.js"></script>
</body>

</html>