# Lista de tareas · Proyecto 1 Restaurante (Sigmeat)

> Volver al [README](../README.md).

Comparación entre el enunciado `PROYECTO 1 RESTAURANTE (APP WEB) (1).docx` y el estado del proyecto a 20/11/2026 (revisado el código, la base de datos y el historial de git).

**Leyenda:** `[x]` hecho · `[~]` a medias · `[ ]` sin hacer · `[?]` revisar a mano (no se puede comprobar desde el código)

**Fechas:** entrega en Git el **martes 29/11/2026** (lo que se cambie después no se evalúa). Presentaciones entre el 29/11 y el 21/12.

**Resumen:** la tienda está completa de principio a fin: home, carta, detalle con personalización, carrito con código promocional, registro con validación en el servidor, login, «Mi cuenta» y **compra guardada en la base de datos** con su pantalla de confirmación. El **panel de administración** ya está empezado: la API devuelve en JSON productos, pedidos, usuarios y categorías solo a los administradores, y el panel cambia de vista y rellena las tablas sin recargar. Faltan **editar, borrar, filtrar y ordenar** en el panel, las **ofertas**, **modificar los datos del usuario**, el **despliegue**, **trabajar con ramas** y la **memoria**.

---

## Corregir ya

- [x] **Mayúsculas en los `include`.** Todos los archivos, includes y `fetch_object` usan el nombre exacto de la clase (ver «Convención de nombres»).
- [x] **Contraseña del admin en `sql/InsertarDatosBD.sql`:** guardada con hash bcrypt (`Admin1234!`).
- [x] **Impuestos:** los precios de la BBDD ya incluyen un IVA del 10 %. El carrito lo enseña como información (subtotal sin IVA + IVA).
- [x] **Redirección de `ProductosController::anadirCarrito`** cuando no llega por POST: ya lleva `index.php?` en la URL.
- [x] **Rol del usuario:** al leer un usuario de la base de datos, el constructor de `Usuarios` volvía a poner el rol en `usuario` y el administrador no se reconocía. Corregido: el valor por defecto va en la propiedad.
- [?] **JavaScript en el detalle del producto** (`assets/js/app.js`, recuperado el 14/11): el enunciado pide que la parte del usuario se haga **solo con PHP, HTML y CSS**. Confirmar con la profesora si se permite; si no, quitarlo y hacer el total con un botón «Actualizar total» (`formaction`) y la cantidad sin los botones −/+.
- [ ] **Empezar a trabajar con ramas** (ver «GitHub»): se evalúa y ahora todo está en `main`.

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
- [ ] **Modificar los datos personales** (lo pide el enunciado): `UsuariosDAO::update` y `updatePassword` ya existen; falta el formulario y actualizar `$_SESSION['usuario']` (sin la contraseña).
- [x] Ver los pedidos realizados, con el detalle desplegable, el resumen y los códigos de descuento (`views/usuario/panel.php`).
- [~] **Ver los datos del último pedido al volver a entrar:** la lista sale ordenada del más reciente al más antiguo y el resumen enseña el estado del último. Falta destacar los datos del último pedido (un bloque «Tu último pedido»).

### Productos

- [x] Carta con todos los productos, filtrada por categoría y usando la BBDD.
- [x] Detalle del producto con ingredientes base y extras.
- [x] Quitar y añadir ingredientes.
- [x] El servidor calcula el precio con los extras y no se fía del navegador.
- [~] Total del detalle actualizado al marcar extras o cambiar la cantidad: ahora lo hace `app.js` (ver «Corregir ya» sobre el JavaScript).
- [x] Contador de productos en la cabecera.
- [x] Sección «Elige tu categoría» de la home conectada a la BBDD, solo con categorías activas.
- [x] Colores por categoría en home, carta y detalle.
- [x] Píldoras de filtro solo con categorías activas.
- [x] Enlace a la personalización desde «Editar» y desde la caja de color de la carta.
- [x] Error 404 si el producto no existe o está inactivo.
- [~] En bebidas solo se puede quitar el hielo, y siempre queda al menos un ingrediente base: lo controla el formulario (`disabled` y JavaScript), pero **el servidor no lo comprueba** en `anadirCarrito`.
- [x] Avisos de un solo uso tras añadir al carrito.
- [x] Botón «Añadir al carrito» de la carta: añade 1 unidad sin personalizar.
- [x] `anadirCarrito` solo acepta POST y limita la cantidad entre 1 y 99.
- [ ] `carta()`: leer `$_GET['pildora']` con `??` (sale un aviso si la URL no lo lleva).
- [ ] Decidir si se ocultan los productos de categorías inactivas: ahora siguen saliendo en la carta.

### Carrito

- [x] Guardado en sesión, con línea separada por cada personalización.
- [x] Página del carrito (`views/carrito/carrito.php`), enlazada desde el icono de la cabecera.
- [x] Cambiar la cantidad con los botones − y + (entre 1 y 99), sin JavaScript.
- [ ] Modificar la personalización de un producto ya añadido.
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
- [x] Códigos promocionales: se listan en el panel de usuario y se aplican en el carrito.
- [ ] Controlador y página de ofertas.
- [ ] **Diseño individual para cada oferta**, como pide el enunciado.
- [ ] Añadir una oferta al carrito.
- [ ] **Oferta por comprar una cantidad determinada de productos** (la cita la introducción del enunciado).
- [~] Aplicar cada tipo: `codigo` hecho; faltan `combo`, `2x1` y `descuento`.
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
- [~] **Polimorfismo:** las hijas de `Productos` solo heredan y no cambian ningún método. Añadir uno con comportamiento distinto en cada hija.
- [~] Comentarios: el CSS y lo último están comentados; falta repasar DAO y controladores antiguos.
- [~] Quitar el `?>` final de los archivos que solo tienen PHP: un salto de línea detrás puede romper las redirecciones en el servidor. Hecho en los DAO, `UserController` y `Usuarios`; faltan `HomeController`, el resto de modelos y `config/parameters.php`.
- [x] Todos los DAO tienen `update`; `insert` devuelve el id creado y `delete` las filas borradas. Nuevo `ProductosDAO` con todos los productos (crea la clase hija según la categoría).
- [ ] `config/parameters.php`: las líneas `$_SESSION[...] = null` no hacen nada (se ejecutan antes de `session_start()`).
- [ ] Revisar el `<form>` de filtros de la carta: su `action` no se usa porque las píldoras son enlaces.

### Seguridad

- [x] Consultas preparadas en todos los DAO (inyección SQL).
- [x] Contraseñas con `password_hash` / `password_verify` y `session_regenerate_id` al iniciar sesión.
- [x] Salida escapada con `texto()` / `dato()` (XSS).
- [x] Precios y totales recalculados siempre en el servidor.
- [x] Validación en el servidor del registro y de la compra.
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

- [x] Controlador de API que responde en JSON con sus códigos HTTP (403 sin permiso, 404 sin acción, 405 método no permitido).
- [x] Proteger los endpoints: cada acción comprueba en PHP que el usuario de la sesión es administrador.
- [?] **Login de administrador mediante un endpoint** (lo pide el enunciado): ahora se usa el login de la tienda. Confirmar con la profesora si vale; si no, añadir una acción `login` o una acción `sesion` que devuelva los datos del admin.
- [~] Endpoints de productos: listar y ver uno por id (GET) hechos; falta modificar (PUT) y eliminar (DELETE).
- [~] Endpoints de pedidos: listar y ver uno hechos; falta cambiar el estado y el precio final, y añadir o quitar productos.
- [~] Endpoints de usuarios: listar y ver uno hechos; falta el historial de pedidos de cada usuario.
- [x] Endpoint de categorías: listar y ver una.
- [x] Métodos `getAllJson` y `getByIdJson` en todos los DAO (devuelven arrays para `json_encode`).
- [x] Métodos `update` en los DAO.
- [ ] Método en `PedidosDAO` para cambiar el precio final del pedido.

### Funciones del panel

- [~] Listar productos, pedidos, usuarios y categorías sin recargar (hecho); falta **modificar y ordenar**.
- [~] Botones «Detalle» y «Eliminar» en cada fila, y sección de detalle con «Volver»; falta enseñar los datos reales, el formulario para editar y borrar de verdad.
- [ ] Añadir o eliminar productos de un pedido y modificar el precio final.
- [ ] Filtrar productos y pedidos por nombre, ID, precio, etc.
- [~] Listar usuarios (hecho); falta ver el historial de cada uno.
- [x] Cambiar entre las vistas del panel sin recargar, con el apartado actual marcado en negrita.
- [ ] Revisar la accesibilidad: el diseño no puntúa, pero esto sí.

### Requisitos técnicos en JavaScript

- [x] DOM: crear y modificar elementos de forma dinámica (filas y botones de las tablas).
- [~] Eventos: clics hechos; faltan envíos de formularios y escritura (buscador).
- [ ] `map`, `filter`, `reduce` o similares.
- [ ] **Al menos 2 clases:** ahora hay una (`AdministradorVistas`). Separar los `fetch` en una clase `Api`.
- [~] Una clase específica para cambiar de vista sin recargar: `AdministradorVistas` lo hace, pero también pide y pinta los datos.
- [ ] `localStorage` o `sessionStorage` para la sesión.
- [ ] Un segundo uso de Storage, **justificado en la memoria** (por ejemplo, recordar el último filtro).
- [~] `fetch` para pedir datos (hecho); falta para enviar formularios.
- [ ] Opcional: funcionalidades adicionales que aporten valor.

---

## Diseño

- [?] Moodboard (color, forma, tipografía y composición).
- [?] Prototipo de escritorio a 1080 px en Figma.
- [x] Home con cabecera, banner, más de 3 secciones y pie.
- [~] Home responsive: hay reglas para móvil, pero falta probarla a **430x932** y sacar capturas.
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
- [ ] Botones más anchos en móvil.
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
- [ ] **Depurador PHP:** Xdebug no está instalado. Instalarlo y configurarlo en el IDE.
- [ ] Documentar los plugins del IDE.
- [ ] Elegir y configurar un servidor web. Debe poder ejecutar la BBDD, así que un VPS con Docker encaja bien.
- [ ] Subir la web por FTP.
- [ ] Dominio público.
- [ ] Cambiar la contraseña `root` de la BBDD en el servidor real.

---

## GitHub

- [x] Repositorio `danipyxcala-afk/Daw2mvc` con 48 commits.
- [ ] **Trabajar en ramas:** los 48 commits están en `main`, sin ramas ni fusiones. **Esto se evalúa**, así que cada tarea nueva debería ir en su rama (por ejemplo `feature/ofertas`, `feature/panel-admin`, `fix/anadir-carrito`).
- [ ] Fusionar en `main` todo lo que se suba.
- [x] Añadir `.gitignore`.
- [x] Dar acceso al repositorio a todos los profesores.
- [ ] Añadir el enlace del repositorio donde pide el enunciado.
- [ ] **Subir la memoria y los diagramas:** el enunciado pide todo en el repositorio. Añadir `!docs/diagramas/` y `!docs/memoria/` al `.gitignore`.
- [x] `README.md` nuevo y `READMEProfe.md` quitado.
- [ ] Decidir si se sube el enunciado (`.docx`, ahora sin seguimiento).
- [ ] Decidir si se entrega `PREGUNTAS.md`.

---

## Memoria

Hay un esqueleto en `docs/memoria/memoria.md` (aún sin subir). Conviene escribirla durante el desarrollo.

- [~] Título, índice, bibliografía o webgrafía y anexos (esqueleto).
- [~] Introducción: 1.1 «Qué es Sigmeat» redactado; objetivos y tecnologías con datos.
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

Las fechas son orientativas y cuentan con entregar el 29/11 (revisado el 20/11):

1. ~~Hasta el 8/11: aclarar dudas y «Corregir ya».~~ Hecho.
2. ~~Hasta el 12/11: login, registro, cierre de sesión y datos de usuario.~~ Hecho (falta modificar datos).
3. ~~Hasta el 17/11: lógica de datos y pago y confirmación, guardar el pedido.~~ Hecho el 14/11.
4. ~~Hasta el 20/11: base del panel y de la API.~~ Hecho: acceso del admin, API en JSON protegida, tablas y cambio de vista.
5. **Ya:** crear la rama `feature/panel-admin` y seguir el panel en ella.
6. **Hasta el 24/11:** panel: detalle y edición de productos (PUT), eliminar, 2 clases en JS, filtrar y ordenar, pedidos (estado, precio final y productos), historial de usuarios y Storage.
7. **Hasta el 25/11:** modificar los datos del usuario y bloque «Tu último pedido».
8. **Hasta el 27/11:** ofertas (página, diseño individual, añadir al carrito, oferta por cantidad).
9. **Hasta el 28/11:** Xdebug, despliegue (servidor, FTP, dominio), prototipo de compra y repaso de móvil.
10. **Hasta el 29/11:** cerrar la memoria, subir memoria y diagramas, fusionar todo en `main` y prueba completa.
