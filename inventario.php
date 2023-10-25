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
    <title>Herramientas</title>
    <link rel="shortcut icon" href="img/bits.png">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <!-----------CDN swal(sweatalert)------------->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="pag">
    <!-- Image and text -->
    <nav class="navbar navbar-dark bg-dark">
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
    <center>
        <div>
            <div class="info">
                <p class="info-p">
                    <h1>Herramientas</h1>
                </p>
            </div>
            <div class="forms">
                <div class="form-update">
                    <form>
                        <h1 id="titulos-form">Actualizar</h1>
                        <div class="form-row" id="items">
                            <div class="col-md-6 mb-3">
                                <label for="id_h"># registro</label>
                                <select class="custom-select" id="id_h">
                                <option selected>Choose...</option>
                                    <?php
                                    include("php/abrir_conexion.php");
                                    $query = $conexion -> query ("SELECT * FROM $tbherr_db7");
                                        while ($valores = mysqli_fetch_array($query)) {
                                            echo ('<option value="'.$valores['id_Herramienta'].'">'.$valores['id_Herramienta'].'</option>');
                                        }
                                    include("php/cerrar_conexion.php");
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cantidadnew">Cantidad</label>
                                <input type="text" class="form-control" id="cantidadnew">
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" onclick="update(event);"><img src="img/update.png" alt=""> Actualizar</button>
                    </form>
                </div>
                <div class="botones">
                    <form method="POST" action="inventario.php">
                        <h1 id="titulos-form">Buscar</h1>
                            <div class="form-row align-items-center">
                                <div class="col-md-5 my-1">
                                    <label for="herra_b">Herramienta:</label>
                                    <select class="custom-select" id="herra_b" name="herramienta">
                                        <option selected>Choose...</option>
                                        <?php
                                        include("php/abrir_conexion.php"); 
                                        $queryH = mysqli_query($conexion,"SELECT nombre FROM $tbherr_db7 GROUP BY nombre");
                                            while($res = mysqli_fetch_array($queryH)){
                                                echo '<option value="'.$res['nombre'].'">'.$res['nombre'].'</option>';   
                                            }
                                        include("php/cerrar_conexion.php");
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-5 my-1">
                                    <label for="medida_b">Medida:</label>
                                    <select class="custom-select" id="medida_b" name="medida">
                                        <option selected>Choose...</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <button class="btn btn-info" type="submit" name="buscar"><img src="img/search.png" alt="sin resultados"> Buscar</button>
                            <div id="cargando"></div>
                        </div>
                    </form>
                </div>
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="registro_h.php" class="badge badge-success"><img src="img/playlist.png" alt=""> Nuevo registro</a></li>
                        <li class="list-group-item"><a class="navbar-brand" href="#">
                            <?php
                                //Contamos la cantidad que hay en el almacen
                                include("php/abrir_conexion.php");
                                $resul = mysqli_query($conexion,"SELECT Count(id_herramienta) as herramientas FROM $tbherr_db7");
                                while($consulta = mysqli_fetch_array($resul)){
                                    echo "  <button type=\"button\" class=\"btn btn-primary btn-sm\">
                                                <strong>N° Piesas:</strong> <span class=\"badge badge-light\">".$consulta['herramientas']."</span>
                                            </button>
                                        ";
                                }
                                include("php/cerrar_conexion.php");
                            ?>
                        </a></li>
                        <li class="list-group-item"><a class="navbar-brand" href="herramienta_agotada.php">
                            <?php
                                //Contamos la cantidad que hay en el almacen
                                include("php/abrir_conexion.php");
                                $resul = mysqli_query($conexion,"SELECT Count(id_herramienta) as faltantes FROM $tbherr_db7 WHERE cantidad < Cantidad_Minima");
                                while($consulta = mysqli_fetch_array($resul)){
                                    echo "  <button type=\"button\" class=\"btn btn-danger btn-sm\">
                                                <strong>Agotadas:</strong> <span class=\"badge badge-light\">".$consulta['faltantes']."</span>
                                            </button>
                                        ";
                                }
                                include("php/cerrar_conexion.php");
                            ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tb-herramientas">
                    <div class="opciones">
                    </div>
                    <div style="margin: 0px 10px; background: #FDFEFE;">
                        <h1 class="titulos" style="text-align:left;"><strong>Listado de herramientas</strong></h1>
                    </div>
                    <div class="tabla-herramientas">
                        <?php
                            include("php/abrir_conexion.php");// conexion con la BD
                            $resultados = mysqli_query($conexion,"SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo,h.cantidad_minima,h.cantidad,h.fecha_hora FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas ORDER BY h.id_herramienta");
                            //Unimos tabla Herramientas con categorias y medidas
                            echo "
                            <table class=\"table table-striped\" id=\"herramientas\">
                                        <thead class=\"thead-dark\">
                                            <tr>
                                                <th><center>#</center></th>
                                                <th><center>Nombre</center></th>
                                                <th><center>Material</center></th>
                                                <th><center>Descripcion</center></th>
                                                <th><center>Gavilanes</center></th>
                                                <th><center>Ancho</center></th>
                                                <th><center>Largo</center></th>
                                                <th><center>C_Minima</center></th>
                                                <th><center>Cantidad</center></th>
                                                <th><center>Fecha</center></th>
                                                <th><center>Estado</center></th>
                                                <th><center>Borrar</center></th>
                                                <th><center>Editar</center></th>
                                            </tr>
                                        </thead>
                                ";
                                while($consulta = mysqli_fetch_array($resultados)) {
                                echo 
                                "<tbody class=\"body-tb\">
                                    <tr>
                                        <td><center>".$consulta['id_herramienta']."</center></td>
                                        <td><center>".$consulta['Nombre']."</center></td>
                                        <td><center>".$consulta['material']."</center></td>
                                        <td><center>".$consulta['descripcion']."</center></td>
                                        <td><center>".$consulta['Num_gavilanes']."</center></td>
                                        <td><center>".$consulta['Ancho']."</center></td>
                                        <td><center>".$consulta['Largo']."</center></td>
                                        <td><center>".$consulta['cantidad_minima']."</center></td>
                                        <td><center>".$consulta['cantidad']."</center></td>
                                        <td><center>".$consulta['fecha_hora']."</center></td>
                                        <th><center>";?>
                                        <?php
                                        //mostramos un aviso segun la cantidad de piezas 
                                        if($consulta['cantidad']<$consulta['cantidad_minima']){//condicionamos var cantidad a 2 o menor para mostrar un mesaje 
                                            if ($consulta['cantidad']!=0 && $consulta['cantidad']<$consulta['cantidad_minima']) {
                                                echo "<img src=\"img/warning.png\" alt=\"sin resultados\">";
                                            }
                                            else{
                                                if ($consulta['cantidad']==0) {
                                                    echo "<img src=\"img/cancel.png\" alt=\"sin resultados\">";
                                                }
                                            }
                                        }//si la cantidad es mayor a 2 no se requiere comprar más
                                        else{
                                            if ($consulta['cantidad']>=$consulta['cantidad_minima']) {
                                                echo "<img src=\"img/check.png\" alt=\"sin resultados\">";
                                            }
                                        }
                                        ?>
                                        </center></th>
                                        <th><center><a class="btn btn-danger btn-sm" href="eliminar.php?id=<?php echo $consulta['id_herramienta']?>" role="button">Eliminar</a></center></th>
                                        <th><center><a class="btn btn-warning btn-sm" href="#" role="button">Editar</a></center></th>
                                    </tr>
                                </tbody>
                            <?php
                            }
                            include("php/cerrar_conexion.php");
                            ?>
                                </table><br>
                    </div>
            </div>
        </div>
    </center>
    <div class="contador-h" id="resultados_search">
        <div class="container_resultados_busqueda">
            <div style="background: #2E4053; border-radius: 5px; "><center><h1 style="color: white;">Resultados</h1></center></div>
            <?php
            include("php/abrir_conexion.php");
            if (isset($_POST['buscar'])) {
                $her = $_POST['herramienta'];
                $med = $_POST['medida'];
                if ($her != 'Choose...' && $med != 'Choose...') {
                    $consult = mysqli_query($conexion, "SELECT h.id_herramienta,h.Nombre,c.Descripcion,c.Material,g.Num_gavilanes,m.Ancho,m.Largo,h.Cantidad,h.rutaimg FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE Nombre LIKE '%$her%' AND Ancho LIKE '%$med%' ORDER BY h.id_herramienta");  
                    while($consulta = mysqli_fetch_array($consult)) {
            ?>
                    <div class="conten">
                    <img src="<?php echo $consulta['rutaimg'];?>" id="imgs" alt="imagen no encontrada">
                        <div class = "infor">
                            <h1 class="subt">Caracteristicas</h1>
                            <p><?php echo "# ".$consulta['id_herramienta']." Nombre: ".$consulta['Nombre']." de ".$consulta['Material']." ".$consulta['Descripcion'];?></p>
                            <p><?php echo "Medidas: ".$consulta['Ancho']." Ancho x ".$consulta['Largo']." Largo";?></p>
                            <p><?php echo"gavilanes: ".$consulta['Num_gavilanes']." Cantidad: ".$consulta['Cantidad'];?></p>
                        </div>
                    </div>
            <?php
                        echo '
                        <script>
                        swal({
                            title: "Busqueda exitosa!!",
                            text: "Para ver los resultados deslice hacia arriba",
                            icon: "success"
                        });
                        </script>';
                    }
                }else {
                    echo '
                    <script>
                        swal({
                            title: "Opciones no validas",
                            text: "Selecciona los valores para realizar la busqueda",
                            icon: "warning"
                        });
                    </script>';
                    }
                include("php/cerrar_conexion.php");
            } else {
                echo '<div class="d-flex justify-content-center"><div class="alert alert-secondary " role="alert">Aquí se muestran los resultados de tu busqueda!!</div></div>';
            }
            ?>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script type="module" src="js/app.js"></script>
    <script type="module" src="js/buscar_app.js"></script>
    <script type="module" src="js/funcion.js"></script>
</body>
</html>