<header class="container sticky-top mb-4 mb-sm-5">

    <!-- La barra: el logo y los iconos llevan "col" para medir lo mismo y que el menú quede en el centro -->
    <div class="encabezado d-flex align-items-center justify-content-between gap-3 position-relative px-3 px-md-4 py-2 rounded-pill">
        <a href="<?= url ?>index.php?controller=home" class="col d-flex">
            <img src="<?= url ?>/assets/img/logo/logo-claro.svg" alt="Sigmeat" class="logo">
        </a>

        <!-- Menú de texto: solo en ordenador (lg o más), en tablet y móvil va dentro de la hamburguesa -->
        <nav class="d-none d-lg-flex gap-5">
            <a href="<?= url ?>index.php?controller=home" class="fw-bold fs-5 py-2">Inicio</a>
            <a href="<?= url ?>index.php?controller=productos" class="fw-bold fs-5 py-2">Carta</a>
        </nav>

        <div class="col d-flex justify-content-end align-items-center gap-2">
            <?php $productosEnCarrito = array_sum(array_column($_SESSION['carrito'] ?? [], 'cantidad')); ?>
            <a href="<?= url ?>index.php?controller=carrito" class="boton-icono position-relative">
                <img src="<?= url ?>assets/img/icons/negro/svg/carrito.svg" alt="" width="24" height="24">
                <?php if ($productosEnCarrito > 0) { ?>
                    <span class="badge rounded-pill bg-primary position-absolute top-0 end-0"><?= $productosEnCarrito ?></span>
                <?php } ?>
            </a>

            <!-- Usuario (solo en ordenador): con sesión, menú desplegable; sin sesión, icono que lleva al login -->
            <?php if (isset($_SESSION['usuario'])) { ?>
                <details class="position-relative d-none d-lg-block">
                    <summary class="encabezado__usuario d-inline-flex align-items-center gap-2 px-3 rounded-pill">
                        <img src="<?= url ?>assets/img/icons/negro/svg/usuario.svg" alt="" width="24" height="24">
                        <span class="encabezado__nombre text-truncate"><?= dato($_SESSION['usuario']->getNombre()) ?></span>
                        <img src="<?= url ?>assets/img/icons/negro/svg/flecha-abajo.svg" alt="" width="16" height="16">
                    </summary>
                    <div class="desplegable position-absolute top-100 end-0 mt-2 d-flex flex-column gap-2 p-3 bg-white rounded-3 shadow">
                        <a href="<?= url ?>index.php?controller=user" class="py-2">Mi cuenta</a>
                        <?php
                        //prettier($_SESSION['usuario']);
                        if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() === 'admin') {

                            ?>
                            <a href="<?= url ?>index.php?controller=admin" class="py-2">Panel administración</a>
                            <?php
                        }
                        ?>
                        <form method="POST" action="<?= url ?>index.php?controller=user&action=logout">
                            <button class="boton boton--primario boton--sm" type="submit">Cerrar sesión</button>
                        </form>
                    </div>
                </details>
            <?php } else { ?>
                <a href="<?= url ?>index.php?controller=user" class="boton-icono d-none d-lg-inline-flex">
                    <img src="<?= url ?>assets/img/icons/negro/svg/usuario.svg" alt="" width="24" height="24">
                </a>
            <?php } ?>

            <!-- Menú hamburguesa: solo en tablet y móvil. Lleva todo el menú dentro. No tiene position-relative, así el desplegable se coloca respecto a la barra y sale debajo de ella de lado a lado (start-0 end-0) -->
            <details class="d-lg-none">
                <summary class="boton-icono">
                    <img src="<?= url ?>assets/img/icons/negro/svg/menu.svg" alt="" width="24" height="24">
                </summary>
                <div class="position-absolute top-100 start-0 end-0 mt-2 d-flex flex-column gap-2 p-3 bg-white rounded-3 shadow">
                    <?php if (isset($_SESSION['usuario'])) { ?>
                        <p class="m-0 pb-2 border-bottom fw-bold">Hola, <?= dato($_SESSION['usuario']->getNombre()) ?></p>
                    <?php } ?>

                    <a href="<?= url ?>index.php?controller=home" class="py-2">Inicio</a>
                    <a href="<?= url ?>index.php?controller=productos" class="py-2">Carta</a>

                    <?php if (isset($_SESSION['usuario'])) { ?>
                        <a href="<?= url ?>index.php?controller=user" class="py-2">Mi cuenta</a>

                        <?php
                        //prettier($_SESSION['usuario']);
                        if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() === 'admin') {

                            ?>
                            <a href="<?= url ?>index.php?controller=admin" class="py-2">Panel administración</a>
                            <?php
                        }
                        ?>
                        <form method="POST" action="<?= url ?>index.php?controller=user&action=logout">
                            <button class="boton boton--primario boton--sm" type="submit">Cerrar sesión</button>
                        </form>
                    <?php } else { ?>
                        <a href="<?= url ?>index.php?controller=user" class="py-2">Iniciar sesión</a>
                    <?php } ?>
                </div>
            </details>
        </div>
    </div>
</header>
