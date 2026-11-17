<?php
$nombreProducto = texto($producto->getNombre());
$nombreCategoria = $categoria ? $categoria->getNombre() : '';
$precio = (float) $producto->getPrecio();
?>
<div class="container mb-5">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=productos">Carta</a></li>
            <li class="breadcrumb-item">
                <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=<?= urlencode($nombreCategoria) ?>">
                    <?= texto($nombreCategoria) ?>
                </a>
            </li>
            <li class="breadcrumb-item active fw-bold"><?= $nombreProducto ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-5">
            <div class="producto__media d-flex align-items-center justify-content-center p-4 rounded-4 <?= $colorCategoria ? 'categoria-card--' . $colorCategoria : '' ?>">
                <img class="w-100 h-100 object-fit-contain" src="<?= url . "assets/" . $producto->getImagen() ?>"
                    alt="<?= $nombreProducto ?>" width="610" height="409">
            </div>
        </div>

        <div class="col-md-7">
            <h1 class="fs-1 mb-1"><?= $nombreProducto ?></h1>
            <p class="fw-bold fs-4 text-primary mb-2"><?= precio($precio) ?></p>
            <p><?= texto($producto->getDescripcion()) ?></p>

            <!-- data-precio guarda el precio para que el JavaScript calcule el total -->
            <form id="form-producto" method="POST" data-precio="<?= $precio ?>"
                action="<?= url ?>index.php?controller=productos&action=anadirCarrito">
                <input type="hidden" name="id" value="<?= (int) $producto->getId() ?>">

                <?php if (count($ingredientesBase) > 0) { ?>
                    <!-- Bootstrap ya le quita al fieldset el borde y el relleno que trae -->
                    <fieldset class="mt-4">
                        <legend class="fw-bold small text-uppercase text-primary mb-2">Ingredientes base</legend>
                        <!-- row-cols: 2 píldoras por fila en el móvil y 4 desde sm -->
                        <div class="row row-cols-2 row-cols-sm-4 g-2">
                            <?php foreach ($ingredientesBase as $ingrediente) {
                                $nombre = texto($ingrediente['nombre']);
                                $unidades = (int) $ingrediente['cantidad'];
                                ?>
                                <!-- Marcar la casilla significa quitar el ingrediente -->
                                <label>
                                    <input class="ingrediente__check visually-hidden" type="checkbox" name="quitados[]"
                                        value="<?= (int) $ingrediente['id'] ?>"
                                        <?= $ingrediente['fija'] ? 'disabled data-fija="1"' : '' ?>>
                                    <span class="ingrediente__nombre d-flex align-items-center justify-content-center h-100 px-3 py-1 rounded-pill text-white small text-center">
                                        <?= $nombre ?><?= $unidades > 1 ? ' x' . $unidades : '' ?>
                                    </span>
                                </label>
                            <?php } ?>
                        </div>
                    </fieldset>
                <?php } ?>

                <?php if (count($extras) > 0) { ?>
                    <fieldset class="mt-4">
                        <legend class="fw-bold small text-uppercase text-primary mb-2">Añade extras</legend>
                        <?php foreach ($extras as $extra) { ?>
                            <label class="extra d-flex align-items-center gap-3 mb-2 p-3 border border-primary rounded-2">
                                <input class="extra__check flex-shrink-0" type="checkbox" name="extras[]"
                                    value="<?= (int) $extra['id'] ?>" data-precio="<?= (float) $extra['precio_extra'] ?>">
                                <span class="flex-grow-1 fw-bold"><?= texto($extra['nombre']) ?></span>
                                <span class="fw-bold small">+<?= precio((float) $extra['precio_extra']) ?></span>
                            </label>
                        <?php } ?>
                    </fieldset>
                <?php } ?>

                <div class="d-flex justify-content-between align-items-center mt-4 py-2 border-top border-bottom border-primary fw-bold fs-2">
                    <span>Total</span>
                    <output id="producto-total"><?= precio($precio) ?></output>
                </div>

                <!-- Cantidad y botón: en el móvil uno debajo del otro, desde sm en fila -->
                <div class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-4 mt-3">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <label class="fw-bold" for="producto-cantidad">Cantidad</label>
                        <div class="d-flex align-items-center rounded-pill bg-light">
                            <button class="cantidad__boton" type="button" id="cantidad-menos">-</button>
                            <input class="cantidad__numero" type="number" id="producto-cantidad" name="cantidad"
                                value="1" min="1" max="99">
                            <button class="cantidad__boton" type="button" id="cantidad-mas">+</button>
                        </div>
                    </div>
                    <button class="boton boton--primario flex-grow-1" type="submit" id="producto-anadir">
                        Añadir 1 al carrito
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
