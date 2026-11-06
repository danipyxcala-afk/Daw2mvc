<div class="container mb-5">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <span>Iniciar sesión</span>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <section class="acceso">
                <h1 class="acceso__titulo">Iniciar sesión</h1>
                <p class="mb-4">Entra para hacer tu pedido</p>

                <form class="formulario" action="<?= url ?>PanelUsuario/login" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input placeholder="tu@email.com" type="email" class="form-control" id="email" name="email"
                            autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="boton boton--primario w-100">Iniciar sesión</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    ¿No tienes cuenta?
                    <a class="acceso__enlace" href="<?= url ?>index.php?controller=login&action=registro">Regístrate</a>
                </p>
            </section>
        </div>
    </div>
</div>
