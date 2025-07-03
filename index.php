<?php
session_start();
include "php/abrir_conexion.php";
if (isset($_POST['btn1'])) {
    if (isset($_SESSION['id'])) {
        header('Location: pagina_principal.php');
    }
    $message = '';
    if (!empty($_POST['user']) && !empty($_POST['pass'])) {
        $user = $_POST['user'];
        $loginUser = mysqli_query($conexion, "SELECT id_us,user,pass FROM $tbu_db1 WHERE user = '$user'");
        $result = mysqli_fetch_assoc($loginUser);
        if (mysqli_num_rows($loginUser) > 0 && password_verify($_POST['pass'], $result['pass'])) {
            $_SESSION['id'] = $result['id_us'];
            $_SESSION['user'] = $result['user'];
            header('Location: pagina_principal.php');
        } else {
            $message = 'Lo siento, las credenciales no coinciden';
        }
    } else {
        $message = 'Ingresa los datos completos de tu sesion';
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
    <main>
        <article class="container d-flex justify-content-center mt-5">
            <div id="login">
                <header class="">
                    <h1 style="margin-top: 5px;" class="titulo1 text-center text-white">Sign In</h1>
                </header>
                <hr>
                <article class="d-flex justify-content-center"><img class="img-user rounded" src="img/aluxsaLogo2.png" alt="No se encontro la imagen"></article>
                <form method="POST" action="index.php" style="margin: 8px 8px">
                    <div class="formulario">
                        <div class="input-group input-group-sm my-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="userlabel"><i class="fa-solid fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="userlabel" name="user" placeholder="user@aluxsa.com....">
                        </div>
                        <div class="input-group input-group-sm my-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="passlabel"><i class="fa-solid fa-key"></i></span>
                            </div>
                            <input type="password" class="form-control" aria-label="Sizing example input" aria-describedby="passlabel" name="pass" placeholder="**********" id="keypass">
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" id="Check1">
                        <label class="custom-control-label text-white" for="Check1">Show password</label>
                    </div>
                    <input type="submit" value="Iniciar Sesion" class="btn btn-sm btn-block btn-dark" name="btn1">
                    <?php if (!empty($message)): ?>
                        <p class="d-flex justify-content-center mt-2"><span class="badge badge-danger"><?= $message ?></span></p>
                    <?php endif; ?>
                </form>
            </div>
        </article>
        <p class="ley text-center">Aluminios Xalatlaco S.A de C.V. Software v2.1.0</p>
    </main>

    <script src="https://kit.fontawesome.com/282ec8cabc.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/showKey.js"></script>
</body>

</html>