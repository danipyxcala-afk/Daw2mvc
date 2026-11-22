<?php

$usuario = $_SESSION['usuario'];
$clienteDesde = mesAnio($usuario->getFechaRegistro());
?>
<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item active fw-bold">Mi cuenta</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h1 class="fs-1 mb-1">Hola, <?= dato($usuario->getNombre()) ?></h1>
        <?php if ($clienteDesde !== '') { ?>
            <!-- text-secondary es nuestro azul medio: el gris se lee mal sobre blanco -->
            <p class="mb-0 text-secondary">
                Cliente desde <?= $clienteDesde ?>
            </p>
        <?php } ?>
    </div>

    <!-- RESUMEN: las tres cifras de arriba. h-100 hace que las tres midan lo mismo -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="h-100 p-4 bg-primary-subtle rounded-4">
                <span class="d-block fw-bold fs-2 lh-sm"><?= (int) $resumen['num'] ?></span>
                <span class="d-block text-secondary"><?= $resumen['num'] === 1 ? 'pedido realizado' : 'pedidos realizados' ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="h-100 p-4 bg-primary-subtle rounded-4">
                <span class="d-block fw-bold fs-2 lh-sm"><?= precio($resumen['gastado']) ?></span>
                <span class="d-block text-secondary">gastados en total</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="h-100 p-4 bg-primary-subtle rounded-4">
                <span class="d-block fw-bold fs-2 lh-sm"><?= $resumen['ultimo'] ? dato(ucfirst($resumen['ultimo'])) : '—' ?></span>
                <span class="d-block text-secondary">estado del último pedido</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- HISTORIAL DE PEDIDOS -->
        <div class="col-lg-8">
            <h2 class="fs-4 mb-3">Mis pedidos</h2>

            <?php if (count($pedidos) === 0) { ?>
                <div class="bg-light rounded-4 p-4 text-center">
                    <p>Todavía no has hecho ningún pedido.</p>
                    <a class="boton boton--primario" href="<?= url ?>index.php?controller=productos">Ver la carta</a>
                </div>
            <?php } ?>

            <?php foreach ($pedidos as $pedido) {
                $estado = $pedido->getEstado();
                $lineas = $detalles[$pedido->getId()] ?? [];
                ?>
                <!-- Cada pedido se abre y se cierra al pulsarlo, sin JavaScript -->
                <details class="pedido pedido--<?= dato($estado) ?> mb-3 bg-light rounded-4">
                    <summary class="pedido__resumen d-flex flex-wrap align-items-center column-gap-3 row-gap-2 py-3 px-3 px-sm-4">
                        <span class="fw-bold fs-5">Pedido #<?= (int) $pedido->getId() ?></span>
                        <span class="text-secondary"><?= fecha($pedido->getFechaPedido()) ?></span>
                        <span class="badge rounded-pill estado--<?= dato($estado) ?>"><?= dato(ucfirst($estado)) ?></span>
                        <!-- ms-auto lo empuja a la derecha, junto a la flecha -->
                        <span class="pedido__total ms-auto fw-bold fs-5"><?= precio($pedido->getTotal()) ?></span>
                    </summary>

                    <div class="mx-3 mx-sm-4 py-3 border-top">
                        <ul class="list-unstyled mb-3">
                            <?php foreach ($lineas as $fila) {
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
                                                    <li class="text-secondary text-decoration-line-through">− Sin <?= $nombreIngrediente ?></li>
                                                <?php } else { ?>
                                                    <li class="text-primary">
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

                        <dl class="pedido__totales mb-0">
                            <dt>Subtotal</dt>
                            <dd><?= precio($pedido->getSubtotal()) ?></dd>

                            <?php if ((float) $pedido->getDescuento() > 0) { ?>
                                <dt>Descuento</dt>
                                <dd>−<?= precio($pedido->getDescuento()) ?></dd>
                            <?php } ?>

                            <dt class="fw-bold">Total</dt>
                            <dd class="fw-bold"><?= precio($pedido->getTotal()) ?></dd>

                            <dt>Pago</dt>
                            <dd><?= dato(ucfirst($pedido->getEstadoPago())) ?></dd>
                        </dl>
                    </div>
                </details>
            <?php } ?>
        </div>

        <!-- COLUMNA DERECHA: datos y códigos. En el móvil queda debajo de los pedidos -->
        <div class="col-lg-4">
            <section class="bg-light rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fs-4">Mis datos</h2>
                    <!-- El editar llama al modal de abajo del todo del codigo -->
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditarDatos">
                        Editar
                    </button>
                </div>
                <dl class="mb-0">
                    <dt class="small">Nombre</dt>
                    <dd class="mb-3 text-break"><?= dato($usuario->getNombre()) ?></dd>

                    <dt class="small">Email</dt>
                    <dd class="mb-3 text-break"><?= dato($usuario->getEmail()) ?></dd>

                    <dt class="small">Teléfono</dt>
                    <dd class="mb-3 text-break"><?= dato($usuario->getTelefono()) ?></dd>

                    <dt class="small">Dirección</dt>
                    <dd class="mb-3 text-break"><?= dato($usuario->getDireccion()) ?></dd>

                    <dt class="small">Fecha de nacimiento</dt>
                    <dd class="mb-0">
                        <?= fecha($usuario->getFechaNacimiento()) ?>
                    </dd>
                </dl>
            </section>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditarDatos" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= url ?>index.php?controller=user&action=actualizarDatos">
            <div class="modal-header">
                <h2 class="modal-title fs-5">Editar mis datos</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Déjala vacía para no cambiarla">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= dato($usuario->getEmail()) ?>">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= dato($usuario->getTelefono()) ?>">
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?= dato($usuario->getDireccion()) ?>">
                </div>
                <div class="mb-3">
                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?= dato($usuario->getFechaNacimiento()) ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
