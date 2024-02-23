<?php
    session_start();
    include("php/abrir_conexion.php");
    if (isset($_SESSION['id'])) {
        header('Location: pagina_principal.php');
    }
    $message = '';
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {
        $user = $_POST['user'];
        $loginUser = mysqli_query($conexion,"SELECT id_us,user,pass FROM $tbu_db1 WHERE user = '$user'");
        $result = mysqli_fetch_assoc($loginUser);

        if (mysqli_num_rows($loginUser) > 0 && password_verify($_POST['pass'],$result['pass'])) {
            $_SESSION ['id'] = $result['id_us'];
            header('Location: pagina_principal.php');
        } else {
            $message = 'Lo siento, las credenciales no coinciden';
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/pie-chart.png">
    <title>Log In</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script><!--CDN swal(sweatalert)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="cuerpo">
    <div class="row" style="margin: 5px;">
        <div class="col-md-4" style="padding: 0px; width: 30%;"></div>
            <div class="col-md-4 " id="login">
                <center><h1 style="margin-top: 5px;" class="titulo1">Inicio de Sesion</h1>
                    <div class="">
                        <img class="" src="img/login_profile.png" alt="imagen no disponible">
                    </div>
                </center>
                <?php if (!empty($message)):?>
                    <p class="d-flex justify-content-center"><span class="badge badge-danger"><?= $message ?></span></p>
                <?php endif;?>
                <form method="POST" action="index.php" style="margin: 8px 8px">
                    <div class="formulario" style="text-align: center; ">
                        <div class="form-group">
                            <label for="user" class="usuariola">Nombre de usuario:</label>
                            <input type="text" name="user" placeholder="name-user" class="form-control" id="user" style="width: 55%; display:flex;  margin:auto;">
                        </div>
                        <div class="form-group">
                            <label for="pass" class="passla">Contraseña:</label>
                            <input type="password" name="pass" placeholder="********" class="form-control" id="pass" style="width: 55%; display:flex; margin:auto;">
                            
                        </div>
                    </div>
                <center>
                    <input type="submit" value="Iniciar Sesion" class="btn btn-dark" name="btn1">
                </center>
                </form>
            </div>
        <div class="col-md-4" style="padding: 0px; width: 30%;"></div>
    </div>
    <center><p class="ley">Aluminios Xalatlaco S.A de C.V. Software v0.1</p></center>
</body>
</html>