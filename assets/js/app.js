// PANTALLA DE PRODUCTO
// Este código actualiza lo que ve el cliente: la cantidad, el total y el texto del botón.
// El precio que cuenta de verdad lo vuelve a calcular el servidor en anadirCarrito().
const formProducto = document.getElementById("form-producto");

// Este archivo se carga en todas las páginas: solo actuamos si existe el formulario
if (formProducto) {
    const CANTIDAD_MINIMA = 1;
    const CANTIDAD_MAXIMA = 99;

    const precioBase = Number(formProducto.dataset.precio);
    const inputCantidad = document.getElementById("producto-cantidad");
    const textoTotal = document.getElementById("producto-total");
    const botonAnadir = document.getElementById("producto-anadir");
    const extras = formProducto.querySelectorAll(".extra__check");
    const ingredientes = formProducto.querySelectorAll(".ingrediente__check");

    // Mantiene la cantidad entre el mínimo y el máximo, aunque se escriba a mano
    function leerCantidad() {
        const cantidad = parseInt(inputCantidad.value, 10) || CANTIDAD_MINIMA;
        return Math.min(CANTIDAD_MAXIMA, Math.max(CANTIDAD_MINIMA, cantidad));
    }

    // Total = cantidad x (precio del producto + extras marcados)
    function actualizarTotal() {
        let precioUnidad = precioBase;
        extras.forEach(function (extra) {
            if (extra.checked) {
                precioUnidad += Number(extra.dataset.precio);
            }
        });

        const cantidad = leerCantidad();
        const total = cantidad * precioUnidad;

        // toFixed deja 2 decimales y replace cambia el punto por la coma
        textoTotal.textContent = total.toFixed(2).replace(".", ",") + "€";
        botonAnadir.textContent = "Añadir " + cantidad + " al carrito";
    }

    // Si solo queda un ingrediente sin quitar, lo bloqueamos para que no se pueda quitar también
    function protegerUltimoIngrediente() {
        const restantes = Array.from(ingredientes).filter(function (ingrediente) {
            return !ingrediente.checked;
        });

        ingredientes.forEach(function (ingrediente) {
            // Los ingredientes fijos (la bebida de un refresco) siempre siguen bloqueados
            const esFijo = ingrediente.dataset.fija === "1";
            ingrediente.disabled = esFijo || (restantes.length === 1 && !ingrediente.checked);
        });
    }

    // Botones - y +
    document.getElementById("cantidad-menos").addEventListener("click", function () {
        inputCantidad.value = Math.max(CANTIDAD_MINIMA, leerCantidad() - 1);
        actualizarTotal();
    });

    document.getElementById("cantidad-mas").addEventListener("click", function () {
        inputCantidad.value = Math.min(CANTIDAD_MAXIMA, leerCantidad() + 1);
        actualizarTotal();
    });

    // "input" salta mientras se escribe y "change" al salir de la casilla, cuando corregimos el número
    inputCantidad.addEventListener("input", actualizarTotal);
    inputCantidad.addEventListener("change", function () {
        inputCantidad.value = leerCantidad();
        actualizarTotal();
    });

    extras.forEach(function (extra) {
        extra.addEventListener("change", actualizarTotal);
    });

    ingredientes.forEach(function (ingrediente) {
        ingrediente.addEventListener("change", protegerUltimoIngrediente);
    });

    // Al volver atrás, el navegador puede recordar las casillas: dejamos todo coherente al cargar
    protegerUltimoIngrediente();
    actualizarTotal();
}
