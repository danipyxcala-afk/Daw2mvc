<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item active fw-bold">Pedido confirmado</li>
        </ol>
    </nav>

    <!-- PASOS DEL PEDIDO. En el móvil solo se ve el texto del paso en el que estamos (d-none d-sm-inline) -->
    <ol class="list-unstyled d-flex justify-content-center align-items-center gap-2 gap-md-3 mb-5 small">
        <li class="pasos__paso">
            <span class="pasos__numero">1</span> <span class="d-none d-sm-inline">Carrito</span>
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">2</span> <span class="d-none d-sm-inline">Datos y pago</span>
        </li>
        <li class="pasos__paso is-activo">
            <span class="pasos__numero">3</span> Confirmación
        </li>
    </ol>

    <?php if (!$pedido) { ?>
        <!-- Por si se entra a esta página sin haber hecho ningún pedido -->
        <div class="py-5 text-center">
            <p>No hay ningún pedido que mostrar.</p>
            <a class="boton boton--primario" href="<?= url ?>index.php?controller=productos">Ver la carta</a>
        </div>
    <?php } else { ?>
        <!-- MENSAJE PRINCIPAL -->
        <div class="text-center mb-5">
            <img src="<?= url ?>assets/img/icons/negro/svg/check-circulo.svg" alt="" width="56" height="56" class="mb-3">
            <h1 class="mb-4">¡Pedido confirmado!</h1>
            <p class="mb-0">
                Gracias<?= $usuario ? ', ' . dato($usuario->getNombre()) : '' ?>.
                Hemos recibido tu pedido y ya nos ponemos con él.
            </p>
        </div>

        <div class="row g-4">
            <!-- PRODUCTOS DEL PEDIDO -->
            <div class="col-lg-8">
                <section class="bg-light rounded-4 p-4">
                    <h2 class="fs-4 mb-3">Tu pedido</h2>
                    <ul class="list-unstyled mb-3">
                        <?php foreach ($detalles as $fila) {
                            $linea = $fila['linea'];
                            ?>
                            <li class="mb-3">
                                <div class="d-flex justify-content-between gap-3">
                                    <span><?= (int) $linea->getCantidad() ?>x <?= dato($linea->getNombreProducto()) ?></span>
                                    <span><?= precio($linea->getSubtotal()) ?></span>
                                </div>

                                <?php if (count($fila['mods']) > 0) { ?>
                                    <ul class="list-unstyled mt-1 mb-0 ps-3 small">
                                        <?php foreach ($fila['mods'] as $mod) {
                                            $nombreIngrediente = dato($mod->getNombreIngrediente());
                                            if ($mod->getAccion() === 'quitado') { ?>
                                                <li class="text-secondary text-decoration-line-through">Sin <?= $nombreIngrediente ?></li>
                                            <?php } else { ?>
                                                <li class="text-primary">+ <?= $nombreIngrediente ?></li>
                                            <?php }
                                        } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </section>
            </div>

            <!-- DATOS DEL PEDIDO Y TOTALES -->
            <div class="col-lg-4">
                <aside class="bg-light rounded-4 p-4">
                    <h2 class="fs-2 mb-4">Pedido #<?= (int) $pedido->getId() ?>
                    </h2>

                    <dl class="mb-4">
                        <div class="carrito__fila">
                            <dt>Fecha</dt>
                            <dd><?= fecha($pedido->getFechaPedido(), 'd/m/Y H:i') ?></dd>
                        </div>
                        <div class="carrito__fila">
                            <dt>Método de pago</dt>
                            <dd><?= dato(ucfirst($pedido->getMetodoPago())) ?></dd>
                        </div>
                        <div class="carrito__fila">
                            <dt>Estado</dt>
                            <dd><?= dato(ucfirst($pedido->getEstado())) ?></dd>
                        </div>
                        <div class="carrito__fila">
                            <dt>Subtotal</dt>
                            <dd><?= precio($pedido->getSubtotal()) ?></dd>
                        </div>
                        <?php if ((float) $pedido->getDescuento() > 0) { ?>
                            <div class="carrito__fila">
                                <dt>Descuento</dt>
                                <dd>−<?= precio($pedido->getDescuento()) ?></dd>
                            </div>
                        <?php } ?>
                        <div class="carrito__fila carrito__fila--total">
                            <dt>Total</dt>
                            <dd><?= precio($pedido->getTotal()) ?></dd>
                        </div>
                    </dl>

                    <a class="boton boton--secundario boton--sm w-100"
                        href="<?= url ?>index.php?controller=user&action=puser">
                        Ver mis pedidos
                        <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
                    </a>
                    <p class="mt-3 mb-0 text-center">
                        <a href="<?= url ?>index.php?controller=productos">Volver a la carta</a>
                    </p>
                </aside>
            </div>
        </div>
    <?php } ?>
</div>
