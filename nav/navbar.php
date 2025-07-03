<nav class="navbar sticky-top headline navbar-dark bg-dark ">
    <article class="container">
        <div class="navbar-brand">
            ALUXSA S.A de C.V
        </div>
        <div class="dropdown d-flex align-items-center pr-4">
            <div class="px-2">
                <img src="img/login_profile_user.png" alt="">
            </div>
            <p class="mb-0 px-1">
                <span class="text-white"><?php echo $_SESSION['usuario']; ?></span>
            </p>
            <div class="btn-group">
                <button class=" btn btn-dark btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="pagina_principal.php"><i class="fa-solid fa-house"></i> Inicio</a>
                    <a class='dropdown-item' href='add_user.php'><i class='fa-solid fa-user-gear'></i> Administrar usuarios</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesion</a>
                </div>
            </div>
        </div>
    </article>
</nav>