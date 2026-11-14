<?php

$usuario = $_SESSION['usuario'];
$clienteDesde = mesAnio($usuario->getFechaRegistro());
?>
<div class="container panel">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <b>Mi cuenta</b>
    </nav>

    <div class="panel__cabecera">
        <h1 class="panel__titulo">Hola, <?= dato($usuario->getNombre()) ?></h1>
        <?php if ($clienteDesde !== '') { ?>
            <p class="panel__subtitulo">
                Cliente desde <?= $clienteDesde ?>
            </p>
        <?php } ?>
    </div>

    <!-- RESUMEN -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="resumen__tarjeta">
                <span class="resumen__numero"><?= (int) $resumen['num'] ?></span>
                <span class="resumen__texto"><?= $resumen['num'] === 1 ? 'pedido realizado' : 'pedidos realizados' ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="resumen__tarjeta">
                <span class="resumen__numero"><?= precio($resumen['gastado']) ?></span>
                <span class="resumen__texto">gastados en total</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="resumen__tarjeta">
                <span class="resumen__numero"><?= $resumen['ultimo'] ? dato(ucfirst($resumen['ultimo'])) : '—' ?></span>
                <span class="resumen__texto">estado del último pedido</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- HISTORIAL DE PEDIDOS -->
        <div class="col-lg-8">
            <h2 class="panel__seccion">Mis pedidos</h2>

            <?php if (count($pedidos) === 0) { ?>
                <div class="panel__vacio">
                    <p>Todavía no has hecho ningún pedido.</p>
                    <a class="boton boton--primario" href="<?= url ?>index.php?controller=productos">Ver la carta</a>
                </div>
            <?php } ?>

            <?php foreach ($pedidos as $pedido) {
                $estado = $pedido->getEstado();
                $lineas = $detalles[$pedido->getId()] ?? [];
                ?>
                <!-- Cada pedido se abre y se cierra al pulsarlo, sin JavaScript -->
                <details class="pedido pedido--<?= dato($estado) ?>">
                    <summary class="pedido__resumen">
                        <span class="pedido__numero">Pedido #<?= (int) $pedido->getId() ?></span>
                        <span class="pedido__fecha"><?= fecha($pedido->getFechaPedido()) ?></span>
                        <span class="estado estado--<?= dato($estado) ?>"><?= dato(ucfirst($estado)) ?></span>
                        <span class="pedido__total"><?= precio($pedido->getTotal()) ?></span>
                    </summary>

                    <div class="pedido__detalle">
                        <ul class="pedido__lineas">
                            <?php foreach ($lineas as $fila) {
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
                                                    <li class="pedido__mod--quitado">− Sin <?= $nombreIngrediente ?></li>
                                                <?php } else { ?>
                                                    <!-- La clase va sin ñ (anadido) para evitar problemas en el CSS -->
                                                    <li class="pedido__mod--anadido">
                                                        + <?= $nombreIngrediente ?>
                                                        <?php if ((float) $mod->getPrecioExtra() > 0) { ?>
                                                            (<?= precio($mod->getPrecioExtra()) ?>)
                                                        <?php } ?>
                                                    </li>
                                                <?php }
                                            } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>

                        <dl class="pedido__totales">
                            <dt>Subtotal</dt>
                            <dd><?= precio($pedido->getSubtotal()) ?></dd>

                            <?php if ((float) $pedido->getDescuento() > 0) { ?>
                                <dt>Descuento</dt>
                                <dd>−<?= precio($pedido->getDescuento()) ?></dd>
                            <?php } ?>

                            <dt class="pedido__totales-final">Total</dt>
                            <dd class="pedido__totales-final"><?= precio($pedido->getTotal()) ?></dd>

                            <dt>Pago</dt>
                            <dd><?= dato(ucfirst($pedido->getEstadoPago())) ?></dd>
                        </dl>
                    </div>
                </details>
            <?php } ?>
        </div>

        <!-- COLUMNA DERECHA: datos y códigos. En móvil queda debajo de los pedidos -->
        <div class="col-lg-4">
            <section class="panel__tarjeta mb-4">
                <h2 class="panel__seccion">Mis datos</h2>
                <dl class="datos">
                    <dt class="datos__campo">Nombre</dt>
                    <dd class="datos__valor"><?= dato($usuario->getNombre()) ?></dd>

                    <dt class="datos__campo">Email</dt>
                    <dd class="datos__valor"><?= dato($usuario->getEmail()) ?></dd>

                    <dt class="datos__campo">Teléfono</dt>
                    <dd class="datos__valor"><?= dato($usuario->getTelefono()) ?></dd>

                    <dt class="datos__campo">Dirección</dt>
                    <dd class="datos__valor"><?= dato($usuario->getDireccion()) ?></dd>

                    <dt class="datos__campo">Fecha de nacimiento</dt>
                    <dd class="datos__valor">
                        <?= fecha($usuario->getFechaNacimiento()) ?>
                    </dd>
                </dl>
            </section>

            <?php if (count($codigos) > 0) { ?>
                <section class="panel__tarjeta">
                    <h2 class="panel__seccion">Tus códigos</h2>
                    <?php foreach ($codigos as $codigo) { ?>
                        <div class="codigo">
                            <span class="codigo__texto"><?= dato($codigo->getCodigo()) ?></span>
                            <p class="codigo__desc"><?= dato($codigo->getDescripcion()) ?></p>
                        </div>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
    </div>
</div>
