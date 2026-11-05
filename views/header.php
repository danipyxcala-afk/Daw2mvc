<header class="container">

    <div class="encabezado">
        <a href="<?= url ?>/index.php?controller=home" class="encabezado__logo">
            <img src="<?= url ?>/assets/img/logo/logo-claro.png" alt="Sigmeat" class="logoheader">
        </a>
        <nav class="encabezado__nav">
            <a href="<?= url ?>index.php?controller=home" class="encabezado__enlace">Inicio</a>
            <a href="<?= url ?>index.php?controller=productos"
                class="encabezado__enlace">Carta</a>
        </nav>

        <div class="encabezado__acciones">
            <?php $productosEnCarrito = array_sum(array_column($_SESSION['carrito'] ?? [], 'cantidad')); ?>
            <a href="#" class="btn-icono encabezado__carrito"
                aria-label="Ver carrito, <?= $productosEnCarrito ?> productos">
                <img src="<?= url ?>assets/img/icons/negro/svg/carrito.svg" alt="" width="24" height="24">
                <?php if ($productosEnCarrito > 0) { ?>
                    <span class="encabezado__contador"><?= $productosEnCarrito ?></span>
                <?php } ?>
            </a>
            <a href="#" class="btn-icono" aria-label="Abrir menú">
                <img src="<?= url ?>assets/img/icons/negro/svg/usuario.svg" alt="" width="24" height="24">
            </a>
        </div>
    </div>
</header>