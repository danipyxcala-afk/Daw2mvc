<div class="container mb-5">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <a href="<?= url ?>index.php?controller=login">Iniciar sesión</a> /
        <span>Registro</span>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <section class="acceso">
                <h1 class="acceso__titulo">Crear cuenta</h1>
                <p class="mb-4">Regístrate para hacer tu pedido</p>

                <!-- Cada name coincide con su columna de la tabla usuarios.
                     Rol y fecha de registro no se piden: tienen valor por defecto en la base de datos -->
                <form class="formulario" action="<?= url ?>PanelUsuario/registro" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100"
                            autocomplete="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input placeholder="tu@email.com" type="email" class="form-control" id="email" name="email"
                            maxlength="150" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            autocomplete="new-password" required>
                    </div>
                    <!-- align-items-end alinea los dos campos aunque una etiqueta ocupe dos líneas -->
                    <div class="row align-items-end">
                        <div class="col-12 col-sm-6 mb-3">
                            <label class="form-label" for="telefono">
                                Teléfono <span class="acceso__opcional">(opcional)</span>
                            </label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="20"
                                autocomplete="tel">
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label class="form-label" for="fecha_nacimiento">
                                Fecha de nacimiento <span class="acceso__opcional">(opcional)</span>
                            </label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                autocomplete="bday">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="direccion">
                            Dirección <span class="acceso__opcional">(opcional)</span>
                        </label>
                        <input type="text" class="form-control" id="direccion" name="direccion" maxlength="255"
                            autocomplete="street-address">
                    </div>
                    <button type="submit" class="boton boton--primario w-100">Crear cuenta</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    ¿Ya tienes cuenta?
                    <a class="acceso__enlace" href="<?= url ?>index.php?controller=login">Inicia sesión</a>
                </p>
            </section>
        </div>
    </div>
</div>
