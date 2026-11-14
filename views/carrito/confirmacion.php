
<div class="container carrito">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <b>Pedido confirmado</b>
    </nav>

    <ol class="pasos" aria-label="Pasos del pedido">
        <li class="pasos__paso">
            <span class="pasos__numero">1</span> Carrito
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">2</span> Datos y pago
        </li>
        <li class="pasos__paso is-activo" aria-current="step">
            <span class="pasos__numero">3</span> Confirmación
        </li>
    </ol>

    <?php if (!$pedido) { ?>
        <!-- Por si se entra a esta página sin haber hecho ningún pedido -->
        <div class="carrito__vacio">
            <p>No hay ningún pedido que mostrar.</p>
            <a class="boton boton--primario" href="<?= url ?>index.php?controller=productos">Ver la carta</a>
        </div>
    <?php } else { ?>
        <!-- MENSAJE PRINCIPAL -->
        <div class="text-center mb-5">
            <img src="<?= url ?>assets/img/icons/negro/svg/check-circulo.svg" alt="" width="56" height="56" class="mb-3">
            <h1 class="carrito__titulo">¡Pedido confirmado!</h1>
            <p class="mb-0">
                Gracias<?= $usuario ? ', ' . dato($usuario->getNombre()) : '' ?>.
                Hemos recibido tu pedido y ya nos ponemos con él.
            </p>
        </div>

        <div class="row g-4">
            <!-- PRODUCTOS DEL PEDIDO -->
            <div class="col-lg-8">
                <section class="panel__tarjeta" aria-labelledby="confirmacion-productos-titulo">
                    <h2 class="panel__seccion" id="confirmacion-productos-titulo">Tu pedido</h2>
                    <ul class="pedido__lineas">
                        <?php foreach ($detalles as $fila) {
                            $linea = $fila['linea'];
                            ?>
                            <li class="pedido__linea">
                                <div class="pedido__producto">
                                    <span><?= (int) $linea->getCantidad() ?>x <?= dato($linea->getNombreProducto()) ?></span>
                                    <span><?= precio($linea->getSubtotal()) ?></span>
                                </div>

                                <?php if (count($fila['mods']) > 0) { ?>
                                    <ul class="pedido__mods">
                                        <?php foreach ($fila['mods'] as $mod) {
                                            $nombreIngrediente = dato($mod->getNombreIngrediente());
                                            if ($mod->getAccion() === 'quitado') { ?>
                                                <li class="pedido__mod--quitado">Sin <?= $nombreIngrediente ?></li>
                                            <?php } else { ?>
                                                <li class="pedido__mod--anadido">+ <?= $nombreIngrediente ?></li>
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
                <aside class="carrito__resumen" aria-labelledby="confirmacion-resumen-titulo">
                    <h2 class="carrito__subtitulo" id="confirmacion-resumen-titulo">Pedido #<?= (int) $pedido->getId() ?>
                    </h2>

                    <dl class="carrito__totales">
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

                    <a class="boton boton--secundario boton--bloque carrito__continuar"
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
