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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Bodega</title>
    <link rel="shortcut icon" href="img/pie-chart.png">
    <link rel="stylesheet" href="css/styles.css">
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
    <main class="px-3 py-3">
        <header class="encabesado  text-white p-2">
            <h1 class="text-center">Herramientas Agotadas</h1>
        </header>
        <div class="d-flex justify-content-end p-2"> 
            <a class="btn btn-danger btn-sm" type="button" href="php/reporte_herramientas_agotadas.php" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
        </div>
        <section class="py-2 d-flex justify-content-center">
            <div class="tb table-responsive">
            <?php
                include("php/abrir_conexion.php");// conexion con la BD
                $resultados = mysqli_query($conexion,"SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo,h.cantidad_minima,h.cantidad,h.fecha_hora FROM $tbherr_db7 h inner join categorias c on h.id_categoria = c.id_categoria inner join gavilanes g on h.id_gavilanes = g.id_gav inner join medidas m on h.id_medidas = m.id_medidas  WHERE cantidad < Cantidad_Minima ORDER BY id_herramienta");
                //Unimos tabla Herramientas con categorias y medidas
            ?>
                        <table class="table table-striped table-dark">
                            <thead class="" id="thead">
                                <tr>
                                    <th><center>id</center></th>
                                    <th><center>Nombre</center></th>
                                    <th>Material</th>
                                    <th>Descripcion</th>
                                    <th><center>Gavilanes</center></th>
                                    <th><center>Ancho</center></th>
                                    <th><center>Largo</center></th>
                                    <th><center>Cantidad</center></th>
                                    <th><center>A Comprar</center></th>
                                </tr>
                            </thead>
                            <?php
                            while($consulta = mysqli_fetch_array($resultados)){
                            ?>
                            <tbody class="body-tb">
                                <tr>
                                    <td><center><?php echo $consulta['id_herramienta']?></center></td>
                                    <td><center><?php echo $consulta['Nombre']?></center></td>
                                    <td><?php echo $consulta['material']?></td>
                                    <td><?php echo $consulta['descripcion']?></td>
                                    <td><center><?php echo $consulta['Num_gavilanes']?></center></td>
                                    <td><center><?php echo $consulta['Ancho']?></center></td>
                                    <td><center><?php echo $consulta['Largo']?></center></td>
                                    <td><center><?php echo $consulta['cantidad']?></center></td>
                                    <td><center><?php echo $consulta['cantidad_minima']-$consulta['cantidad']?></center></td>
                                </tr>
                            </tbody>
                            <?php
                        }?>
                    </table><br>
                    <?php
                    include("php/cerrar_conexion.php");
                    ?>
            </div>
        </section>
    </main>
    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <script src="js/app.js"></script>
</body>
</html>