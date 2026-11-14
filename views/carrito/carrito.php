<?php
/* VISTA DEL CARRITO (paso 1 de 3)
   Esta vista solo pinta: no calcula nada. Necesita que CarritoController::index() le pase:
   - $lineas     -> array con las líneas del carrito. La clave de cada línea ($clave) es la que
                    identifica la línea en $_SESSION['carrito'] y va oculta en los formularios.
                    Cada línea es un array con: 'nombre', 'imagen', 'precio_unitario', 'cantidad',
                    'quitados' (lista de ['nombre' => ...]) y 'extras' (lista de ['nombre' => ..., 'precio_extra' => ...])
   - $subtotal, $iva, $envio, $descuento, $total -> números
   Si guardas el carrito con otros nombres, cambia solo los nombres de aquí.
   Sin JavaScript: todo funciona con formularios y con <details>. */

// Valores por defecto: si el controlador todavía no pasa alguna variable,
// la página se ve como un carrito vacío en vez de dar un error
$lineas = $lineas ?? [];
$subtotal = $subtotal ?? 0;
$iva = $iva ?? 0;
$envio = $envio ?? 0;
$descuento = $descuento ?? 0;
$total = $total ?? 0;

// Da formato de precio: 12.5 -> 12,50€
function precioCarrito($valor)
{
    return number_format((float) $valor, 2, ',', '.') . '€';
}

// Escapa un texto para mostrarlo en HTML
function textoCarrito($texto)
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}
?>
<div class="container carrito">
    <nav class="producto__migas" aria-label="Migas de pan">
        <a href="<?= url ?>index.php?controller=home">Inicio</a> /
        <b>Carrito</b>
    </nav>

    <h1 class="carrito__titulo">Tu carrito</h1>

    <!-- PASOS DEL PEDIDO: aria-current marca el paso en el que estamos -->
    <ol class="pasos" aria-label="Pasos del pedido">
        <li class="pasos__paso is-activo" aria-current="step">
            <span class="pasos__numero">1</span> Carrito
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">2</span> Datos y pago
        </li>
        <li class="pasos__paso">
            <span class="pasos__numero">3</span> Confirmación
        </li>
    </ol>

    <?php if (count($lineas) === 0) { ?>
        <div class="carrito__vacio">
            <p>Tu carrito está vacío.</p>
            <a class="boton boton--primario" href="<?= url ?>index.php?controller=productos">Ver la carta</a>
        </div>
    <?php } else { ?>
        <div class="row g-4">
            <!-- LÍNEAS DEL CARRITO -->
            <div class="col-lg-8">
                <!-- Leyenda: solo en escritorio -->
                <div class="carrito__leyenda d-none d-md-grid" aria-hidden="true">
                    <span class="carrito__leyenda-producto">Producto</span>
                    <span class="carrito__leyenda-cantidad">Cantidad</span>
                    <span class="carrito__leyenda-precio">Precio</span>
                </div>

                <ul class="carrito__lineas">
                    <?php foreach ($lineas as $clave => $linea) {
                        $nombre = textoCarrito($linea['nombre']);
                        $cantidad = (int) $linea['cantidad'];
                        $quitados = $linea['quitados'] ?? [];
                        $extras = $linea['extras'] ?? [];
                        ?>
                        <li class="linea-carrito">
                            <div class="linea-carrito__media">
                                <img class="linea-carrito__img" src="<?= url . 'assets/' . textoCarrito($linea['imagen']) ?>"
                                    alt="" width="120" height="80" loading="lazy">
                            </div>

                            <div class="linea-carrito__info">
                                <h2 class="linea-carrito__nombre"><?= $nombre ?></h2>
                                <p class="linea-carrito__detalle">
                                    <?php if (count($quitados) + count($extras) === 0) { ?>
                                        Sin extras ·
                                    <?php } else { ?>
                                        <?php foreach ($quitados as $quitado) { ?>
                                            <span class="linea-carrito__mod--quitado">Sin <?= textoCarrito($quitado['nombre']) ?> ·</span>
                                        <?php } ?>
                                        <?php foreach ($extras as $extra) { ?>
                                            <span class="linea-carrito__mod--anadido">+ <?= textoCarrito($extra['nombre']) ?> ·</span>
                                        <?php } ?>
                                    <?php } ?>
                                    <?= precioCarrito($linea['precio_unitario']) ?> / ud.
                                </p>
                            </div>

                            <!-- CANTIDAD: cada botón envía la cantidad nueva a CarritoController::cambiarCantidad() -->
                            <form class="cantidad__selector linea-carrito__cantidad" method="POST"
                                action="<?= url ?>index.php?controller=carrito&action=cambiarCantidad">
                                <input type="hidden" name="clave" value="<?= textoCarrito($clave) ?>">
                                <button class="cantidad__boton" type="submit" name="cantidad" value="<?= $cantidad - 1 ?>"
                                    aria-label="Quitar uno de <?= $nombre ?>" <?= $cantidad <= 1 ? 'disabled' : '' ?>>-</button>
                                <span class="cantidad__numero"><?= $cantidad ?></span>
                                <button class="cantidad__boton" type="submit" name="cantidad" value="<?= $cantidad + 1 ?>"
                                    aria-label="Añadir uno de <?= $nombre ?>" <?= $cantidad >= 99 ? 'disabled' : '' ?>>+</button>
                            </form>

                            <span class="linea-carrito__precio">
                                <?= precioCarrito((float) $linea['precio_unitario'] * $cantidad) ?>
                            </span>

                            <!-- PAPELERA sin JavaScript: al pulsar el icono se abre el aviso
                                 y hay que confirmar con "Sí, quitar" (CarritoController::quitar()) -->
                            <details class="linea-carrito__eliminar">
                                <summary class="boton-icono" aria-label="Eliminar <?= $nombre ?>">
                                    <img src="<?= url ?>assets/img/icons/negro/svg/eliminar.svg" alt="" width="20" height="20">
                                </summary>
                                <div class="linea-carrito__aviso">
                                    <p>¿Quitar <?= $nombre ?> del carrito?</p>
                                    <form method="POST" action="<?= url ?>index.php?controller=carrito&action=quitar">
                                        <input type="hidden" name="clave" value="<?= textoCarrito($clave) ?>">
                                        <button class="boton boton--primario boton--sm" type="submit">Sí, quitar</button>
                                    </form>
                                </div>
                            </details>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <!-- RESUMEN: a la derecha en escritorio, debajo de las líneas en móvil -->
            <div class="col-lg-4">
                <aside class="carrito__resumen" aria-labelledby="carrito-resumen-titulo">
                    <h2 class="carrito__subtitulo" id="carrito-resumen-titulo">Resumen</h2>

                    <dl class="carrito__totales">
                        <div class="carrito__fila">
                            <dt>Subtotal</dt>
                            <dd><?= precioCarrito($subtotal) ?></dd>
                        </div>
                        <div class="carrito__fila">
                            <dt>IVA (10%)</dt>
                            <dd><?= precioCarrito($iva) ?></dd>
                        </div>
                        <div class="carrito__fila">
                            <dt>Envío</dt>
                            <dd><?= precioCarrito($envio) ?></dd>
                        </div>
                        <div class="carrito__fila">
                            <dt>Descuento</dt>
                            <dd><?= (float) $descuento > 0 ? '−' : '' ?><?= precioCarrito($descuento) ?></dd>
                        </div>
                        <div class="carrito__fila carrito__fila--total">
                            <dt>Total</dt>
                            <dd><?= precioCarrito($total) ?></dd>
                        </div>
                    </dl>

                    <!-- CÓDIGO PROMOCIONAL: lo recibe CarritoController::aplicarCodigo() -->
                    <form class="carrito__codigo" method="POST"
                        action="<?= url ?>index.php?controller=carrito&action=aplicarCodigo">
                        <label class="visually-hidden" for="carrito-codigo">Código promocional</label>
                        <input class="form-control carrito__codigo-campo" type="text" id="carrito-codigo" name="codigo"
                            placeholder="Código promocional" maxlength="50" autocomplete="off">
                    </form>

                    <!-- CONTINUAR: paso 2, CarritoController::datosPago() -->
                    <a class="boton boton--secundario boton--bloque carrito__continuar"
                        href="<?= url ?>index.php?controller=carrito&action=datosPago">
                        Continuar
                        <img src="<?= url ?>assets/img/icons/blanco/svg/flecha-diagonal.svg" alt="" width="20" height="20">
                    </a>
                </aside>
            </div>
        </div>
    <?php } ?>
</div>
