# Lista de tareas · Proyecto 1 Restaurante (Sigmeat)

> Volver al [README](../README.md).

Comparación entre el enunciado `PROYECTO 1 RESTAURANTE (APP WEB) (1).docx` y el estado del proyecto a 14/11/2026.

**Leyenda:** `[x]` hecho · `[~]` a medias · `[ ]` sin hacer · `[?]` revisar a mano (no se puede comprobar desde el código)

**Resumen:** está hecha la tienda (home, carta, detalle), el login y registro, el panel de usuario y el carrito (paso 1) con código promocional. Faltan la lógica de los pasos 2 y 3 de la compra (las vistas ya están), guardar el pedido, las ofertas, el panel de administración, el despliegue y la memoria.

---

## Corregir ya
- [x] **Mayúsculas en los `include`.** Todos los archivos, includes y `fetch_object` usan ahora el nombre exacto de la clase (ver «Convención de nombres»).
- [x] **Contraseña del admin en `sql/InsertarDatosBD.sql`:** ya está guardada con hash bcrypt (`Admin1234!`).
- [x] **Impuestos:** los precios de la BBDD ya incluyen un IVA del 10 %. El carrito lo enseña como información (subtotal sin IVA + IVA).

---

## Web: usuario


### Figma Pendiente

Home
Titulo modificar foto de fondo para bajar la opacidad Oscurecer

Cambiar todos los botones con boton con flechita
hacer que los botones menos padding
Alinear el boton de elige tu categoria a la derecha
Separar el construyendo el futuro y elige tu categoria
unicamente 1 boton en la portada y que sea el oscuro
el boton de listado es añadir el carrito 1 de añadir al carrito y otro de personalizar
y si haces click a al cuadrado si puedes personalizar el, es decir desde 2 sitios puedes personalizar boton y marco
revisar migas de pan falta en carrito y carta
si vas a carta dejar que el nav se quede seleccionado
en los ingredientes principales de la comida si cabe un 4 ponerlo en horizontal
invertir la cantidad y el total en el producto
separar separacion de productos del carrito y la papelera elimina el producto completo y que salga un aviso
Añadir la leyenda nombre / cantidad / precio

en mvl hacer los botones mas grandes que llegen mas de lado a lado

### Registro y sesión
- [x] Formularios de login y registro (`views/usuario/login.php` y `registro.php`), conectados a `UserController`.
- [x] `session_start()` activo en `index.php`.
- [x] Registrar usuarios guardando la contraseña con `password_hash`.
- [x] Iniciar sesión con `password_verify` y `UsuariosDAO::getByEmail`.
- [x] Cerrar sesión (`UserController::logout`).
- [x] Cabecera según la sesión: botón de salir solo con la sesión iniciada.

### Panel de usuario
- [~] Ver los datos personales: hecho. Falta modificarlos; hace falta `UsuariosDAO::update` y actualizar también `$_SESSION['usuario']` (sin la contraseña).
- [x] Ver los pedidos realizados, con el detalle desplegable, el resumen y los códigos de descuento (`views/usuario/panel.php`).
- [ ] Ver los datos del último pedido al volver a entrar.

### Productos
- [x] Carta con todos los productos, filtrada por categoría y usando la BBDD.
- [x] Detalle del producto con ingredientes base y extras.
- [x] Quitar y añadir ingredientes.
- [x] El servidor calcula el precio con los extras y no se fía del navegador. Sin JavaScript en la tienda: el total del detalle no cambia en vivo, el precio final se ve en el carrito.
- [x] Contador de productos en la cabecera.
- [x] Sección «Elige tu categoría» de la home conectada a la BBDD, solo con categorías activas.
- [x] Colores por categoría en home, carta y detalle.
- [x] Píldoras de filtro solo con categorías activas.
- [x] Enlace a la personalización desde «Editar» y desde la caja de color de la carta.
- [x] Error 404 si el producto no existe o está inactivo.
- [x] En bebidas solo se puede quitar el hielo, y siempre queda al menos un ingrediente base.
- [x] Avisos de un solo uso tras añadir al carrito.
- [x] Botón «Añadir al carrito» de la carta: añade 1 unidad sin personalizar.
- [ ] Decidir si se ocultan los productos de categorías inactivas: ahora siguen saliendo en la carta.

### Carrito
- [x] Guardado en sesión, con línea separada por cada personalización.
- [x] Página del carrito (`views/carrito/carrito.php`), enlazada desde el icono de la cabecera.
- [x] Cambiar la cantidad con los botones − y + (entre 1 y 99).
- [ ] Modificar la personalización de un producto ya añadido.
- [x] Eliminar un producto con aviso (papelera con `<details>`, sin JavaScript).
- [x] Leyenda producto / cantidad / precio.
- [x] Subtotal, IVA, envío (gratis a partir de 50 €), descuento y total (`CarritoController::calcularTotales`).
- [x] Código promocional (`aplicarCodigo`): comprueba que esté activo y en fechas y lo guarda en la sesión.
- [ ] Botón «Aplicar» junto al campo del código (ahora se envía con Enter).

### Finalizar la compra
- [x] Vista del paso 2 «Datos y pago» (`views/carrito/pago.php`): datos del usuario, método de pago simulado y resumen.
- [x] Vista del paso 3 «Confirmación» (`views/carrito/confirmacion.php`).
- [ ] Lógica de `datosPago()`: carrito vacío → volver al carrito; sin sesión → login.
- [ ] Volver a «Datos y pago» después de iniciar sesión (ahora el login siempre lleva al panel).
- [ ] Lógica de `confirmar()` y acción por GET que enseña la confirmación (para no duplicar el pedido al recargar).
- [ ] Guardar en `pedidos`, `pedido_detalle` y `pedido_detalle_ingrediente`.
- [ ] `PedidosDAO::insert` e `insertDetalle` deben devolver el id creado; ahora no lo hacen y hace falta para enlazar las tablas.
- [ ] Guardar todo con una transacción, para no dejar pedidos a medias.
- [ ] Recalcular los precios en el servidor al confirmar y vaciar el carrito y el código.
- [x] Decidir qué se guarda en `pedidos.subtotal` y `total`: `subtotal` = suma de los productos con IVA; `total` = lo que paga el cliente (con envío y descuento).
- [ ] Opcional: guardar el envío del pedido. `total` lo incluye, pero la tabla `pedidos` no tiene columna `envio`, así que en «Mi cuenta» subtotal − descuento no cuadra con el total cuando hay 5 € de envío. Opciones: añadir la columna `envio` (BD, modelo, DAO y diagramas) o enseñar la diferencia como «Envío» en la vista.

### Ofertas
- [x] Tablas, datos de ejemplo, modelo y `OfertasDAO`.
- [x] Códigos promocionales: se listan en el panel de usuario y se aplican en el carrito.
- [ ] Controlador y página de ofertas.
- [ ] **Diseño individual para cada oferta**, como pide el enunciado.
- [ ] Añadir una oferta al carrito.
- [~] Aplicar cada tipo: `codigo` hecho; faltan `combo`, `2x1` y `descuento`.
- [~] Comprobar fechas de validez y `activa`: hecho para los códigos (`getCodigosActivos`).

### Código
- [x] Estructura MVC con `index.php` como punto de entrada.
- [x] Clases y clases estáticas: DAO estáticos, `Productos` abstracta y sus clases hijas.
- [x] Modelos de todas las tablas y DAO con consultas preparadas.
- [x] Página de error común con `showError()`.
- [x] Salida de textos protegida con `htmlspecialchars` en las vistas de producto.
- [x] CSS separado por archivos, comentado y sin reglas obsoletas.
- [~] **Polimorfismo:** las hijas de `Productos` solo heredan y no cambian ningún método. Añadir uno con comportamiento distinto en cada hija.
- [~] Comentarios: el CSS y lo último están comentados; falta repasar el resto.
- [X] Limpiar `views/productos/carta.php`: lleva un `<!DOCTYPE>` completo dentro de `main.php`.
- [ ] Revisar el `<form>` de filtros de la carta: su `action` no se usa porque las píldoras son enlaces.
- [x] Funciones de depuración en `helpers/debug.php` (cargadas desde `index.php`).
- [ ] Quitar los `echo` de prueba que quedan en `ProductosController::anadirCarrito` y los comentarios de depuración.
- [ ] Opcional: pasar a `helpers/` las funciones de formato que se repiten en las vistas (`precioCarrito`, `textoPanel`…).

---

## Panel de administración
**No hay nada hecho:** ni API, ni `fetch`, ni panel. La carpeta `OneDrive\DAW2\PanelAdminPagina` solo tiene dos archivos muy pequeños, sin revisar, que no parecen ser este panel.

### API en PHP
- [ ] Carpeta o controlador de API que responda en JSON con sus códigos HTTP.
- [ ] Login de administrador, comprobando `rol = admin`.
- [ ] Proteger los endpoints: que solo responda a un administrador.
- [ ] Endpoints de productos: listar y modificar.
- [ ] Endpoints de pedidos: listar, modificar, añadir o quitar productos y cambiar el precio final.
- [ ] Endpoints de usuarios: listar e historial de pedidos.
- [ ] Añadir los `update` que faltan: ningún DAO tiene ese método.

### Funciones del panel
- [ ] Listar, modificar y ordenar productos y pedidos sin recargar.
- [ ] Añadir o eliminar productos de un pedido y modificar el precio final.
- [ ] Filtrar productos y pedidos por nombre, ID, precio, etc.
- [ ] Listar usuarios y ver el historial de cada uno.
- [ ] Revisar la accesibilidad: el diseño no puntúa, pero esto sí.

### Requisitos técnicos en JavaScript
- [ ] DOM: crear y modificar elementos de forma dinámica.
- [ ] Eventos: clics, envíos de formularios y escritura.
- [ ] `map`, `filter`, `reduce` o similares.
- [ ] Al menos 2 clases.
- [ ] Una clase específica para cambiar de vista sin recargar.
- [ ] `localStorage` o `sessionStorage` para la sesión.
- [ ] Un segundo uso de Storage, **justificado en la memoria** (por ejemplo, recordar el último filtro).
- [ ] `fetch` o axios para enviar formularios y pedir datos.
- [ ] Opcional: funcionalidades adicionales que aporten valor.

---

## Diseño
- [?] Prototipo de escritorio a 1080 px en Figma.
- [x] Home con cabecera, banner, más de 3 secciones y pie.
- [~] Home responsive: hay reglas para móvil, pero falta probarla a **430x932**.
- [x] Página de carta.
- [x] Página de detalle del producto.
- [~] Páginas del proceso de compra con precio e impuestos: hechas en la web (carrito, datos y pago, confirmación); faltan en el prototipo.
- [x] HTML, CSS y Bootstrap.
- [x] Tipografía Satoshi: nombres igualados entre `variables.css` y `satoshi.css` y rutas corregidas.
- [?] Imágenes y principios de semejanza, continuidad, simetría, proximidad y contraste, en prototipo y web final. Justificarlos en la memoria.

### Notas de `main.php` ya hechas
- [x] Un solo botón en la portada.
- [x] Botón de «Elige tu categoría» alineado a la derecha.
- [x] Personalizar desde dos sitios: botón y marco.
- [x] Migas de pan en la carta.
- [x] Ingredientes base en 4 por fila si caben.
- [x] Total y cantidad invertidos en el producto.
- [x] Migas de pan en el carrito (y en datos y pago).
- [x] Separación entre productos de la carta y botones con icono.

### Notas de `main.php` aún pendientes
- [ ] Dejar marcado en el menú el apartado actual.
- [ ] Botones más anchos en móvil.
- [ ] Enlaces del pie, «Pedir ya» y «Conócenos»: ahora no llevan a ningún sitio.

---

## Base de datos
- [x] MySQL en Docker: `mysql-db` activo en el puerto 3308.
- [x] Scripts de creación y datos en `sql/`.
- [x] Diagrama entidad-relación (`docs/diagramas/`, aún sin subir).
- [x] Modelo relacional (`docs/diagramas/`, aún sin subir).

---

## Servicios web
- [x] Entorno local con XAMPP.
- [ ] **Depurador PHP:** no hay Xdebug en XAMPP. Instalarlo y configurarlo en el IDE.
- [ ] Documentar los plugins del IDE.
- [ ] Elegir y configurar un servidor web. Debe poder ejecutar la BBDD, así que un VPS con Docker encaja bien.
- [ ] Subir la web por FTP.
- [ ] Dominio público.
- [x] La `url` de `config/parameters.php` se calcula sola (sirve en XAMPP, WSL y servidor).
- [ ] Cambiar la contraseña `root` de la BBDD en el servidor real.

---

## GitHub
- [x] Repositorio `danipyxcala-afk/Daw2mvc` con 30 commits.
- [ ] **Trabajar en ramas:** los 30 commits están en `main`, sin ramas ni fusiones. **Esto se evalúa**, así que conviene empezar ya, por ejemplo con `feature/pago`.
- [ ] Fusionar en `main` todo lo que se suba.
- [x] Commit de los cambios de `login.php`.
- [ ] Decidir si se sube el enunciado.
- [x] Añadir `.gitignore`.
- [x] Dar acceso al repositorio a todos los profesores.
- [ ] Añadir el enlace del repositorio donde pide el enunciado.
- [ ] Subir la memoria y la base de datos.
- [x] `README.md` nuevo y `READMEProfe.md` quitado.
- [ ] Decidir si se entrega `PREGUNTAS.md`.

---

## Memoria
Hay un esqueleto en `docs/memoria/memoria.md` (aún sin subir). Conviene escribirla durante el desarrollo.
- [~] Título, índice, bibliografía o webgrafía y anexos (esqueleto).
- [ ] Un apartado por cada bloque del enunciado: web, panel, diseño, BBDD, servicios web y GitHub.
- [~] Diagrama de clases y cómo interactúan (diagrama hecho en `docs/diagramas/`, falta explicarlo).
- [~] Diagramas entidad-relación y relacional (hechos, falta meterlos en la memoria).
- [ ] Moodboard, prototipo y justificación del diseño.
- [ ] Explicación de la API y del uso de Storage.
- [ ] Revisión de ortografía y vocabulario.

### Presentación
- [ ] Preparar la presentación (entre el 29/11 y el 21/12, según la cuadrícula).

---

## Orden recomendado
Las fechas son orientativas y cuentan con entregar el 29/11 (revisado el 14/11):

1. ~~Hasta el 8/11: aclarar dudas y «Corregir ya».~~ Hecho.
2. ~~Hasta el 12/11: login, registro, cierre de sesión y datos de usuario.~~ Hecho (falta modificar datos).
3. **Hasta el 17/11:** empezar a usar ramas, lógica de datos y pago y confirmación, guardar el pedido y último pedido.
4. **Hasta el 19/11:** ofertas.
5. **Hasta el 25/11:** API y panel de administración, el bloque más grande.
6. **Hasta el 27/11:** despliegue, prototipo de compra y repaso de móvil.
7. **Hasta el 29/11:** cerrar memoria, fusionar todo en `main` y prueba completa.
