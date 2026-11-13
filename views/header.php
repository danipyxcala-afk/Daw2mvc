<header class="container">

    <div class="encabezado">
        <a href="<?= url ?>index.php?controller=home" class="encabezado__logo">
            <img src="<?= url ?>/assets/img/logo/logo-claro.svg" alt="Sigmeat" class="logo">
        </a>
        <nav class="encabezado__nav">
            <a href="<?= url ?>index.php?controller=home" class="encabezado__enlace">Inicio</a>
            <a href="<?= url ?>index.php?controller=productos"
                class="encabezado__enlace">Carta</a>
        </nav>

        <div class="encabezado__acciones">
            <?php $productosEnCarrito = array_sum(array_column($_SESSION['carrito'] ?? [], 'cantidad')); ?>
            <a href="<?= url ?>index.php?controller=carrito" class="boton-icono encabezado__carrito"
                aria-label="Ver carrito, <?= $productosEnCarrito ?> productos">
                <img src="<?= url ?>assets/img/icons/negro/svg/carrito.svg" alt="" width="24" height="24">
                <?php if ($productosEnCarrito > 0) { ?>
                    <span class="encabezado__contador"><?= $productosEnCarrito ?></span>
                <?php } ?>
            </a>
            <a href="<?= url ?>index.php?controller=user" class="boton-icono" aria-label="Mi cuenta">
                <img src="<?= url ?>assets/img/icons/negro/svg/usuario.svg" alt="" width="24" height="24">
            </a>
            <!-- Cerrar sesión: solo aparece si hay un usuario con la sesión iniciada -->
            <?php if (isset($_SESSION['usuario'])) { ?>
                <a href="<?= url ?>index.php?controller=user&action=logout" class="boton-icono"
                    aria-label="Cerrar sesión" title="Cerrar sesión">
                    <img src="<?= url ?>assets/img/icons/negro/svg/cerrar.svg" alt="" width="24" height="24">
                </a>
            <?php } ?>
        </div>
    </div>
</header>
