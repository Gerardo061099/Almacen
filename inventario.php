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
    <link rel="shortcut icon" href="img/pie-chart.png">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
            <button class="btn btn-dark btn-sm" type="button" data-toggle="dropdown" aria-expanded="false">
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
        <main class="px-3 py-3">
            <header class="encabesado p-2 text-white">
                <h1 class=" text-center">Herramientas</h1>
            </header>
            <div class="d-flex flex-wrap justify-content-around">
                <div class="form-update bg-dark text-white p-3">
                    <form>
                        <h1 id="titulos-form">Actualizar</h1>
                        <div class="form-row" id="items">
                            <div class="col-md-6 mb-3">
                                <label for="id_h"># registro</label>
                                <select class="form-control form-control-sm" id="id_h" disabled>
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
                            <div class="col-md-6 mb-3">
                                <label for="cantidadnew">Cantidad</label>
                                <input type="text" class="form-control form-control-sm" id="cantidadnew" disabled>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm" type="submit" onclick="update(event);" disabled> Actualizar</button>
                    </form>
                </div>
                <div class="botones bg-dark text-white p-3">
                    <form method="POST" action="inventario.php">
                        <h1 id="titulos-form">Buscar</h1>
                            <div class="form-row align-items-center">
                                <div class="col-md-6 my-1">
                                    <label for="herra_b">Herramienta:</label>
                                    <select class="form-control form-control-sm" id="herra_b" name="herramienta">
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
                                <div class="col-md-6 my-1">
                                    <label for="medida_b">Medida:</label>
                                    <select class="form-control form-control-sm" id="medida_b" name="medida">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <button class="btn btn-info btn-sm" type="submit" name="btn_buscar"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                            <div id="cargando"></div>
                        </div>
                    </form>
                </div>
                <div class="card p-2" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action list-group-item-dark"><a href="registro_h.php" class="badge badge-success"><img src="img/playlist.png" alt=""> Nuevo registro</a></li>
                        <li class="list-group-item list-group-item-action list-group-item-dark"><a class="navbar-brand" href="#">
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
                        <li class="list-group-item list-group-item-action list-group-item-dark"><a class="navbar-brand" href="herramienta_agotada.php">
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
                <div class="container_herramientas">
                    <div class="d-flex justify-content-between p-2 ">
                        <h3 class="titulos text-white"><strong>Listado de herramientas</strong></h3>
                        <div><a class="btn btn-danger btn-sm" href="php/reporte_Herramientas.php" target="_blank"><i class="fa-solid fa-file-pdf"></i></a></div>
                    </div>
                    <div class="tabla-herramientas table-responsive px-2">
                        <?php
                            include("php/abrir_conexion.php");// conexion con la BD
                            $resultados = mysqli_query($conexion,"SELECT h.id_herramienta,h.Nombre,c.material,c.descripcion,g.Num_gavilanes,m.Ancho,m.Largo,h.cantidad_minima,h.cantidad,h.fecha_hora FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas ORDER BY h.id_herramienta");
                            //Unimos tabla Herramientas con categorias y medidas
                            echo "
                                <table class=\"table table-striped table-bordered table-hover table-sm table-dark\" id=\"herramientas\">
                                    <thead class=\"sticky-top thead-dark\">
                                        <tr>
                                            <th scope=\"col\">#</th>
                                            <th scope=\"col\">Nombre</th>
                                            <th scope=\"col\">Material</th>
                                            <th scope=\"col\">Descripcion</th>
                                            <th scope=\"col\">Gavilanes</th>
                                            <th scope=\"col\">Ancho</th>
                                            <th scope=\"col\">Largo</th>
                                            <th scope=\"col\">Stock</th>
                                            <th scope=\"col\">Stock min</th>
                                            <th scope=\"col\">Fecha</th>
                                            <th scope=\"col\">Estado</th>
                                            <th scope=\"col\">Borrar</th>
                                            <th scope=\"col\">Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody class=\"body-tb\">
                                ";
                                while($consulta = mysqli_fetch_array($resultados)) {
                                    $datos = $consulta[0] ."||".
                                    $consulta[1]."||".
                                    $consulta[2]."||".
                                    $consulta[3]."||".
                                    $consulta[4]."||".
                                    $consulta[5]."||".
                                    $consulta[6]."||".
                                    $consulta[7]."||".
                                    $consulta[8]."||".
                                    $consulta[9];
                                echo 
                                "
                                    <tr>
                                        <td><center>".$consulta['id_herramienta']."</center></td>
                                        <td><center>".$consulta['Nombre']."</center></td>
                                        <td><center>".$consulta['material']."</center></td>
                                        <td><center>".$consulta['descripcion']."</center></td>
                                        <td><center>".$consulta['Num_gavilanes']."</center></td>
                                        <td><center>".$consulta['Ancho']."</center></td>
                                        <td><center>".$consulta['Largo']."</center></td>
                                        <td><center>".$consulta['cantidad']."</center></td>
                                        <td><center>".$consulta['cantidad_minima']."</center></td>
                                        <td><center>".$consulta['fecha_hora']."</center></td>
                                        <th><center>";?>
                                        <?php
                                            //mostramos un aviso segun la cantidad de piezas 
                                            if($consulta['cantidad'] < $consulta['cantidad_minima']) {//condicionamos var cantidad a 2 o menor para mostrar un mesaje 
                                                if ($consulta['cantidad'] != 0 && $consulta['cantidad'] < $consulta['cantidad_minima']) {
                                                    echo "<img src=\"img/warning.png\" alt=\"sin resultados\">";
                                                }
                                                else{
                                                    if ($consulta['cantidad'] == 0) {
                                                        echo "<img src=\"img/cancel.png\" alt=\"sin resultados\">";
                                                    }
                                                }
                                            }//si la cantidad es mayor a 2 no se requiere comprar más
                                            else{
                                                if ($consulta['cantidad'] >= $consulta['cantidad_minima']) {
                                                    echo "<img src=\"img/check.png\" alt=\"sin resultados\">";
                                                }
                                            }
                                        ?>
                                        </center></th>
                                        <th><center><a class="btn btn-danger btn-sm" href="eliminar.php?id=<?php echo $consulta['id_herramienta']?>" role="button"><i class="fa-solid fa-trash"></i></a></center></th>
                                        <th><center><a class="btn btn-light btn-sm" role="button" onclick="editarHerramienta('<?php echo $datos?>')"><i class="fa-solid fa-square-pen"></i></a></center></th>
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
            <div class="modal fade" id="ModalEditar" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title">Editando...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="frm_update_h">
                            <div class="modal-body">
                                <div class="form-row mb-3">
                                    <div class="col-md-2">
                                        <label for="idmodal">id</label>
                                        <input type="text" id="idmodal" class="form-control form-control-sm" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="nombremodal">Nombre:</label>
                                        <input type="text" id="nombremodal" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="medidasmodal">Medidas:</label>
                                        <select class="form-control form-control-sm" id="medidasmodal">
                                            <option selected >Choose...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col-md-9">
                                        <label for="descripcionmodal">Categoria:</label>
                                        <select class="form-control form-control-sm" id="descripcionmodal">
                                            <option selected >Choose...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="gavilanesmodal">Gavilanes:</label>
                                        <select class="form-control form-control-sm" id="gavilanesmodal">
                                            <option selected >Choose...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <label for="stock">Stock:</label>
                                        <input type="text" id="stock" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="stockminimo">Stock minimo:</label>
                                        <input type="text" id="stockminimo" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <div class="contador-h bg-dark">
            <div style="background: #2E4053; border-radius: 5px; "><center><h3 style="color: white;">Resultados</h3></center></div>
            <div class="w-100">
            <?php
                    include("php/abrir_conexion.php");
                    if (isset($_POST['btn_buscar'])) {
                        $her = $_POST['herramienta'];
                        $med = $_POST['medida'];
                        if ($her != 'Choose...' && $med != 'Choose...') {
                            $consultah = mysqli_query($conexion, "SELECT h.id_herramienta AS id,h.Nombre AS Nombre,c.Descripcion AS Descripcion,c.Material AS Material,g.Num_gavilanes AS Num_gavilanes,m.Ancho AS Ancho,m.Largo AS Largo,h.Cantidad AS Stock,h.Cantidad_Minima AS Stock_minimo,h.rutaimg AS rutaimg FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas WHERE h.Nombre LIKE '%$her%' AND m.Ancho LIKE '%$med%'");                    
                ?>
                            <div class="d-flex flex-wrap justify-content-around" id="mensaje">
                                <?php
                                if(mysqli_num_rows($consultah) > 0){
                                    while($responsData = mysqli_fetch_assoc($consultah)) {
                                ?>
                                    <div class="conten">
                                        <img class="text-white" src="<?php echo $responsData['rutaimg'];?>" id="imgs" alt="imagen no encontrada">
                                        <div class = "infor">
                                            <h1 class="subt">Características</h1>
                                            <p><?php echo "# ".$responsData['id'];?></p>
                                            <p><?php echo "Nombre: ".$responsData['Nombre']." de ".$responsData['Material']." ".$responsData['Descripcion'];?></p></p>
                                            <p><?php echo "Medidas: ".$responsData['Ancho']." Ancho x ".$responsData['Largo']." Largo";?></p>
                                            <p><?php echo "Gavilanes: ".$responsData['Num_gavilanes']." Stock: ".$responsData['Stock']." Stock minimo: ".$responsData['Stock_minimo'];?></p>
                                        </div>
                                    </div>
                                <?php
                                    }
                                    echo '
                                    <script>
                                    swal({
                                        title: "Busqueda exitosa!!",
                                        text: "Para ver los resultados deslice hacia arriba",
                                        icon: "success"
                                    });
                                    </script>';
                            }else{
                                echo '
                                <center><div class="alert alert-warning" role="alert"><strong>Sin resultados</strong></div></center>
                                <script>
                                    swal({
                                        title: "Opciones no validas",
                                        text: "Las medidas no coinciden con el tipo de herramienta en la base de datos",
                                        icon: "error"
                                    });
                                </script>';
                            }
                        }else {
                        echo '
                        <center><div class="alert alert-warning" role="alert"><strong>Sin resultados</strong></div></center>
                        <script>
                            swal({
                                title: "Opciones no validas",
                                text: "Selecciona los valores para realizar la busqueda",
                                icon: "warning"
                            });
                        </script>';
                        }
                        include("php/cerrar_conexion.php");
                    } else{
                        echo '<center><div class="alert alert-warning d-inline-flex p-2" role="alert"><strong>Busqueda de herramientas</strong></div></center>';
                    }
                                ?>
            </div>
        </div>
    </center>
    

    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-----------CDN JQuery----------------------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script type="module" src="js/app.js"></script>
    <script src="js/getCategoria.js"></script>
    <script src="js/funciones_herramientas.js"></script>
    <script type="module" src="js/buscar_app.js"></script>
    <script type="module" src="js/funciones_Modal_H.js"></script>
</body>
</html>