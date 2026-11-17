<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item active fw-bold">Carrito</li>
        </ol>
    </nav>

    <h1 class="mb-4">Tu carrito</h1>

    <!-- PASOS DEL PEDIDO. En el móvil solo se ve el texto del paso en el que estamos (d-none d-sm-inline) -->
    <ol class="list-unstyled d-flex justify-content-center align-items-center gap-2 gap-md-3 mb-5 small">
        <li class="pasos__paso is-activo">
            <span class="pasos__numero">1</span> Carrito
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">2</span> <span class="d-none d-sm-inline">Datos y pago</span>
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">3</span> <span class="d-none d-sm-inline">Confirmación</span>
        </li>
    </ol>

    <?php if (count($lineas) === 0) { ?>
        <div class="py-5 text-center">
            <p>Tu carrito está vacío.</p>
            <a class="boton boton--primario" href="<?= url ?>index.php?controller=productos">Ver la carta</a>
        </div>
    <?php } else { ?>
        <div class="row g-4">
            <!-- LÍNEAS DEL CARRITO -->
            <div class="col-lg-8">
                <!-- Leyenda: usa las mismas columnas que cada línea, así cada título queda encima de su dato -->
                <div class="row g-3 d-none d-md-flex pb-2 border-bottom small text-uppercase text-body-tertiary">
                    <div class="col-md-2">Producto</div>
                    <div class="col-md-10">
                        <div class="row g-2">
                            <div class="col-md"></div>
                            <div class="col-md-3 text-center">Cantidad</div>
                            <div class="col-md-2 text-end">Precio</div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>

                <ul class="list-unstyled m-0">
                    <?php foreach ($lineas as $clave => $linea) {
                        $nombre = texto($linea['nombre']);
                        $cantidad = (int) $linea['cantidad'];
                        $quitados = $linea['quitados'] ?? [];
                        $extras = $linea['extras'] ?? [];
                        ?>
                        <!-- Cada línea: la foto a la izquierda y el resto a la derecha.
                             En el móvil el nombre va arriba y la cantidad, el precio y la papelera debajo -->
                        <li class="row g-3 align-items-center py-3 border-bottom">
                            <div class="col-3 col-md-2">
                                <div class="linea-carrito__media d-flex align-items-center justify-content-center p-2 rounded-3 bg-dark">
                                    <img class="w-100 h-100 object-fit-contain" src="<?= url . 'assets/' . texto($linea['imagen']) ?>"
                                        alt="" width="120" height="80" loading="lazy">
                                </div>
                            </div>

                            <div class="col-9 col-md-10">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md">
                                        <h2 class="fs-5 mb-1"><?= $nombre ?></h2>
                                        <p class="small mb-0">
                                            <?php if (count($quitados) + count($extras) === 0) { ?>
                                                Sin extras ·
                                            <?php } else { ?>
                                                <?php foreach ($quitados as $quitado) { ?>
                                                    <span>Sin <?= texto($quitado['nombre']) ?> ·</span>
                                                <?php } ?>
                                                <?php foreach ($extras as $extra) { ?>
                                                    <span class="text-primary">+ <?= texto($extra['nombre']) ?> ·</span>
                                                <?php } ?>
                                            <?php } ?>
                                            <?= precio($linea['precio_unitario']) ?> / ud.
                                        </p>
                                    </div>

                                    <!-- CANTIDAD -->
                                    <div class="col-auto col-md-3 text-md-center">
                                        <form class="linea-carrito__cantidad d-inline-flex align-items-center rounded-pill bg-light" method="POST"
                                            action="<?= url ?>index.php?controller=carrito&action=cambiarCantidad">
                                            <input type="hidden" name="clave" value="<?= texto($clave) ?>">
                                            <button class="cantidad__boton" type="submit" name="cantidad" value="<?= $cantidad - 1 ?>"
                                                <?= $cantidad <= 1 ? 'disabled' : '' ?>>-</button>
                                            <span class="cantidad__numero"><?= $cantidad ?></span>
                                            <button class="cantidad__boton" type="submit" name="cantidad" value="<?= $cantidad + 1 ?>"
                                                <?= $cantidad >= 99 ? 'disabled' : '' ?>>+</button>
                                        </form>
                                    </div>

                                    <div class="col col-md-2 text-end fw-bold">
                                        <?= precio((float) $linea['precio_unitario'] * $cantidad) ?>
                                    </div>

                                    <!-- PAPELERA: <details> pide confirmación sin JavaScript.
                                         z-3 hace que el aviso quede por encima de las líneas de debajo -->
                                    <div class="col-auto col-md-1 text-end">
                                        <details class="d-inline-block position-relative">
                                            <summary class="boton-icono">
                                                <img src="<?= url ?>assets/img/icons/negro/svg/eliminar.svg" alt="" width="20" height="20">
                                            </summary>
                                            <div class="desplegable position-absolute top-100 end-0 z-3 mt-2 p-3 bg-white rounded-3 shadow text-center">
                                                <p class="small mb-3">¿Quitar <?= $nombre ?> del carrito?</p>
                                                <form method="POST" action="<?= url ?>index.php?controller=carrito&action=quitar">
                                                    <input type="hidden" name="clave" value="<?= texto($clave) ?>">
                                                    <button class="boton boton--primario boton--sm" type="submit">Sí, quitar</button>
                                                </form>
                                            </div>
                                        </details>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <!-- RESUMEN -->
            <div class="col-lg-4">
                <aside class="bg-light rounded-4 p-4">
                    <h2 class="fs-2 mb-4">Resumen</h2>

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
                        <div class="carrito__fila">
                            <dt>Descuento</dt>
                            <dd><?= (float) $descuento > 0 ? '−' : '' ?><?= precio($descuento) ?></dd>
                        </div>
                        <div class="carrito__fila carrito__fila--total">
                            <dt>Total</dt>
                            <dd><?= precio($total) ?></dd>
                        </div>
                    </dl>

                    <!-- CÓDIGO PROMOCIONAL -->
                    <form class="mb-3" method="POST"
                        action="<?= url ?>index.php?controller=carrito&action=aplicarCodigo">
                        <label class="visually-hidden" for="carrito-codigo">Código promocional</label>
                        <input class="form-control border-dark rounded-3 py-2 small" type="text" id="carrito-codigo" name="codigo"
                            placeholder="Código promocional" maxlength="50" autocomplete="off">
                    </form>

                    <!-- CONTINUAR -->
                    <a class="boton boton--secundario boton--sm w-100"
                        href="<?= url ?>index.php?controller=carrito&action=datosPago">
                        Continuar
                        <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
                    </a>
                </aside>
            </div>
        </div>
    <?php } ?>
</div>
