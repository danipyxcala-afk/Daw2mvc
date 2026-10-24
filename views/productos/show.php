<div class="container">
    <h1>Detalle del producto</h1>
    <p><a href="?controller=producto" class="enlace-volver">Volver al listado</a></p>

    <dl class="detalle">
        <dt>Nombre</dt>
        <dd><?= htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>Talla</dt>
        <dd><?= htmlspecialchars($producto->getTalla(), ENT_QUOTES, 'UTF-8') ?></dd>

        <dt>Precio</dt>
        <dd><?= number_format((float) $producto->getPrecio(), 2, ',', '.') ?> €</dd>
    </dl>

    <p>
        <a href="?controller=producto&action=destroy&id=<?= (int) $producto->getId() ?>" class="boton boton--secundario boton--sm">Eliminar</a>
    </p>
</div>
