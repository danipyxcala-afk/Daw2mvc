<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=user&action=plogin">Iniciar sesión</a></li>
            <li class="breadcrumb-item active fw-bold">Registro</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <!-- La tarjeta gris: bg-light + rounded-4, con menos relleno en el móvil -->
            <section class="bg-light rounded-4 p-4 p-sm-5">
                <h1 class="fs-1 mb-2">Crear cuenta</h1>
                <p class="mb-4">Regístrate para hacer tu pedido</p>

                <!-- Cada name coincide con su columna de la tabla usuarios.
                     Rol y fecha de registro no se piden: tienen valor por defecto en la base de datos -->
                <form class="formulario" action="<?= url ?>?controller=user&action=registro" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"  maxlength="100"
                            autocomplete="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="email">Email</label>
                        <input placeholder="tu@email.com" type="email" class="form-control" id="email" name="email"
                            maxlength="150" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            autocomplete="new-password" minlength="8" required>
                    </div>
                    <!-- align-items-end alinea los dos campos aunque una etiqueta ocupe dos líneas -->
                    <div class="row align-items-end">
                        <div class="col-12 col-sm-6 mb-3">
                            <label class="form-label fw-bold" for="telefono">
                                Teléfono <span class="fw-normal small">(opcional)</span>
                            </label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="20"
                                autocomplete="tel">
                        </div>
                        <div class="col-12 col-sm-6 mb-3">
                            <label class="form-label fw-bold" for="fecha_nacimiento">
                                Fecha de nacimiento <span class="fw-normal small">(opcional)</span>
                            </label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                autocomplete="bday">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="direccion">
                            Dirección <span class="fw-normal small">(opcional)</span>
                        </label>
                        <input type="text" class="form-control" id="direccion" name="direccion" maxlength="255"
                            autocomplete="street-address">
                    </div>
                    <button type="submit" class="boton boton--primario w-100 mt-2">Crear cuenta</button>
                </form>

                <p class="text-center mt-4 mb-0">
                    ¿Ya tienes cuenta?
                    <a class="fw-bold text-decoration-underline" href="<?= url ?>index.php?controller=user&action=plogin">Inicia sesión</a>
                </p>
            </section>
        </div>
    </div>
</div>
