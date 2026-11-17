<section class="entrada-home d-flex flex-column align-items-center justify-content-center text-center">
    <div class="container">
        <h1 class="text-white">Para disfrutar,</h1>
        <h1 class="text-white">a tu manera</h1>
        <a href="<?= url ?>index.php?controller=productos" class="boton boton--secundario">
            Ver nuestra carta
            <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
        </a>
    </div>
</section>

<!-- Banda azul con las palabras -->
<section class="bg-primary py-2">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="text-white">Fresco</h3>
            </div>
            <div class="col">
                <h3 class="text-white">Artesanal</h3>
            </div>
            <div class="col">
                <h3 class="text-white">A tu gusto</h3>
            </div>
            <div class="col">
                <h3 class="text-white">Rapido</h3>
            </div>
            <div class="col">
                <h3 class="text-white">Con pasión</h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <section class="mt-5">
        <div class="container text-center">
            <h2>¿Que define a Sigmeat?</h2>
            <p>Cocinamos como en casa, con producto de proximidad y salsas propias. Tu decides qué lleva
                cada plato.</p>
        </div>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <!-- img-fluid + w-100: la foto ocupa su columna y nunca se sale de ella -->
                    <img class="img-fluid w-100" src="<?= url . "assets/" . $productoAleatorio->getImagen() ?>"
                        alt="<?= texto($productoAleatorio->getNombre()) ?>"
                        width="610" height="409">
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled d-flex flex-column gap-5 m-0">
                        <li class="d-flex align-items-center gap-4">
                            <span class="define__check d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle">
                                <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20"
                                    height="20">
                            </span>
                            <div>
                                <h4 class="mb-2">Ingredientes frescos</h4>
                                <p class="mb-0">Producto de mercado recibido a diario</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-center gap-4">
                            <span class="define__check d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle">
                                <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20"
                                    height="20">
                            </span>
                            <div>
                                <h4 class="mb-2">Hecho al momento</h4>
                                <p class="mb-0">Cada pedido se cocina cuando se pide</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-center gap-4">
                            <span class="define__check d-flex align-items-center justify-content-center flex-shrink-0 bg-primary rounded-circle">
                                <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20"
                                    height="20">
                            </span>
                            <div>
                                <h4 class="mb-2">Personalizable</h4>
                                <p class="mb-0">Añade o quita ingredientes en cada producto</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="<?= url ?>index.php?controller=productos" class="boton boton--secundario">
                    Conoce a Sigmeat
                    <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
                </a>
            </div>
        </div>
    </section>
</div>

<!-- Elige tu categoría: va pegada a la sección de abajo (por eso esa no lleva margen) -->
<section class="bg-light py-5 mt-5">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h2 class="mb-0">Elige tu categoría</h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="<?= url ?>index.php?controller=productos" class="boton boton--secundario">
                    Ver nuestra carta
                    <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
                </a>
            </div>
        </div>

        <p class="categorias__intro text-primary mt-3 mb-4">
            Explora nuestro menú completo y elige entre una cuidada selección de hamburguesas, complementos, bebidas
            y postres preparados al momento para ti.
        </p>

        <div class="row g-4">
            <?php
            $posicion = 0;
            foreach ($categorias as $categoria) {
                $nombre = $categoria->getNombre();
                $color = $coloresCategorias[$posicion % count($coloresCategorias)];
                $posicion++;
                ?>
                <div class="col-6 col-lg-3">
                    <!-- Toda la tarjeta es un enlace a la carta filtrada. En el móvil lleva menos relleno -->
                    <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=<?= urlencode($nombre) ?>"
                        class="categoria-card categoria-card--<?= $color ?> d-flex flex-column align-items-center gap-2 gap-sm-3 h-100 p-2 p-sm-3 pt-3 pt-sm-4 rounded-4">
                        <h3 class="categoria-card__nombre m-0 text-white text-center"><?= texto($nombre) ?></h3>
                        <?php if (isset($imagenesCategorias[$nombre])) { ?>
                            <img class="categoria-card__img flex-grow-1 w-100 object-fit-contain"
                                src="<?= url . "assets/" . $imagenesCategorias[$nombre] ?>" alt=""
                                width="610" height="409" loading="lazy">
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Construyendo el futuro: la foto estrecha (col-2) solo desde md, y la grande ocupa el resto (col) -->
<section class="futuro d-flex bg-dark pb-3">
    <div class="futuro__lateral col-2 d-none d-md-block"></div>
    <div class="futuro__principal col d-flex flex-column justify-content-between p-4 p-md-5">
        <h2 class="text-white">Construyendo el futuro!</h2>
        <div>
            <p class="text-white">Enfocado para universidades</p>
            <a href="#" class="boton boton--secundario">
                Conócenos
                <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
            </a>
        </div>
    </div>
</section>
