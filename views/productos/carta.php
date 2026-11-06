<body>
    <div class="container">
        <nav class="producto__migas">
            <a href="<?= url ?>index.php?controller=home">Inicio</a> / 
            <a href="<?= url ?>index.php?controller=productos">Carta</a>
        </nav>

        <h1>Nuestra carta</h1>

        <div class="container">
            <form action="<?= url ?>productos/carta?" method="GET">
                <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=Todo"
                    class="boton boton--filtro <?= ($_GET['pildora']) == "Todo" ? 'is-activo' : '' ?>">
                    Todo
                </a>
                <?php
                foreach ($categoriasActivas as $categoria) { ?>

                    <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=<?= $categoria->getNombre() ?>"
                        class="boton boton--filtro <?= ($_GET['pildora']) == $categoria->getNombre() ? 'is-activo' : '' ?>">
                        <?= htmlspecialchars($categoria->getNombre(), ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php }
                ?>

            </form>
        </div>

        <div class="row g-4 my-4">
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

                foreach ($out as $producto) {
                    //var_dump($listadoProductos);
                    if ($producto->getActivo()) {
                        ?>

                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card-producto">

                                <a href="<?= url ?>index.php?controller=productos&action=detalle&id=<?= (int) $producto->getId() ?>"
                                    class="card-producto__media <?= isset($colorPorCategoria[$producto->getCategoria_id()]) ? 'categoria-card--' . $colorPorCategoria[$producto->getCategoria_id()] : '' ?>">
                                    <p class="card-producto__categoria">
                                        <?php foreach ($categorias as $cat) {
                                            if ($cat->getID() == $producto->getCategoria_id()) { ?>
                                                <?= htmlspecialchars($cat->getNombre(), ENT_QUOTES, 'UTF-8') ?>
                                            <?php }
                                        } ?>
                                    </p>
                                    <img class="card-producto__img" src="<?= url . "assets/" . $producto->getImagen() ?>"
                                        alt="<?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>" width="400"
                                        height="400" loading="lazy">
                                </a>

                                <div class="card-producto__info">
                                    <h2 class="card-producto__nombre">
                                        <?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>
                                    </h2>
                                    <p class="card-producto__desc">
                                        <?= htmlspecialchars($producto->getDescripcion(), ENT_QUOTES, 'UTF-8') ?>
                                    </p>

                                    <div class="card-producto__pie">
                                        <p class="card-producto__precio">
                                            <?= htmlspecialchars($producto->getprecio(), ENT_QUOTES, 'UTF-8') ?>€
                                        </p>

                                        <a href="<?= url ?>index.php?controller=productos&action=detalle&id=<?= (int) $producto->getId() ?>"
                                            class="boton boton--primario boton--sm" aria-label="Editar producto">
                                            Editar
                                        </a>

                                        <a href="#" class="btn-icono btn-icono--primario" aria-label="Añadir producto">
                                            <img src="<?= url ?>assets/img/icons/azul/svg/mas-circulo.svg" alt="" width="32"
                                                height="32">
                                        </a>

                                    </div>

                                </div>
                            </article>
                        </div>
                    <?php }
                }
            } ?>
        </div>

    </div>
</body>