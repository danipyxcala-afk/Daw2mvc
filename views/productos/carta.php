<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <p>Inicio / <b>Carta</b></p>

        <h1>Nuestra carta</h1>

        <div class="container">
            <button type="button" class="boton boton--filtro">Todo</button>

            <?php
            foreach ($categorias as $categoria) { ?>
                <button type="button"
                    class="boton boton--filtro"><?= htmlspecialchars($categoria->getNombre(), ENT_QUOTES, 'UTF-8') ?></button>

            <?php }
            ?>
        </div>

        <div class="row g-4 my-4">
            <?php
            foreach ($listadoProductos as $test) {
                foreach ($test as $producto) {
                    //var_dump($producto);
                    if ($producto->getActivo()) {
                        ?>

                        <div class="col-12 col-md-6 col-lg-4">
                            <article class="card-producto">

                                <div class="card-producto__media">
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
                                </div>

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

                                        <a href="#" class="boton boton--primario boton--sm" aria-label="Editar producto">
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

</html>