<?php
$nombreProducto = htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8');
$nombreCategoria = $categoria ? $categoria->getNombre() : '';
$precio = (float) $producto->getPrecio();
?>
<div class="container producto">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <a href="<?= url ?>index.php?controller=productos">Carta</a> /
        <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=<?= urlencode($nombreCategoria) ?>">
            <?= htmlspecialchars($nombreCategoria, ENT_QUOTES, 'UTF-8') ?>
        </a> /
        <b><?= $nombreProducto ?></b>
    </nav>

    <div class="row g-5">
        <div class="col-md-5">
            <div class="producto__media <?= $colorCategoria ? 'categoria-card--' . $colorCategoria : '' ?>">
                <img class="producto__img" src="<?= url . "assets/" . $producto->getImagen() ?>"
                    alt="<?= $nombreProducto ?>" width="610" height="409">
            </div>
        </div>

        <div class="col-md-7">
            <h1 class="producto__nombre"><?= $nombreProducto ?></h1>
            <p class="producto__precio"><?= number_format($precio, 2, ',', '.') ?>€</p>
            <p><?= htmlspecialchars($producto->getDescripcion(), ENT_QUOTES, 'UTF-8') ?></p>

            <!-- data-precio guarda el precio para que el JavaScript calcule el total -->
            <form id="form-producto" method="POST" data-precio="<?= $precio ?>"
                action="<?= url ?>index.php?controller=productos&action=anadirCarrito">
                <input type="hidden" name="id" value="<?= (int) $producto->getId() ?>">

                <?php if (count($ingredientesBase) > 0) { ?>
                    <fieldset class="producto__grupo">
                        <legend class="producto__subtitulo">Ingredientes base</legend>
                        <div class="producto__ingredientes">
                            <?php foreach ($ingredientesBase as $ingrediente) {
                                $nombre = htmlspecialchars($ingrediente['nombre'], ENT_QUOTES, 'UTF-8');
                                $unidades = (int) $ingrediente['cantidad'];
                                ?>
                                <!-- Marcar la casilla significa quitar el ingrediente -->
                                <label class="ingrediente">
                                    <input class="ingrediente__check visually-hidden" type="checkbox" name="quitados[]"
                                        value="<?= (int) $ingrediente['id'] ?>" aria-label="Quitar <?= $nombre ?>"
                                        <?= $ingrediente['fija'] ? 'disabled data-fija="1"' : '' ?>>
                                    <span class="ingrediente__nombre">
                                        <?= $nombre ?><?= $unidades > 1 ? ' x' . $unidades : '' ?>
                                    </span>
                                </label>
                            <?php } ?>
                        </div>
                    </fieldset>
                <?php } ?>

                <?php if (count($extras) > 0) { ?>
                    <fieldset class="producto__grupo">
                        <legend class="producto__subtitulo">Añade extras</legend>
                        <?php foreach ($extras as $extra) { ?>
                            <label class="extra">
                                <input class="extra__check" type="checkbox" name="extras[]"
                                    value="<?= (int) $extra['id'] ?>" data-precio="<?= (float) $extra['precio_extra'] ?>">
                                <span class="extra__nombre"><?= htmlspecialchars($extra['nombre'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="extra__precio">+<?= number_format((float) $extra['precio_extra'], 2, ',', '.') ?>€</span>
                            </label>
                        <?php } ?>
                    </fieldset>
                <?php } ?>

                <div class="producto__total">
                    <span>Total</span>
                    <output id="producto-total"><?= number_format($precio, 2, ',', '.') ?>€</output>
                </div>

                <div class="producto__comprar">
                    <div class="cantidad">
                        <label class="cantidad__texto" for="producto-cantidad">Cantidad</label>
                        <div class="cantidad__selector">
                            <button class="cantidad__boton" type="button" id="cantidad-menos" aria-label="Quitar uno">-</button>
                            <input class="cantidad__numero" type="number" id="producto-cantidad" name="cantidad"
                                value="1" min="1" max="99">
                            <button class="cantidad__boton" type="button" id="cantidad-mas" aria-label="Añadir uno">+</button>
                        </div>
                    </div>
                    <button class="boton boton--primario producto__anadir" type="submit" id="producto-anadir">
                        Añadir 1 al carrito
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
