<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de nuevas herramientas</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
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
        <a class="navbar-brand" href="#">
            ALUXSA S.A de C.V
        </a>
        <a class="navbar-brand" href="inventario.php">
        Volver a registros
        </a>
            
    </nav>
    <div >
        <p></p>
    </div>
    <center>
    <div class="box-1" style="border-top: #DC7633 7px solid;">
            <div class="encabesado">
                <h1 class="titulo">Registro de Herramientas</h1>
            </div>
        </div>
    <div class="aside1">
                <div class="contenedor" style="border-top: #5DADE2 7px solid;">
                    <div class="aside">
                    <form method="POST" action="registro_h.php">
                    <h1>Registrar:</h1><!-- from. registrar nuesvas herramientas -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombr" placeholder="Cortador, Broca..">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cantidad">Cantidad:</label>
                                <input type="text" class="form-control" id="cantidad" name="cantida">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="precio">Precio $:</label>
                                <input type="text" class="form-control" id="precio" name="preci">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="total">Total:</label>
                                <input type="texto" class="form-control" id="total" name="tota">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="medidas">Codigo Medidas:</label>
                                    <select id="medidas" name="" id="medidas" class="form-control">
                                        <option selected>Choose...</option>
                                        <?php
                                            include("abrir_conexion.php");
                                            $query = $conexion -> query ("SELECT * FROM $tbmed_db9");
                                            //$num=0;
                                                while ($valores = mysqli_fetch_array($query)) {
                                                    echo ('<option value="'.$valores['id_Medidas'].'">'.$valores['Ancho'].' x '.$valores['Largo'].'</option>');
                                                    //$id_partida++;
                                                }
                                                include("cerrar_conexion.php");
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="categoria">Codigo Categoria:</label>
                                    <select id="categoria" name="" id="categoria" class="form-control">
                                        <option selected>Choose...</option>
                                        <?php
                                            include("abrir_conexion.php");
                                            $query = $conexion -> query ("SELECT * FROM $tbcat_db3");
                                            $id_partida=0;
                                                while ($valores = mysqli_fetch_array($query)) {
                                                    echo ('<option value="'.$valores['id_Categoria'].'">'.$valores['Descripcion'].' '.$valores['Material'].'</option>');
                                                    //$id_partida++;
                                                }
                                                include("cerrar_conexion.php");
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gavilanes">Gavilanes:</label>
                                    <select id="gavilanes" name="" id="gavilanes" class="form-control">
                                        <option selected>Choose...</option>
                                        <?php
                                            include("abrir_conexion.php");
                                            $query = $conexion -> query ("SELECT * FROM $tbgav_db6");
                                            $contador=0;
                                                while ($valores = mysqli_fetch_array($query)) {
                                                    echo ('<option value="'.$valores['id_Gav'].'">'.$valores['Num_gavilanes'].'</option>');
                                                }
                                                include("cerrar_conexion.php");
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <input type="submit" value="Hecho" class="btn btn-success" name="enviar" onclick="obtener()">
                        </form>
                            <?php
                                if (isset($_POST['gavilanes'])) {
                                    include("abrir_conexion.php");
                                    echo"<script>
                                                swal({
                                                    title: \"Entra en php:\",
                                                    text:\"Entramos en php\",
                                                    icon:\"success\",
                                                    dangerMode: false,
                                                });
                                            </script>";
                                    $nombre = $_POST['nombre'];
                                    $cantidad = $_POST['cantidad'];
                                    $precio = $_POST['precio'];
                                    $total = $_POST['total'];
                                    //ajax
                                    $medidas = $_POST['medidas'];
                                    $categoria = $_POST['categoria'];
                                    $n_gavilanes = $_POST['gavilanes']; 
                                    if ($nombre=="" && $cantidad="" && $precio="" && $total="" && $medidas="" && $categoria=""&&$n_gavilanes="") {
                                        echo"<script>
                                                swal({
                                                    title: \"Campos vacios:\",
                                                    text:\"Debes llenar todos los campos.\",
                                                    icon:\"warning\",
                                                    dangerMode: true,
                                                });
                                            </script>";
                                    }
                                    else {
                                        mysqli_query($conexion, "INSERT INTO $tbherr_db7 (id_categoria,nombre,id_gavilanes,id_medidas,preciocompra,cantidad,total,fecha_hora) values ('$categoria','$nombre','$n_gavilanes','$medidas','$precio','$cantidad','$total',now())");
                                        echo"<script>
                                                swal({
                                                    title: \"Insercion exitosa:\",
                                                    text:\"Se realizo un registro en la tabla herramientas.\",
                                                    icon:\"success\",
                                                    dangerMode: false,
                                                });
                                            </script>";
                                            //header("Location:inventario.php");
                                        include("cerrar_conexion.php");
                                    }
                                }
                            ?>
                    </div>
                </div>
                <div>
                    
                </div>
    </div>
    <script src="js/app.js"></script>
</body>
</html>