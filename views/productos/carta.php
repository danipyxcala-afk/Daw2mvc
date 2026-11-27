<div class="container">
    <nav>
        <ol class="breadcrumb small mb-4">
            <li class="breadcrumb-item"><a href="<?= url ?>index.php?controller=home">Inicio</a></li>
            <li class="breadcrumb-item active fw-bold">Carta</li>
        </ol>
    </nav>

    <h1>Nuestra carta</h1>

    <!-- Filtros: cada píldora es un enlace a la carta filtrada por su categoría -->
    <nav class="d-flex flex-wrap gap-2">
        <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=Todo"
            class="boton boton--filtro <?= ($_GET['pildora']) == "Todo" ? 'is-activo' : '' ?>">
            Todo
        </a>
        <?php
        foreach ($categoriasActivas as $categoria) { ?>

            <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=<?= $categoria->getNombre() ?>"
                class="boton boton--filtro <?= ($_GET['pildora']) == $categoria->getNombre() ? 'is-activo' : '' ?>">
                <?= texto($categoria->getNombre()) ?>
            </a>
        <?php }
        ?>
    </nav>

    <div class="row gx-5 gy-4 my-4">
        <?php
        $colorPorCategoria = [];
        $posicion = 0;
        foreach ($categoriasActivas as $categoria) {
            $colorPorCategoria[$categoria->getId()] = $coloresCategorias[$posicion % count($coloresCategorias)];
            $posicion++;
        }

        // echo "<pre>";
        // var_dump($listadoProductos);
        // echo "</pre>";
        foreach ($listadoProductos as $out) {
            ?>
            <h2>
                <?php foreach ($categorias as $cat) {
                    if ($cat->getID() == $out[0]->getCategoriaId()) { ?>
                        <?= texto($cat->getNombre()) ?>
                    <?php }
                } ?>
            </h2>
            <?php
            foreach ($out as $producto) {
                //var_dump($listadoProductos);
                if ($producto->getActivo()) {
                    ?>

                    <div class="col-12 col-md-6 col-lg-4 mt-5">
                        <article class="d-flex flex-column h-100 my-2">

                            <a href="<?= url ?>index.php?controller=productos&action=detalle&id=<?= (int) $producto->getId() ?>"
                                class="card-producto__media d-flex flex-column align-items-center p-3 rounded-4 <?= isset($colorPorCategoria[$producto->getCategoriaId()]) ? 'categoria-card--' . $colorPorCategoria[$producto->getCategoriaId()] : '' ?>">
                                <p class="m-0 fw-bold text-white text-center">
                                    <?php foreach ($categorias as $cat) {
                                        if ($cat->getID() == $producto->getCategoriaId()) { ?>
                                            <?= texto($cat->getNombre()) ?>
                                        <?php }
                                    } ?>
                                </p>
                                <img class="card-producto__img flex-grow-1 w-100 object-fit-contain"
                                    src="<?= url . "assets/" . $producto->getImagen() ?>"
                                    alt="<?= texto($producto->getNombre()) ?>" width="400"
                                    height="400" loading="lazy">
                            </a>

                            <!-- flex-grow-1 ocupa el alto que queda, así el precio queda alineado entre tarjetas -->
                            <div class="flex-grow-1 d-flex flex-column pt-3">
                                <h2 class="fs-4 mb-1">
                                    <?= texto($producto->getNombre()) ?>
                                </h2>
                                <p class="small mb-3">
                                    <?= texto($producto->getDescripcion()) ?>
                                </p>

                                <!-- Precio y botones: en el móvil uno debajo del otro, desde sm en fila.
                                     mt-auto lo empuja al final de la tarjeta -->
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3 mt-auto">
                                    <p class="m-0 fw-bold fs-5">
                                        <?= precio((float) $producto->getPrecio()) ?>
                                    </p>
                                    <div class="d-flex flex-column gap-2">
                                        <a href="<?= url ?>index.php?controller=productos&action=detalle&id=<?= (int) $producto->getId() ?>"
                                            class="boton boton--borde boton--sm w-100">
                                            Personalizar producto
                                            <span class="boton__icono boton__icono--flecha"></span>
                                        </a>

                                        <!-- Añade 1 unidad sin personalizar -->
                                        <form method="POST"
                                            action="<?= url ?>index.php?controller=productos&action=anadirCarrito">
                                            <input type="hidden" name="id" value="<?= (int) $producto->getId() ?>">
                                            <input type="hidden" name="cantidad" value="1">
                                            <button class="boton boton--primario boton--sm w-100" type="submit">
                                                Añadir al carrito
                                                <span class="boton__icono boton__icono--carrito"></span>
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </article>
                    </div>
                <?php }
            }
        } ?>
    </div>

</div>
