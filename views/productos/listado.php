<div class="container">
    <h1>Nuestra carta</h1>

    <div class="row g-4 my-4">
        <?php foreach ($productos as $producto) { ?>
            <div class="col-12 col-md-6 col-lg-4">
                <article class="card-producto">

                    <div class="card-producto__media">
                        <p class="card-producto__categoria">
                            <?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <img class="card-producto__img" src="<?= url ?>assets/img/productos/veggie-burger.png"
                            alt="<?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>" width="400"
                            height="400" loading="lazy">
                    </div>

                    <div class="card-producto__info">
                        <h2 class="card-producto__nombre">
                            <?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                        <p class="card-producto__desc">
                            <?= htmlspecialchars($producto->getTalla(), ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <div class="card-producto__pie">
                            <p class="card-producto__precio">10.00€</p>
                            <a href="#" class="btn-icono btn-icono--primario" aria-label="Añadir producto">
                                <img src="<?= url ?>assets/img/icons/azul/svg/mas-circulo.svg" alt="" width="32"
                                    height="32">
                            </a>
                        </div>
                    </div>

                </article>
            </div>
        <?php } ?>
    </div>


    <div class="tabla-contenedor" hidden>
        <p><a href="?controller=producto&action=create" class="boton boton--primario boton--sm">Crear producto</a></p>

        <table class="tabla">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Talla</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($productos)) { ?>
                    <tr>
                        <td colspan="4">No hay productos todavía.</td>
                    </tr>
                <?php } ?>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td><?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($producto->getTalla(), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= number_format((float) $producto->getPrecio(), 2, ',', '.') ?> €</td>
                        <td class="tabla__acciones">
                            <a href="?controller=producto&action=show&id=<?= (int) $producto->getId() ?>">Ver</a>
                            <a href="?controller=producto&action=destroy&id=<?= (int) $producto->getId() ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>