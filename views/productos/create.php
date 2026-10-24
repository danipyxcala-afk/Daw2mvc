<div class="container">
    <h1>Crear producto</h1>
    <p><a href="?controller=producto" class="enlace-volver">Volver al listado</a></p>

    <form action="?controller=producto&action=store" method="POST" class="formulario">
        <label for="nombre">
            Nombre
            <input type="text" name="nombre" id="nombre" required maxlength="100">
        </label>

        <label for="talla">
            Talla
            <select name="talla" id="talla" required>
                <option value="XXL">XXL</option>
                <option value="XL">XL</option>
                <option value="L">L</option>
                <option value="M" selected>M</option>
                <option value="S">S</option>
            </select>
        </label>

        <label for="precio">
            Precio
            <input type="number" name="precio" id="precio" step="0.01" min="0" required>
        </label>

        <button type="submit" class="boton boton--primario">Guardar</button>
    </form>
</div>
