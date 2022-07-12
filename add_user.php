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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
            include("abrir_conexion.php");
            $_SESSION['sesion']=3;
            $resultado = mysqli_query($conexion,"SELECT * FROM $tbu_db1 WHERE user = '$mail' AND pass = PASSWORD('$pwd')");
            while($consulta = mysqli_fetch_array($resultado)){
                //echo "Bienvenido ".$consulta['user']." has iniciado sesion";
                $_SESSION['sesion']=1;
            }
            include("cerrar_conexion.php");
        }
    }
    if ($_SESSION['sesion']<>1) {
        header("Location:index.php");
    }
?>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="pagina_principal.php">
            ALUXSA S.A de C.V
        </a>
    </nav>
    <center>
        <div class="box-1" style="border-top: #DC7633 7px solid;">
            <div class="encabesado">
                <h1 class="titulo">Agregar Usuario</h1>
            </div>
        </div>
        <div class="aside1">
                <div class="contenedor" style="border-top: #5DADE2 7px solid;">
                    <div class="aside">
                        <form enctype="multipart/form-data">
                        <h1>Registrar:</h1><!-- from. registrar nuevas herramientas -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="nombre">Nombre(s):</label>
                                    <input type="text" class="form-control" id="nombre" name="nombr" placeholder="Cortador, Broca..">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="apellidos">Apellidos:</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="1,2,3,4...">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cantidadm">Cantidad Minima:</label>
                                    <input type="text" class="form-control" id="cantidadm" name="cantidad2" placeholder="Cantidad Minima">
                                </div>
                            </div>
                            <div class="form-row" >
                                <div class="form-group col-md-6">
                                    <label for="gavilanes">Gavilanes:</label>
                                        <select id="gavilanes" id="gavilanes" class="form-control">
                                            <option selected>Choose...</option>
                                            <?php
                                                include("abrir_conexion.php");
                                                //realizamos una consulta a la DB
                                                $query = $conexion -> query ("SELECT * FROM $tbgav_db6 ORDER BY Num_gavilanes");
                                                //mostramos los datos obtenidos mediante etiquetas de HTML
                                                    while ($valores = mysqli_fetch_array($query)) {
                                                        echo ('<option value="'.$valores['id_Gav'].'">'.$valores['Num_gavilanes'].'</option>');
                                                    }
                                                include("cerrar_conexion.php");
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="medidas">Medidas:</label>
                                        <select id="medidas" class="form-control">
                                            <option selected>Choose...</option>
                                            <?php
                                                include("abrir_conexion.php");
                                                $query = $conexion -> query ("SELECT * FROM $tbmed_db9");
                                                    while ($valores = mysqli_fetch_array($query)) {
                                                        echo ('<option value="'.$valores['id_Medidas'].'">'.$valores['Ancho'].' x '.$valores['Largo'].'</option>');
                                                    }
                                                include("cerrar_conexion.php");
                                            ?>
                                        </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="categoria">Categoria:</label>
                                        <select id="categoria" class="form-control">
                                            <option selected>Choose...</option>
                                            <?php
                                                include("php/print_list_categorias.php");
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="subir_imagen">Nomenclatura: img.jpg</label>
                                    <input type="file" class="form-control-file" id="subir_imagen" name="upimg">
                                </div>
                            </div>
                            <a href="add_categorias.php" type="submit" class="btn btn-dark"><img src="img/plus-withe.png" alt="sin resultados"> Categoria</a>
                            <a href="add_medidas.php" type="submit" class="btn btn-primary"><img src="img/plus-withe.png" alt="sin resultados"> Medidas</a>
                            <input type="submit" value="Hecho" class="btn btn-success" onclick=obtener(event)>
                            <button type="button" class="btn btn-danger"><img src="img/trash-can.png" alt="sin resultados" onclick="borrar(event)"></button>
                            <div id="load1" style="color: black; font-size: 20px;"></div>
                        </form>
                    </div>
                </div>
        </div>
        <nav aria-label="Page navigation example" style="margin: 10px 10px;">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="inventario.php">Pagina anterior</a>
                </li>
                
            </ul>
        </nav>
    </center>
    <script src="js/eliminar.js"></script>
    <script src="js/app.js"></script>
</body>
</html>