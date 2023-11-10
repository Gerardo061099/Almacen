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
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body style="background: #17202A;">
    <!-- Image and text -->
    <nav class="navbar sticky-top navbar-dark bg-dark">
        <div class="navbar-brand" href="pagina_principal.php">
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
    <div class="p-3">
        <div class="encabesado text-white text-center p-2">
            <h1 class="">Categorias</h1>
        </div>
        <nav aria-label="breadcrumb" style="margin: 5px 5px; width: 96%;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="pagina_principal.php">Pagina de inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categorias</li>
            </ol>
        </nav>
        <div class="contenido con-cortadores">
            <div class="cortadores">
                <div>
                    <h1 style="text-align: left; margin: 5px 15px;">Cortadores</h1>
                </div>
                <div class="separador"></div>
            <?php
                include("php/abrir_conexion.php");// conexion con la BD
                $resultados = mysqli_query($conexion,"SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo,h.cantidad,h.fecha_hora FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE NOMBRE = 'CORTADOR' ORDER BY h.id_herramienta");
                //Unimos tabla Herramientas con categorias y medidas
                echo "
                    <table class=\"table\" id=\"tb-cortadores\">
                        <thead class=\"thead-dark\">
                            <tr>
                                <th><center>#</center></th>
                                <th><center>Nombre</center></th>
                                <th><center>Material</center></th>
                                <th><center>Descripcion</center></th>
                                <th><center>Gavilanes</center></th>
                                <th><center>Ancho</center></th>
                                <th><center>Largo</center></th>
                                <th><center>Cantidad</center></th>
                                <th><center>Fecha</center></th>
                            </tr>
                        </thead>";
                while($consulta = mysqli_fetch_array($resultados)){
                echo "
                        <tbody class=\"tb-body\">
                            <tr>
                                <td><center>".$consulta['id_herramienta']."</center></td>
                                <td><center>".$consulta['Nombre']."</center></td>
                                <td><center>".$consulta['material']."</center></td>
                                <td><center>".$consulta['descripcion']."</center></td>
                                <td><center>".$consulta['Num_gavilanes']."</center></td>
                                <td><center>".$consulta['Ancho']."</center></td>
                                <td><center>".$consulta['Largo']."</center></td>
                                <td><center>".$consulta['cantidad']."</center></td>
                                <td><center>".$consulta['fecha_hora']."</center></td>
                            </tr>
                        </tbody>";
                }
                include("php/cerrar_conexion.php");
                echo "
                    </table>
                ";
            ?>
            </div>
        </div>
        <?php
        include("php/abrir_conexion.php");
        $consulta = mysqli_query($conexion,"SELECT COUNT(*) as cortadores FROM $tbherr_db7 WHERE Nombre = 'Cortador'");
        while ($resultado = mysqli_fetch_array($consulta)){
            $n_cortadores = $resultado['cortadores'];
        }
        include("php/cerrar_conexion.php");
        ?>
        <div class="informacion_piezas">
            <div class="informacion_p">
            <h1>Numero de Registros por pieza</h1>
                <p>
                    <?php echo '<button type="button" class="btn btn-primary">Cortadores <span class="badge badge-light">'.$n_cortadores.'</span>
                    <span class="sr-only">unread messages</span>
                    </button>'; ?> 
                </p>
                <?php
                include("php/abrir_conexion.php");
                $query = mysqli_query($conexion,"SELECT COUNT(*) as brocas FROM $tbherr_db7 WHERE Nombre = 'Broca'");
                while ($row = mysqli_fetch_array($query)){
                    $n_broca = $row['brocas'];
                }
                ?>
                <p><?php echo '<button type="button" class="btn btn-info">Brocas <span class="badge badge-light">'.$n_broca.'</span><span class="sr-only">unread messages</span></button>'; ?></p>
            </div>
        </div>
    </div>
        <div class="con-cortadores">
            <div class="cortadores">
                <div>
                    <h1 style="text-align: left; margin: 5px 15px;">Brocas</h1>
                </div>
            <div class="separador"></div>
            <?php
                $resultados = mysqli_query($conexion,"SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo,h.cantidad,h.fecha_hora FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE NOMBRE = 'Broca' ORDER BY h.id_herramienta");
                //Unimos tabla Herramientas con categorias y medidas
                echo "
                    <table class=\"table\" id=\"tb-cortadores\">
                        <thead class=\"thead-dark\">
                            <tr>
                                <th><center>#</center></th>
                                <th><center>Nombre</center></th>
                                <th><center>Material</center></th>
                                <th><center>Descripcion</center></th>
                                <th><center>Gavilanes</center></th>
                                <th><center>Ancho</center></th>
                                <th><center>Largo</center></th>
                                <th><center>Cantidad</center></th>
                                <th><center>Fecha</center></th>
                            </tr>
                        </thead>";
                while($consulta = mysqli_fetch_array($resultados)){
                echo "
                        <tbody class=\"tb-body\">
                            <tr>
                                <td><center>".$consulta['id_herramienta']."</center></td>
                                <td><center>".$consulta['Nombre']."</center></td>
                                <td><center>".$consulta['material']."</center></td>
                                <td><center>".$consulta['descripcion']."</center></td>
                                <td><center>".$consulta['Num_gavilanes']."</center></td>
                                <td><center>".$consulta['Ancho']."</center></td>
                                <td><center>".$consulta['Largo']."</center></td>
                                <td><center>".$consulta['cantidad']."</center></td>
                                <td><center>".$consulta['fecha_hora']."</center></td>
                            </tr>
                        </tbody>";
                }
                include("php/cerrar_conexion.php");
                echo "
                    </table>
                ";
            ?>
            </div>
        </div>  
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="inventario.php">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="inventario.php">1</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="herramienta_agotada.php">3</a></li>
            <li class="page-item">
                <a class="page-link" href="herramienta_agotada.php">Next</a>
            </li>
        </ul>
    </nav>

    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>