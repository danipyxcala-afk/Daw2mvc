# Lista de tareas · Proyecto 1 Restaurante (Sigmeat)

> Volver al [README](../README.md).

Comparación entre el enunciado `PROYECTO 1 RESTAURANTE (APP WEB) (1).docx` y el estado del proyecto a 26/11/2026 (revisado el código, la base de datos y el historial de git).

**Leyenda:** `[x]` hecho · `[~]` a medias · `[ ]` sin hacer · `[?]` revisar a mano (no se puede comprobar desde el código)

**Fechas:** prueba de validación el **viernes 4/12/2026**; entrega en Git **con la memoria** el **domingo 6/12/2026** (lo que se cambie después no se evalúa); presentaciones la semana del **7 al 11/12**.

**Resumen:** la tienda está completa de principio a fin: home, carta, detalle con personalización, carrito con código promocional, registro con validación en el servidor, login, «Mi cuenta» y **compra guardada en la base de datos** con su pantalla de confirmación. El **panel de administración** lista todas las tablas sin recargar, **filtra y ordena**, edita productos y categorías, **activa y desactiva** productos y categorías, cambia el estado de los pedidos y enseña los ingredientes de cada producto, los productos de cada pedido y el **historial de pedidos de cada usuario**. Usa `sessionStorage` y `localStorage`. Faltan **crear registros**, **editar los productos y el precio de un pedido**, las **ofertas**, el **despliegue** y la **memoria**.

---

## Corregir ya

- [x] **Mayúsculas en los `include`.** Todos los archivos, includes y `fetch_object` usan el nombre exacto de la clase (ver «Convención de nombres»).
- [x] **Contraseña del admin en `sql/InsertarDatosBD.sql`:** guardada con hash bcrypt (`Admin1234!`).
- [x] **Impuestos:** los precios de la BBDD ya incluyen un IVA del 10 %. El carrito lo enseña como información (subtotal sin IVA + IVA).
- [x] **Redirección de `ProductosController::anadirCarrito`** cuando no llega por POST: ya lleva `index.php?` en la URL.
- [x] **Rol del usuario:** al leer un usuario de la base de datos, el constructor de `Usuarios` volvía a poner el rol en `usuario` y el administrador no se reconocía. Corregido: el valor por defecto va en la propiedad.
- [x] **JavaScript en el detalle del producto** (`assets/js/app.js`): se mantiene, porque solo actualiza el total en pantalla y el servidor vuelve a comprobarlo todo al añadir al carrito.
- [x] ~~Empezar a trabajar con ramas~~: el profesor confirmó el 22/11 que en este proyecto no hacen falta; se sigue trabajando en `main`.
- [ ] **Pago en efectivo:** el pedido se guarda siempre con `estado_pago` `pagado`; en efectivo debería quedar `pendiente` (`CarritoController::confirmar`).
- [ ] Al añadir al carrito un producto que ya estaba, la suma de cantidades puede pasar de 99.

---

## Web: usuario

### Figma pendiente

Notas de revisión del diseño (las hechas están en «Notas de `main.php` ya hechas»):

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
- [x] **Validar el registro en el servidor:** nombre (obligatorio, máx. 100), email (formato, máx. 150), contraseña (mín. 8), teléfono y fecha de nacimiento opcionales (formato y que no sea futura). Con errores no se guarda nada y se avisa de todos a la vez.
- [x] Iniciar sesión con `password_verify`, `UsuariosDAO::getByEmail` y `session_regenerate_id`.
- [x] Cerrar sesión (`UserController::logout`).
- [x] Cabecera según la sesión: botón de salir solo con la sesión iniciada.
- [ ] Volver a «Datos y pago» después de iniciar sesión si se venía del carrito (ahora el login siempre lleva a «Mi cuenta»).
- [ ] Login: leer `$_POST['email']` y `$_POST['password']` con `??` para que no salgan avisos.

### Panel de usuario («Mi cuenta»)

- [x] Ver los datos personales.
- [x] **Modificar los datos personales** (lo pide el enunciado): botón «Editar» en «Mis datos» que abre un modal de Bootstrap con el formulario. `UserController::actualizarDatos` comprueba sesión y POST, valida los datos (email válido y que no sea de otra cuenta, teléfono y fecha), guarda con `UsuariosDAO::update`, cambia la contraseña solo si se escribe una nueva (`updatePassword`), actualiza `$_SESSION['usuario']` y redirige al panel con un aviso.
- [x] Ver los pedidos realizados, con el detalle desplegable y el resumen (`views/usuario/panel.php`).
- [x] **Ver los datos del último pedido al volver a entrar:** la lista sale del más reciente al más antiguo, con su detalle desplegable, y el resumen enseña el estado del último.
- [ ] Opcional: destacar el último pedido en un bloque «Tu último pedido».

### Productos

- [x] Carta con todos los productos, filtrada por categoría y usando la BBDD.
- [x] Detalle del producto con ingredientes base y extras.
- [x] Quitar y añadir ingredientes.
- [x] El servidor calcula el precio con los extras y no se fía del navegador.
- [x] Total del detalle actualizado al marcar extras o cambiar la cantidad (`app.js`; el servidor recalcula el precio).
- [x] Contador de productos en la cabecera.
- [x] Sección «Elige tu categoría» de la home conectada a la BBDD, solo con categorías activas.
- [x] Colores por categoría en home, carta y detalle.
- [x] Píldoras de filtro solo con categorías activas.
- [x] Enlace a la personalización desde «Editar» y desde la caja de color de la carta.
- [x] Error 404 si el producto no existe, está inactivo o su categoría está desactivada.
- [x] En bebidas solo se puede quitar el hielo, y siempre queda al menos un ingrediente base: lo controla el formulario y **también el servidor** en `anadirCarrito` (cada producto decide sus ingredientes fijos con `esIngredienteFijo`).
- [x] Avisos de un solo uso tras añadir al carrito.
- [x] Botón «Añadir al carrito» de la carta: añade 1 unidad sin personalizar.
- [x] `anadirCarrito` solo acepta POST y limita la cantidad entre 1 y 99.
- [x] Los productos de categorías desactivadas no salen en la home, la carta ni el detalle (`quitarCategoriasInactivas`).
- [ ] `carta()`: leer `$_GET['pildora']` con `??` (sale un aviso si la URL no lo lleva).
- [ ] Al confirmar la compra, comprobar que los productos del carrito siguen activos (si se desactivan después de añadirlos, ahora se venden igual).

### Carrito

- [x] Guardado en sesión, con línea separada por cada personalización.
- [x] Página del carrito (`views/carrito/carrito.php`), enlazada desde el icono de la cabecera.
- [x] Cambiar la cantidad con los botones − y + (entre 1 y 99), sin JavaScript.
- [x] ~~Modificar la personalización de un producto ya añadido~~: decidido que no; se elimina la línea y se vuelve a añadir.
- [x] Eliminar un producto con aviso (papelera con `<details>`, sin JavaScript).
- [x] Leyenda producto / cantidad / precio.
- [x] Subtotal, IVA, envío (gratis a partir de 50 €), descuento y total (`CarritoController::calcularTotales`).
- [x] Código promocional (`aplicarCodigo`): comprueba que esté activo y en fechas y lo guarda en la sesión.
- [ ] Botón «Aplicar» junto al campo del código (ahora se envía con Enter).

### Finalizar la compra

- [x] Vista del paso 2 «Datos y pago» (`views/carrito/pago.php`): datos del usuario, método de pago simulado y resumen.
- [x] Vista del paso 3 «Confirmación» (`views/carrito/confirmacion.php`).
- [x] `datosPago()`: sin sesión → login; carrito vacío → carta. Los métodos de pago salen de `CarritoController::getMetodosPago()`.
- [x] `confirmar()`: solo POST, comprueba sesión, carrito y método de pago, y recalcula los precios en el servidor.
- [x] Guardar en `pedidos`, `pedido_detalle` y `pedido_detalle_ingrediente` (`insert` e `insertDetalle` devuelven el id creado).
- [x] Vaciar el carrito y el código promocional tras confirmar.
- [x] Confirmación por GET (`pedidoConfirmado`) después de redirigir (patrón PRG): recargar no duplica el pedido. Comprueba que el pedido existe y es del usuario.
- [x] Decidir qué se guarda en `pedidos.subtotal` y `total`: `subtotal` = suma de los productos con IVA; `total` = lo que paga el cliente (con envío y descuento).
- [ ] Opcional: guardar todo con una transacción, para no dejar pedidos a medias si falla algo.
- [ ] Opcional: guardar el envío del pedido. `total` lo incluye, pero la tabla `pedidos` no tiene columna `envio`, así que en «Mi cuenta» subtotal − descuento no cuadra con el total cuando hay 5 € de envío. Opciones: añadir la columna `envio` (BD, modelo, DAO y diagramas) o enseñar la diferencia como «Envío» en la vista.

### Ofertas

- [x] Tablas, datos de ejemplo, modelo y `OfertasDAO`.
- [x] Códigos promocionales: se aplican en el carrito.
- [ ] Controlador y página de ofertas.
- [ ] **Diseño individual para cada oferta**, como pide el enunciado.
- [ ] Añadir una oferta al carrito: el botón de la oferta añade sus productos normales.
- [ ] **Oferta por comprar una cantidad determinada de productos** (la cita la introducción del enunciado): el 2x1.
- [~] Aplicar cada tipo en `calcularTotales`, detectándolo en el carrito: `codigo` hecho; faltan `combo`, `2x1` y `descuento`.
- [~] Comprobar fechas de validez y `activa`: hecho para los códigos (`getCodigosActivos`).

### Código

- [x] Estructura MVC con `index.php` como punto de entrada.
- [x] Clases y clases estáticas: DAO estáticos, `Productos` abstracta y sus clases hijas.
- [x] Modelos de todas las tablas y DAO con consultas preparadas.
- [x] Página de error común con `showError()`.
- [x] Funciones de formato comunes en `helpers/formato.php` (`precio`, `texto`, `dato`, `fecha`, `mesAnio`), usadas en todas las vistas; todo el texto se escapa.
- [x] Funciones de depuración en `helpers/debug.php` (cargadas desde `index.php`).
- [x] Las vistas solo pintan: los datos (usuario, métodos de pago, totales) los prepara el controlador.
- [x] CSS separado por archivos, comentado y sin reglas obsoletas.
- [x] Quitados los `echo` de prueba de `anadirCarrito`.
- [x] Limpiar `views/productos/carta.php`: llevaba un `<!DOCTYPE>` completo dentro de `main.php`.
- [x] **Polimorfismo:** `Productos` tiene `esIngredienteFijo()` y `Bebidas` lo redefine (en las bebidas solo se puede quitar el hielo). `ProductosController` lo usa sin saber de qué clase es cada producto.
- [~] Comentarios: el CSS, el JavaScript del panel y lo último están comentados; falta repasar DAO y controladores antiguos.
- [~] Quitar el `?>` final de los archivos que solo tienen PHP: un salto de línea detrás puede romper las redirecciones en el servidor. Hecho en los DAO, `UserController`, `Usuarios`, `Productos` y `Bebidas`; faltan `HomeController`, el resto de modelos y `config/parameters.php`.
- [x] Todos los DAO tienen `update`; `insert` devuelve el id creado y `delete` las filas borradas. `ProductosDAO` con todos los productos (crea la clase hija según la categoría).
- [ ] `config/parameters.php`: las líneas `$_SESSION[...] = null` no hacen nada (se ejecutan antes de `session_start()`).
- [ ] Revisar el `<form>` de filtros de la carta: su `action` no se usa porque las píldoras son enlaces.

### Seguridad

- [x] Consultas preparadas en todos los DAO (inyección SQL).
- [x] Contraseñas con `password_hash` / `password_verify` y `session_regenerate_id` al iniciar sesión.
- [x] Salida escapada con `texto()` / `dato()` (XSS); en el panel, los datos se pintan con `textContent`.
- [x] Precios y totales recalculados siempre en el servidor.
- [x] Validación en el servidor del registro, de la compra y de lo que se guarda desde el panel.
- [x] La confirmación solo enseña pedidos del propio usuario.
- [x] El panel y la API solo responden a administradores (se comprueba en PHP en cada petición, no solo ocultando el botón).
- [x] La API no envía la contraseña de los usuarios.
- [ ] `.htaccess` que bloquee `.env`, `.git/`, `sql/`, `config/` y los `.md`.
- [ ] Token CSRF en los formularios.
- [ ] `config/DataBase.php`: no mostrar el error de MySQL con `die()` y leer la conexión de variables de entorno (para el servidor).

---

## Panel de administración

**Cómo se entra:** el administrador inicia sesión en la tienda y en su menú de usuario aparece «Panel administración» (solo si su rol es `admin`). `AdminController` vuelve a comprobar el rol antes de enseñar el panel (`views/admin/panel.php`), y su JavaScript (`assets/js/admin.js`) solo se carga en esa vista.

### API en PHP (`ApiController`)

- [x] Controlador de API que responde en JSON con sus códigos HTTP (400 datos incorrectos, 403 sin permiso, 404 no encontrado, 405 método no permitido, 409 nombre repetido).
- [x] Proteger los endpoints: cada acción comprueba en PHP que el usuario de la sesión es administrador.
- [x] **Sesión del administrador por un endpoint:** el admin inicia sesión con el login de la tienda y la acción `sesion` devuelve sus datos al panel (403 si no es admin).
- [x] Productos: listar, ver uno con sus ingredientes (GET) y modificar (PUT), con validación.
- [x] Categorías: listar, ver una (GET) y modificar (PUT), con validación.
- [x] Pedidos: listar, ver uno con sus productos y los ingredientes que se quitaron o añadieron (GET), y cambiar el estado (PUT).
- [x] Usuarios: listar y ver uno con su historial de pedidos (GET).
- [x] Ingredientes y ofertas: listar y ver uno (GET).
- [x] Métodos `getAllJson` y `getByIdJson` en todos los DAO (devuelven arrays para `json_encode`), y los de las líneas e ingredientes de los pedidos.
- [ ] **Crear registros (POST)** en todas las tablas principales: categorías, ingredientes, productos, usuarios, ofertas y pedidos. Los `insert` de los DAO ya existen.
- [ ] PUT de ingredientes (y de ofertas si da tiempo).
- [ ] Pedidos: añadir o quitar productos y cambiar el precio final (método nuevo en `PedidosDAO`).
- [x] ~~Eliminar (DELETE)~~: se usa borrado lógico (activar y desactivar), porque los pedidos antiguos necesitan los productos.

### Funciones del panel

- [x] Listar productos, pedidos, usuarios, categorías, ingredientes y ofertas sin recargar.
- [x] **Ordenar** cualquier tabla al pulsar el título de una columna (ascendente y descendente, también con números y fechas). Se mantiene al recargar la tabla.
- [x] **Filtrar** cualquier tabla mientras se escribe, buscando en todas las columnas (también en el estado de los pedidos).
- [x] Detalle de cada registro en un formulario; **Guardar** solo aparece en las tablas que se pueden modificar.
- [x] Activar y desactivar productos y categorías desde la tabla.
- [x] Cambiar el estado de un pedido desde la tabla.
- [x] Detalle de un producto con sus ingredientes; detalle de un pedido con sus productos y los cambios de cada uno.
- [x] Listar usuarios y ver el **historial de pedidos** de cada uno.
- [x] Cambiar entre las vistas del panel sin recargar, con el apartado actual en negrita; se recuerda la última vista.
- [ ] Botón «Nuevo» y formulario para crear registros en cada tabla.
- [ ] Añadir o eliminar productos de un pedido y modificar el precio final.
- [ ] Opcional: añadir y quitar ingredientes de un producto.

### Requisitos técnicos en JavaScript

- [x] DOM: crear y modificar elementos de forma dinámica (filas, botones, formularios y selects).
- [x] Eventos: clics, envío de formularios, cambio de un select y escritura en los filtros.
- [x] `map`, `filter`, `some`, `sort` y `forEach`.
- [x] **Al menos 2 clases:** `AdministradorVistas`, `Producto`, `Categoria` y `Sesion`.
- [x] Una clase para cambiar de vista sin recargar: `AdministradorVistas`.
- [x] **Storage, uso 1:** `sessionStorage` guarda los datos del administrador de la sesión (se borran al cerrar sesión o la pestaña). No da permisos: la API sigue comprobando la sesión de PHP.
- [x] **Storage, uso 2:** `localStorage` recuerda la última vista del panel. Justificarlo en la memoria.
- [~] `fetch` para pedir datos y enviar cambios (GET y PUT); falta POST.
- [ ] Opcional: funcionalidades adicionales que aporten valor.

---

## Diseño

- [?] Moodboard (color, forma, tipografía y composición).
- [?] Prototipo de escritorio a 1080 px en Figma.
- [x] Home con cabecera, banner, más de 3 secciones y pie.
- [x] Home responsive.
- [x] Página de carta.
- [x] Página de detalle del producto.
- [~] Páginas del proceso de compra con precio e impuestos: hechas en la web (carrito, datos y pago, confirmación); faltan en el prototipo.
- [x] HTML, CSS y Bootstrap.
- [x] Tipografía Satoshi: nombres igualados entre `variables.css` y `satoshi.css` y rutas corregidas.
- [x] Imágenes optimizadas: productos y home en WebP, logos e iconos en SVG.
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
- [x] Papelera que elimina el producto completo con aviso.
- [x] Leyenda producto / cantidad / precio en el carrito.

### Notas de `main.php` aún pendientes

- [ ] Dejar marcado en el menú el apartado actual.
- [ ] Enlaces del pie y botón «Conócenos» de la home: llevan a `#`.

---

## Base de datos

- [x] MySQL en Docker: `mysql-db` activo en el puerto 3308.
- [x] Scripts de creación y datos en `sql/`.
- [x] Diagrama entidad-relación (`docs/diagramas/`, aún sin subir).
- [x] Modelo relacional (`docs/diagramas/`, aún sin subir).

---

## Servicios web

- [x] Entorno local con XAMPP (PHP 8.2) y Ubuntu en WSL (Apache, PHP 8.5), con la base de datos compartida en Docker.
- [x] La `url` de `config/parameters.php` se calcula sola (sirve en XAMPP, WSL y servidor).
- [ ] **Depurador PHP:** Xdebug no está instalado (de momento se deja fuera).
- [ ] Documentar los plugins del IDE.
- [ ] Elegir y configurar un servidor web. Debe poder ejecutar la BBDD, así que un VPS con Docker encaja bien.
- [ ] Subir la web por FTP.
- [ ] Dominio público.
- [ ] Cambiar la contraseña `root` de la BBDD en el servidor real.

---

## GitHub

- [x] Repositorio `danipyxcala-afk/Daw2mvc` con 62 commits.
- [x] ~~Trabajar en ramas~~: no hace falta en este proyecto (lo confirmó el profesor el 22/11). Todos los commits van directamente a `main`.
- [x] Añadir `.gitignore`.
- [x] Dar acceso al repositorio a todos los profesores.
- [ ] Añadir el enlace del repositorio donde pide el enunciado.
- [ ] **Subir la memoria y los diagramas:** el enunciado pide todo en el repositorio. Añadir `!docs/diagramas/` y `!docs/memoria/` al `.gitignore`.
- [x] `README.md` nuevo y `READMEProfe.md` quitado.
- [ ] Decidir si se sube el enunciado (`.docx`, ahora sin seguimiento).
- [ ] Decidir si se entrega `PREGUNTAS.md`.

---

## Memoria

Hay un borrador en `docs/memoria/memoria.md` (aún sin subir), con las ideas de cada apartado. Se entrega con el proyecto el 6/12.

- [~] Título, índice, bibliografía o webgrafía y anexos (esqueleto).
- [~] Introducción: 1.1 «Qué es Sigmeat» y 1.2 redactados; objetivos y tecnologías con datos.
- [~] Un apartado por cada bloque del enunciado: web, panel, diseño, BBDD, servicios web y GitHub (ideas apuntadas, falta redactar).
- [~] Diagrama de clases y cómo interactúan (diagrama hecho en `docs/diagramas/`, falta explicarlo).
- [~] Diagramas entidad-relación y relacional (hechos, falta meterlos en la memoria).
- [ ] Moodboard, prototipo y justificación del diseño.
- [~] Explicación de la API y del uso de Storage (tabla de endpoints y los dos usos de Storage, falta actualizar con lo último).
- [ ] Capturas de la web y del panel.
- [ ] Revisión de ortografía y vocabulario.

### Presentación

- [ ] Preparar la presentación (semana del 7 al 11/12).

---

## Orden recomendado

Revisado el 26/11, con la entrega el 6/12:

1. ~~Hasta el 24/11: tienda completa, panel con listar, editar, activar y desactivar, y Storage.~~ Hecho.
2. ~~26/11: filtrar, ordenar, ingredientes en el detalle, productos de cada pedido e historial de usuarios.~~ Hecho.
3. **27 y 28/11:** crear registros en todas las tablas principales (POST y formulario en el panel).
4. **29/11:** pedidos: añadir o quitar productos y cambiar el precio final.
5. **30/11:** ofertas (página, diseño individual, añadir al carrito y 2x1).
6. **1/12:** despliegue (servidor, FTP, dominio y `.htaccess`).
7. **2/12:** margen y arreglos pendientes («Corregir ya» y avisos de PHP).
8. **3/12:** preparar la prueba de validación del 4/12.
9. **5 y 6/12:** cerrar la memoria con capturas, subir memoria y diagramas, y prueba completa.
