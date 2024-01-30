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
    <title>Registro de Salidas del almacen</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <!-- libreria JQuery--->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body style="background: #17202A;">
    <!-- Image and text -->
    <nav class="navbar sticky-top navbar-dark bg-dark">
        <a class="navbar-brand" href="pagina_principal.php">
            ALUXSA S.A de C.V
        </a>
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
    <div class="p-3">
        <div class="encabesado p-2 text-white">
            <h3 class="text-center">Solicitud de herramientas</h3>
        </div>
    </div>
    <div class="container">
        <div class="contenedor text-white bg-dark" style="border-left: #48C9B0 7px solid;">
            <div class="aside">
                <form id="frm-herramientas-outside">
                    <header class="d-flex justify-content-center">
                        <img src="img/documents.png" alt=""><!-- from. Realizar una solicitud -->
                    </header>
                    <div class="form-row">
                        <h5 class="col-12 text-center">Informacion de la herramienta</h5>
                        <div class="col-6 col-sm-4 col-md-3">
                            <label for="herramienta">Herramienta:</label>
                            <select class="form-control form-control-sm" id="herramienta">
                                <option selected>Choose...</option>
                                <?php
                                    include("php/abrir_conexion.php");
                                    $consulta = mysqli_query($conexion,"SELECT Nombre FROM $tbherr_db7 GROUP BY Nombre");
                                    while ($res = mysqli_fetch_array($consulta)) {
                                        echo '<option value='.$res['Nombre'].'>'.$res['Nombre'].'</option>';
                                    }
                                    include("php/cerrar_conexion.php");
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
                        <div class="form-group col-8 col-sm-5 col-md-4">
                            <label for="maquina">Maquina:</label>
                            <select class="form-control form-control-sm" id="maquina">
                                <option selected>Choose...</option>
                                <?php
                                    include("php/abrir_conexion.php");
                                    $con = mysqli_query($conexion,"SELECT id_Maquinaria,Nombre FROM $tbmaq_db8");
                                    while ($resul = mysqli_fetch_array($con)){
                                        echo '<option value='.$resul['id_Maquinaria'].'>'.$resul['Nombre'].'</option>';
                                    }
                                    include("php/cerrar_conexion.php");
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-4 col-sm-4 col-md-2">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" class="form-control form-control-sm" id="cantidad" min="1" >
                        </div>
                    </div>
                    <input type="submit" value="Registrar" class="btn btn-outline-success btn-sm" onclick="RegistrarSoli(event)">
                    <a class="btn btn-outline-primary btn-sm" href="salidas_almacen.php" role="button" id="btn-finalizar" hidden>Finalizar</a>
                    <div class="mt-2">
                        <input type="hidden" id="id-herramienta">
                    </div>
                    <div id="load"></div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
    <script src="js/funciones_solicitud.js"></script>
</body>
</html>