
<div class="container carrito">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <a href="<?= url ?>index.php?controller=carrito">Carrito</a> /
        <b>Datos y pago</b>
    </nav>

    <h1 class="carrito__titulo">Datos y pago</h1>

    <!-- PASOS DEL PEDIDO-->
    <ol class="pasos" aria-label="Pasos del pedido">
        <li class="pasos__paso">
            <span class="pasos__numero">1</span> Carrito
        </li>
        <li class="pasos__paso is-activo" aria-current="step">
            <span class="pasos__numero">2</span> Datos y pago
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">3</span> Confirmación
        </li>
    </ol>

    <div class="row g-4">
        <div class="col-lg-8">
            <form id="form-pago" method="POST" action="<?= url ?>index.php?controller=carrito&action=confirmar">

                <!-- DATOS DE ENTREGA -->
                <section class="panel__tarjeta mb-4" aria-labelledby="pago-datos-titulo">
                    <h2 class="panel__seccion" id="pago-datos-titulo">Datos de entrega</h2>
                    <?php if ($usuario) { ?>
                        <dl class="datos">
                            <dt class="datos__campo">Nombre</dt>
                            <dd class="datos__valor"><?= dato($usuario->getNombre()) ?></dd>

                            <dt class="datos__campo">Email</dt>
                            <dd class="datos__valor"><?= dato($usuario->getEmail()) ?></dd>

                            <dt class="datos__campo">Teléfono</dt>
                            <dd class="datos__valor"><?= dato($usuario->getTelefono()) ?></dd>

                            <dt class="datos__campo">Dirección</dt>
                            <dd class="datos__valor"><?= dato($usuario->getDireccion()) ?></dd>
                        </dl>
                        <p class="mt-3 mb-0">
                            <a href="<?= url ?>index.php?controller=user&action=puser">Ver mis datos en Mi cuenta</a>
                        </p>
                    <?php } ?>
                </section>

                <!-- MÉTODO DE PAGO -->
                <fieldset class="panel__tarjeta mb-4">
                    <legend class="panel__seccion">Método de pago</legend>
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
            <aside class="carrito__resumen" aria-labelledby="pago-resumen-titulo">
                <h2 class="carrito__subtitulo" id="pago-resumen-titulo">Tu pedido</h2>

                <ul class="pedido__lineas">
                    <?php foreach ($lineas as $linea) {
                        $cantidad = (int) $linea['cantidad'];
                        $quitados = $linea['quitados'] ?? [];
                        $extras = $linea['extras'] ?? [];
                        ?>
                        <li class="pedido__linea">
                            <div class="pedido__producto">
                                <span><?= $cantidad ?>x <?= dato($linea['nombre']) ?></span>
                                <span><?= precio((float) $linea['precio_unitario'] * $cantidad) ?></span>
                            </div>
                            <?php if (count($quitados) + count($extras) > 0) { ?>
                                <ul class="pedido__mods">
                                    <?php foreach ($quitados as $quitado) { ?>
                                        <li class="pedido__mod--quitado">Sin <?= dato($quitado['nombre']) ?></li>
                                    <?php } ?>
                                    <?php foreach ($extras as $extra) { ?>
                                        <li class="pedido__mod--anadido">+ <?= dato($extra['nombre']) ?></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>

                <dl class="carrito__totales">
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
                <button class="boton boton--secundario boton--bloque carrito__continuar" type="submit" form="form-pago">
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
