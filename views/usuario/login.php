<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item active fw-bold">Iniciar sesión</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <!-- La tarjeta gris: bg-light + rounded-4, con menos relleno en el móvil -->
            <section class="bg-light rounded-4 p-4 p-sm-5">
                <h1 class="fs-1 mb-2">Iniciar sesión</h1>
                <p class="mb-4">Entra para hacer tu pedido</p>

                <form class="formulario" action="<?= url ?>index.php?controller=user&action=login" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="email">Email</label>
                        <input placeholder="tu@email.com" type="email" class="form-control" id="email" name="email"
                            autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="boton boton--primario w-100 mt-2">Iniciar sesión</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    ¿No tienes cuenta?
                    <a class="fw-bold text-decoration-underline" href="<?= url ?>index.php?controller=user&action=pregistro">Regístrate</a>
                </p>
            </section>
        </div>
    </div>
</div>
