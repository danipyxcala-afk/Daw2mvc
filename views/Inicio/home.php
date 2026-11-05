<section class="EntradaHome">
    <div class="container">
        <h1 class="textblanco">Para disfrutar,</h1>
        <h1 class="textblanco">a tu manera</h1>
        <a href="<?= url ?>index.php?controller=productos" class="boton boton--secundario">
            Ver nuestra carta
            <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
        </a>
    </div>
</section>

<section class="tags">
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="textblanco">Fresco</h3>
            </div>
            <div class="col">
                <h3 class="textblanco">Artesanal</h3>
            </div>
            <div class="col">
                <h3 class="textblanco">A tu gusto</h3>
            </div>
            <div class="col">
                <h3 class="textblanco">Rapido</h3>
            </div>
            <div class="col">
                <h3 class="textblanco">Con pasión</h3>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <section class="mt-5">
        <div class="container text-center">
            <h2>¿Que define a Sigmeat?</h2>
            <p class="fw-bold">Cocinamos como en casa, con producto de proximidad y salsas propias. Tu decides qué lleva
                cada plato.</p>
        </div>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <img src="<?= url . "assets/" . $productoAleatorio->getImagen() ?>"
                        alt="<?= $productoAleatorio->getNombre() ?>">
                </div>
                <div class="col-md-6">
                    <ul class="define__lista">
                        <li class="define__item">
                            <span class="define__check">
                                <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20"
                                    height="20">
                            </span>
                            <div>
                                <h4>Ingredientes frescos</h4>
                                <p>Producto de mercado recibido a diario</p>
                            </div>
                        </li>
                        <li class="define__item">
                            <span class="define__check">
                                <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20"
                                    height="20">
                            </span>
                            <div>
                                <h4>Hecho al momento</h4>
                                <p>Cada pedido se cocina cuando se pide</p>
                            </div>
                        </li>
                        <li class="define__item">
                            <span class="define__check">
                                <img src="<?= url ?>assets/img/icons/blanco/svg/check.svg" alt="" width="20"
                                    height="20">
                            </span>
                            <div>
                                <h4>Personalizable</h4>
                                <p>Añade o quita ingredientes en cada producto</p>
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

<section class="categorias mt-5">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h2 class="mb-0">Elige tu categoría</h2>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="<?= url ?>index.php?controller=productos" class="boton boton--secundario boton--invertido">
                    Ver nuestra carta
                    <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
                </a>
            </div>
        </div>

        <p class="categorias__intro fw-bold">
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
                    <a href="<?= url ?>index.php?controller=productos&action=carta&pildora=<?= urlencode($nombre) ?>"
                        class="categoria-card categoria-card--<?= $color ?>">
                        <h3 class="categoria-card__nombre"><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></h3>
                        <?php if (isset($imagenesCategorias[$nombre])) { ?>
                            <img class="categoria-card__img" src="<?= url . "assets/" . $imagenesCategorias[$nombre] ?>" alt=""
                                width="610" height="409" loading="lazy">
                        <?php } ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section class="futuro mt-5">
    <div class="futuro__lateral d-none d-md-block"></div>
    <div class="futuro__principal">
        <h2 class="textblanco">Construyendo el futuro!</h2>
        <div>
            <p class="textblanco">Enfocado para universidades</p>
            <a href="#" class="boton boton--secundario">
                Conócenos
                <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
            </a>
        </div>
    </div>
</section>