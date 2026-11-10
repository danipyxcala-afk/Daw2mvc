<?php

$usuario = $_SESSION['usuario'];

// Escapa un texto para mostrarlo en HTML. Si está vacío (NULL en la BBDD) muestra una raya
function textoPanel($valor)
{
    return ($valor === null || $valor === '') ? '—' : htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

// Da formato de precio: 12.5 -> 12,50€
function precioPanel($valor)
{
    return number_format((float) $valor, 2, ',', '.') . '€';
}

// "Cliente desde septiembre de 2026": PHP da el mes en inglés, así que usamos nuestra propia lista
$meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$fechaRegistro = strtotime($usuario->getFecha_registro());
?>
<div class="container panel">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <b>Mi cuenta</b>
    </nav>

    <div class="panel__cabecera">
        <h1 class="panel__titulo">Hola, <?= textoPanel($usuario->getNombre()) ?></h1>
        <?php if ($fechaRegistro) { ?>
            <p class="panel__subtitulo">
                Cliente desde <?= $meses[date('n', $fechaRegistro) - 1] ?> de <?= date('Y', $fechaRegistro) ?>
            </p>
        <?php } ?>
    </div>

    <!-- RESUMEN: tres cifras rápidas. En móvil se apilan una debajo de otra -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="resumen__tarjeta">
                <span class="resumen__numero"><?= (int) $resumen['num'] ?></span>
                <span class="resumen__texto"><?= $resumen['num'] === 1 ? 'pedido realizado' : 'pedidos realizados' ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="resumen__tarjeta">
                <span class="resumen__numero"><?= precioPanel($resumen['gastado']) ?></span>
                <span class="resumen__texto">gastados en total</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="resumen__tarjeta">
                <span class="resumen__numero"><?= $resumen['ultimo'] ? textoPanel(ucfirst($resumen['ultimo'])) : '—' ?></span>
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
                <details class="pedido pedido--<?= textoPanel($estado) ?>">
                    <summary class="pedido__resumen">
                        <span class="pedido__numero">Pedido #<?= (int) $pedido->getId() ?></span>
                        <span class="pedido__fecha"><?= date('d/m/Y', strtotime($pedido->getFecha_pedido())) ?></span>
                        <span class="estado estado--<?= textoPanel($estado) ?>"><?= textoPanel(ucfirst($estado)) ?></span>
                        <span class="pedido__total"><?= precioPanel($pedido->getTotal()) ?></span>
                    </summary>

                    <div class="pedido__detalle">
                        <ul class="pedido__lineas">
                            <?php foreach ($lineas as $fila) {
                                $linea = $fila['linea'];
                                ?>
                                <li class="pedido__linea">
                                    <div class="pedido__producto">
                                        <span><?= (int) $linea->getCantidad() ?>x <?= textoPanel($linea->getNombre_producto()) ?></span>
                                        <span><?= precioPanel($linea->getSubtotal()) ?></span>
                                    </div>

                                    <?php if (count($fila['mods']) > 0) { ?>
                                        <ul class="pedido__mods">
                                            <?php foreach ($fila['mods'] as $mod) {
                                                $nombreIngrediente = textoPanel($mod->getNombre_ingrediente());
                                                if ($mod->getAccion() === 'quitado') { ?>
                                                    <li class="pedido__mod--quitado">− Sin <?= $nombreIngrediente ?></li>
                                                <?php } else { ?>
                                                    <!-- La clase va sin ñ (anadido) para evitar problemas en el CSS -->
                                                    <li class="pedido__mod--anadido">
                                                        + <?= $nombreIngrediente ?>
                                                        <?php if ((float) $mod->getPrecio_extra() > 0) { ?>
                                                            (<?= precioPanel($mod->getPrecio_extra()) ?>)
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
                            <dd><?= precioPanel($pedido->getSubtotal()) ?></dd>

                            <?php if ((float) $pedido->getDescuento() > 0) { ?>
                                <dt>Descuento</dt>
                                <dd>−<?= precioPanel($pedido->getDescuento()) ?></dd>
                            <?php } ?>

                            <dt class="pedido__totales-final">Total</dt>
                            <dd class="pedido__totales-final"><?= precioPanel($pedido->getTotal()) ?></dd>

                            <dt>Pago</dt>
                            <dd><?= textoPanel(ucfirst($pedido->getEstado_pago())) ?></dd>
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
                    <dd class="datos__valor"><?= textoPanel($usuario->getNombre()) ?></dd>

                    <dt class="datos__campo">Email</dt>
                    <dd class="datos__valor"><?= textoPanel($usuario->getEmail()) ?></dd>

                    <dt class="datos__campo">Teléfono</dt>
                    <dd class="datos__valor"><?= textoPanel($usuario->getTelefono()) ?></dd>

                    <dt class="datos__campo">Dirección</dt>
                    <dd class="datos__valor"><?= textoPanel($usuario->getDireccion()) ?></dd>

                    <dt class="datos__campo">Fecha de nacimiento</dt>
                    <dd class="datos__valor">
                        <?= $usuario->getFecha_nacimiento() ? date('d/m/Y', strtotime($usuario->getFecha_nacimiento())) : '—' ?>
                    </dd>
                </dl>
            </section>

            <?php if (count($codigos) > 0) { ?>
                <section class="panel__tarjeta">
                    <h2 class="panel__seccion">Tus códigos</h2>
                    <?php foreach ($codigos as $codigo) { ?>
                        <div class="codigo">
                            <span class="codigo__texto"><?= textoPanel($codigo->getCodigo()) ?></span>
                            <p class="codigo__desc"><?= textoPanel($codigo->getDescripcion()) ?></p>
                        </div>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
    </div>
</div>
