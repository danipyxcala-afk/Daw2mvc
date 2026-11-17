<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=carrito">Carrito</a></li>
            <li class="breadcrumb-item active fw-bold">Datos y pago</li>
        </ol>
    </nav>

    <h1 class="mb-4">Datos y pago</h1>

    <!-- PASOS DEL PEDIDO. En el móvil solo se ve el texto del paso en el que estamos (d-none d-sm-inline) -->
    <ol class="list-unstyled d-flex justify-content-center align-items-center gap-2 gap-md-3 mb-5 small">
        <li class="pasos__paso">
            <span class="pasos__numero">1</span> <span class="d-none d-sm-inline">Carrito</span>
        </li>
        <li class="pasos__paso is-activo">
            <span class="pasos__numero">2</span> Datos y pago
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">3</span> <span class="d-none d-sm-inline">Confirmación</span>
        </li>
    </ol>

    <div class="row g-4">
        <div class="col-lg-8">
            <form id="form-pago" method="POST" action="<?= url ?>index.php?controller=carrito&action=confirmar">

                <!-- DATOS DE ENTREGA -->
                <section class="bg-light rounded-4 p-4 mb-4">
                    <h2 class="fs-4 mb-3">Datos de entrega</h2>
                    <?php if ($usuario) { ?>
                        <!-- text-break parte los emails largos para que no se salgan de la tarjeta -->
                        <dl class="mb-0">
                            <dt class="small">Nombre</dt>
                            <dd class="mb-3 text-break"><?= dato($usuario->getNombre()) ?></dd>

                            <dt class="small">Email</dt>
                            <dd class="mb-3 text-break"><?= dato($usuario->getEmail()) ?></dd>

                            <dt class="small">Teléfono</dt>
                            <dd class="mb-3 text-break"><?= dato($usuario->getTelefono()) ?></dd>

                            <dt class="small">Dirección</dt>
                            <dd class="mb-0 text-break"><?= dato($usuario->getDireccion()) ?></dd>
                        </dl>
                        <p class="mt-3 mb-0">
                            <a href="<?= url ?>index.php?controller=user&action=puser">Ver mis datos en Mi cuenta</a>
                        </p>
                    <?php } ?>
                </section>

                <!-- MÉTODO DE PAGO -->
                <fieldset class="bg-light rounded-4 p-4 mb-4">
                    <legend class="fs-4 mb-3">Método de pago</legend>
                    <?php $primero = true;
                    foreach ($metodosPago as $valor => $texto) { ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="metodo_pago"
                                id="pago-<?= $valor ?>" value="<?= $valor ?>" <?= $primero ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="pago-<?= $valor ?>"><?= $texto ?></label>
                        </div>
                        <?php $primero = false;
                    } ?>
                    <p class="mt-3 mb-0"><small>Pago simulado: no se cobra nada ni se piden datos bancarios.</small></p>
                </fieldset>
            </form>
        </div>

        <!-- RESUMEN -->
        <div class="col-lg-4">
            <aside class="bg-light rounded-4 p-4">
                <h2 class="fs-2 mb-4">Tu pedido</h2>

                <ul class="list-unstyled mb-3">
                    <?php foreach ($lineas as $linea) {
                        $cantidad = (int) $linea['cantidad'];
                        $quitados = $linea['quitados'] ?? [];
                        $extras = $linea['extras'] ?? [];
                        ?>
                        <li class="mb-3">
                            <div class="d-flex justify-content-between gap-3">
                                <span><?= $cantidad ?>x <?= dato($linea['nombre']) ?></span>
                                <span><?= precio((float) $linea['precio_unitario'] * $cantidad) ?></span>
                            </div>
                            <?php if (count($quitados) + count($extras) > 0) { ?>
                                <ul class="list-unstyled mt-1 mb-0 ps-3 small">
                                    <?php foreach ($quitados as $quitado) { ?>
                                        <li class="text-secondary text-decoration-line-through">Sin <?= dato($quitado['nombre']) ?></li>
                                    <?php } ?>
                                    <?php foreach ($extras as $extra) { ?>
                                        <li class="text-primary">+ <?= dato($extra['nombre']) ?></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>

                <dl class="mb-4">
                    <div class="carrito__fila">
                        <dt>Subtotal</dt>
                        <dd><?= precio($subtotal) ?></dd>
                    </div>
                    <div class="carrito__fila">
                        <dt>IVA (10%)</dt>
                        <dd><?= precio($iva) ?></dd>
                    </div>
                    <div class="carrito__fila">
                        <dt>Envío</dt>
                        <dd><?= precio($envio) ?></dd>
                    </div>
                    <?php if ((float) $descuento > 0) { ?>
                        <div class="carrito__fila">
                            <dt>Descuento<?= isset($_SESSION['codigo']) ? ' (' . dato($_SESSION['codigo']) . ')' : '' ?></dt>
                            <dd>−<?= precio($descuento) ?></dd>
                        </div>
                    <?php } ?>
                    <div class="carrito__fila carrito__fila--total">
                        <dt>Total</dt>
                        <dd><?= precio($total) ?></dd>
                    </div>
                </dl>

                <!-- CONFIRMAR -->
                <button class="boton boton--secundario boton--sm w-100" type="submit" form="form-pago">
                    Confirmar pedido
                    <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20" height="20">
                </button>
                <p class="mt-3 mb-0 text-center">
                    <a href="<?= url ?>index.php?controller=carrito">Volver al carrito</a>
                </p>
            </aside>
        </div>
    </div>
</div>
