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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Bodega</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <!-- <link rel="stylesheet" href="css/navbar.css"> -->
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body style="background: #17202A;">
    <!-- Image and text -->
    <nav class="navbar sticky-top navbar-dark bg-dark">
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
    <?php
        include ("php/abrir_conexion.php");
        $consulta = mysqli_query($conexion, "SELECT Count(id_solicitud) AS solicitud FROM $tbdet_db4 where id_solicitud = (SELECT MAX(id_solicitud) FROM $tbdet_db4)");
        $resultado = mysqli_fetch_array($consulta);
        include("php/cerrar_conexion.php");
    ?>
    <main class="box-registros w-100 p-2 d-flex flex-wrap">
        <section class="p-2 w-75">
            <div class="salidas w-100 rounded p-2">
                <div style="background: #FDFEFE;">
                    <h1 class="titulos" style="text-align:left;"><strong>Salidas del almacen</strong></h1>
                </div>
                <div class="tb_h table-responsive">
                    <?php
                        include("php/abrir_conexion.php");// conexion con la BD
                        $resultados = mysqli_query($conexion,"SELECT s.id_solicitud,e.nombre as solicitante,e.apellidos,h.Nombre as herramienta,c.Descripcion,c.Material,g.Num_gavilanes AS Gav,m.Largo,m.Ancho,d.cantidad,s.Fecha from $tbsoli_db10 s inner join $tbdet_db4 d on s.id_solicitud = d.id_solicitud inner join $tbherr_db7 h on d.id_herramientas = h.id_herramienta inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas inner join $tbem_db5 e on s.id_empleado = e.id_empleado ORDER BY s.id_solicitud DESC");
                        //Unimos tabla Herramientas con categorias y medidas
                        echo "
                    <table class=\"table table-dark table-striped table-hover table-sm\" id=\"h\">
                        <thead class=\"\">
                            <tr>
                                <th>Id</th>
                                <th>Solicitante</th>
                                <th>Apellidos</th>
                                <th>Herramienta</th>
                                <th>Descripcion</th>
                                <th>Material</th>
                                <th>Gav</th>
                                <th>Ancho</th>
                                <th>Largo</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody class=\"body-tb\">
                            ";
                            while($consulta = mysqli_fetch_array($resultados)){
                            echo 
                            "
                            <tr>
                                <td>".$consulta['id_solicitud']."</td>
                                <td>".$consulta['solicitante']."</td>
                                <td>".$consulta['apellidos']."</td>
                                <td>".$consulta['herramienta']."</td>
                                <td>".$consulta['Descripcion']."</td>
                                <td>".$consulta['Material']."</td>
                                <td>".$consulta['Gav']."</td>
                                <td>".$consulta['Ancho']."</td>
                                <td>".$consulta['Largo']."</td>
                                <td>".$consulta['cantidad']."</td>
                                <td>".$consulta['Fecha']."</td>
                            </tr>
                            ";
                    ?>
                    <?php
                    }
                    echo "
                        </tbody>";
                    include("php/cerrar_conexion.php");
                    ?>
                    </table>
                </div>
            </div>
        </section>
        <aside class="contenedor_registros w-auto p-2">
            <div class="card text-white bg-primary w-100">
            <div class="card-header">Datos registrados:</div>
                <ul class="list-group list-group-flush">
                <?php
                include ("php/abrir_conexion.php");
                    $query = mysqli_query($conexion, "SELECT Nombre,Apellidos,N_Empleado FROM $tbem_db5 WHERE id_empleado = (SELECT MAX(id_empleado) FROM $tbem_db5)");
                    $resul = mysqli_fetch_array($query);
                ?>
                    <li class="list-group-item active"><img src="img/profile.png" alt="Sin respuesta del servidor"> <?php echo $resul['Nombre']." ".$resul['Apellidos'];?></li>
                    <li class="list-group-item active">N° empleado: <?php echo $resul['N_Empleado'];?></li>
                    <li class="list-group-item active">Stock solicitado: <?php echo $resultado['solicitud'];?> </li>
                </ul>
                <div class="card-footer">
                    <?php
                        $consulta = mysqli_query($conexion, "SELECT MAX(id_solicitud) AS solicitud FROM $tbsoli_db10");
                        $res = mysqli_fetch_array($consulta);
                    ?>
                    N° solicitud: <?php  echo $res['solicitud']; 
                    include('php/cerrar_conexion.php')
                    ?>
                </div>
            </div>
        </aside>
    </main>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="js/app.js"></script>
</body>
</html>