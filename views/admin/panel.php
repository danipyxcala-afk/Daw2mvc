<div class="container">
    <nav id="menu-admin" class="navbar mb-5">
        <!-- menu, cada data-view abre la seccion con el mismo nombre (el # es para no recargar la pag) -->
        <a href="#" class="fw-bold" data-view="menu">Menu</a>
        <a href="#" data-view="pedidos">Pedidos</a>
        <a href="#" data-view="productos">Productos</a>
        <a href="#" data-view="ingredientes">Ingredientes</a>
        <a href="#" data-view="categorias">Categorias</a>
        <a href="#" data-view="ofertas">Ofertas</a>
        <a href="#" data-view="usuarios">Usuarios</a>

    </nav>
    <!-- pantalla de inicio -->
    <section data-view="menu">
        <h1>Hola <span id="admin-nombre"></span></h1>
        <p>Aqui tienes disponibles los paneles de pedidos para gestionarlos</p>
    </section>

    <!-- pantalla de pedidos, hidden la esconde hasta que se pulsa en el menu -->
    <section data-view="pedidos" hidden>
        <!-- buscador de la tabla (Revisar idea de productos para filtrar pedidos pendientes) -->
        <label for="filtrar-pedidos">Filtrar pedidos</label>
        <input type="search" id="filtrar-pedidos" data-filtro="pedidos" class="form-control mb-3">
        <!-- tabla, pulsando la cabecera se ordena y el JS rellena el tbody -->
        <table id="pedidos" class="table">
            <thead>
                <tr>
                    <th scope="col" data-ordenar role="button">estadoPed</th>
                    <th scope="col" data-ordenar role="button">idPed</th>
                    <th scope="col" data-ordenar role="button">clienteId</th>
                    <th scope="col" data-ordenar role="button">fechaPedido</th>
                    <th scope="col" data-ordenar role="button">Total</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>

    <!-- detalle de un registro, el JS lo rellena al pulsar en Detalle -->
    <section data-view="detalle" hidden>
        <!-- datos del registro, el formulario lo crea el JS -->
        <div class="bg-light rounded-4 p-4 p-sm-5">
            <h2 class="fs-3 mb-4" id="detalle-titulo">Detalle</h2>
            <div id="detalle-contenido"></div>
            <button type="button" class="btn btn-outline-secondary mt-3" id="detalle-volver">Volver</button>
        </div>
        <!-- historial de pedidos, solo sale en el detalle de un usuario -->
        <div class="bg-light rounded-4 p-4 p-sm-5 mt-5" id="detalle-usuarios" hidden>
            <h3 class="fs-5">Historial de pedidos</h3>
            <table class="table table-sm table-hover" id="detalle-usu">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- productos del pedido con sus cambios, solo sale en el detalle de un pedido -->
        <div class="bg-light rounded-4 p-4 p-sm-5 mt-5" id="detalle-pedidos" hidden>
            <h3 class="fs-5">Productos del pedido</h3>
            <table class="table table-sm table-hover" id="detalle-ing-producto">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Cambios de extras</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- ingredientes, solo sale en el detalle de un producto -->
        <div class="bg-light rounded-4 p-4 p-sm-5 mt-5" id="detalle-ingredientes" hidden>
            <h3 class="fs-5">Ingredientes</h3>
            <table class="table table-sm table-hover" id="ingredientes-producto">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio extra</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </section>

    <!-- pantalla de usuarios, hidden la esconde hasta que se pulsa en el menu -->
    <section data-view="usuarios" hidden>
        <!-- boton que enseña/oculta el formulario de crear -->
        <div>
            <button type="button" class="btn btn-primary mb-3" data-nuevo="usuarios">Crear usuario</button>
        </div>
        <!-- formulario de crear, cada name es el nombre de la columna en la BBDD -->
        <form class="row g-3 bg-light rounded-4 p-4 mb-3" data-crear="usuarios" hidden>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-nombre">Nombre</label>
                <input type="text" class="form-control" id="nuevo-usuario-nombre" name="nombre" maxlength="100" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-email">Email</label>
                <input type="email" class="form-control" id="nuevo-usuario-email" name="email" maxlength="150" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-password">Contraseña</label>
                <input type="password" class="form-control" id="nuevo-usuario-password" name="password" minlength="8" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-telefono">Teléfono</label>
                <input type="tel" class="form-control" id="nuevo-usuario-telefono" name="telefono" maxlength="20">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-direccion">Dirección</label>
                <input type="text" class="form-control" id="nuevo-usuario-direccion" name="direccion" maxlength="255">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-nacimiento">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="nuevo-usuario-nacimiento" name="fecha_nacimiento">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-usuario-rol">Rol</label>
                <select class="form-select" id="nuevo-usuario-rol" name="rol">
                    <option value="usuario">usuario</option>
                    <option value="admin">admin</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <!-- buscador de la tabla -->
        <label for="filtrar-usuarios">Filtrar usuarios</label>
        <input type="search" id="filtrar-usuarios" data-filtro="usuarios" class="form-control mb-3">
        <!-- tabla, pulsando la cabecera se ordena y el JS rellena el tbody -->
        <table id="usuarios" class="table">
            <thead>
                <tr>
                    <th scope="col" data-ordenar role="button">ID</th>
                    <th scope="col" data-ordenar role="button">Nombre</th>
                    <th scope="col" data-ordenar role="button">Email</th>
                    <th scope="col" data-ordenar role="button">telefono</th>
                    <th scope="col" data-ordenar role="button">direccion</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>

    <!-- pantalla de productos, hidden la esconde hasta que se pulsa en el menu -->
    <section data-view="productos" hidden>
        <!-- boton que enseña/oculta el formulario de crear -->
        <div>
            <button type="button" class="btn btn-primary mb-3" data-nuevo="productos">Crear producto</button>
        </div>
        <!-- formulario de crear, cada name es el nombre de la columna en la BBDD (solo las 4 categorias que conoce ProductosDAO) -->
        <form class="row g-3 bg-light rounded-4 p-4 mb-3" data-crear="productos" hidden>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-producto-categoria">Categoría</label>
                <select class="form-select" id="nuevo-producto-categoria" name="categoria_id">
                    <option value="1">Hamburguesas</option>
                    <option value="2">Complementos</option>
                    <option value="3">Bebidas</option>
                    <option value="4">Postres</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-producto-nombre">Nombre</label>
                <input type="text" class="form-control" id="nuevo-producto-nombre" name="nombre" maxlength="150" required>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold" for="nuevo-producto-descripcion">Descripción</label>
                <textarea class="form-control" id="nuevo-producto-descripcion" name="descripcion" rows="2"></textarea>
            </div>
            <!-- step="0.01" deja poner centimos, sin el solo acepta enteros -->
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-producto-precio">Precio (€)</label>
                <input type="number" class="form-control" id="nuevo-producto-precio" name="precio" min="0" step="0.01" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-producto-imagen">Imagen (ruta)</label>
                <input type="text" class="form-control" id="nuevo-producto-imagen" name="imagen" maxlength="255" placeholder="img/productos/nombre.webp">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-producto-activo">Estado</label>
                <select class="form-select" id="nuevo-producto-activo" name="activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <!-- buscador de la tabla -->
        <label for="filtrar-productos">Filtrar productos</label>
        <input type="search" id="filtrar-productos" data-filtro="productos" class="form-control mb-3">
        <!-- tabla, pulsando la cabecera se ordena y el JS rellena el tbody -->
        <table id="productos" class="table">
            <thead>
                <tr>
                    <th scope="col" data-ordenar role="button">Estado</th>
                    <th scope="col" data-ordenar role="button">ID</th>
                    <th scope="col" data-ordenar role="button">Cat_Id</th>
                    <th scope="col" data-ordenar role="button">Nombre</th>
                    <th scope="col" data-ordenar role="button">Descripcion</th>
                    <th scope="col" data-ordenar role="button">Precio</th>
                    <th scope="col" colspan="2">Acción</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </section>

    <!-- pantalla de categorias, hidden la esconde hasta que se pulsa en el menu -->
    <section data-view="categorias" hidden>
        <!-- boton que enseña/oculta el formulario de crear -->
        <div>
            <button type="button" class="btn btn-primary mb-3" data-nuevo="categorias">Crear categoría</button>
        </div>
        <!-- formulario de crear, cada name es el nombre de la columna en la BBDD -->
        <form class="row g-3 bg-light rounded-4 p-4 mb-3" data-crear="categorias" hidden>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-categoria-nombre">Nombre</label>
                <input type="text" class="form-control" id="nueva-categoria-nombre" name="nombre" maxlength="100" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-categoria-activa">Estado</label>
                <select class="form-select" id="nueva-categoria-activa" name="activa">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold" for="nueva-categoria-descripcion">Descripción</label>
                <textarea class="form-control" id="nueva-categoria-descripcion" name="descripcion" rows="2"></textarea>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <!-- buscador de la tabla -->
        <label for="filtrar-categorias">Filtrar categorías</label>
        <input type="search" id="filtrar-categorias" data-filtro="categorias" class="form-control mb-3">

        <!-- tabla, pulsando la cabecera se ordena y el JS rellena el tbody -->
        <table id="categorias" class="table">
            <thead>
                <tr>
                    <th scope="col" data-ordenar role="button">Estado</th>
                    <th scope="col" data-ordenar role="button">ID</th>
                    <th scope="col" data-ordenar role="button">Nombre</th>
                    <th scope="col" data-ordenar role="button">Descripcion</th>
                    <th scope="col" colspan="2">Acción</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>
    <!-- pantalla de ingredientes, hidden la esconde hasta que se pulsa en el menu -->
    <section data-view="ingredientes" hidden>
        <!-- boton que enseña/oculta el formulario de crear -->
        <div>
            <button type="button" class="btn btn-primary mb-3" data-nuevo="ingredientes">Crear ingrediente</button>
        </div>
        <!-- formulario de crear, cada name es el nombre de la columna en la BBDD -->
        <form class="row g-3 bg-light rounded-4 p-4 mb-3" data-crear="ingredientes" hidden>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nuevo-ingrediente-nombre">Nombre</label>
                <input type="text" class="form-control" id="nuevo-ingrediente-nombre" name="nombre" maxlength="100" required>
            </div>
            <!-- step="0.01" deja poner centimos, sin el solo acepta enteros -->
            <div class="col-md-3">
                <label class="form-label fw-bold" for="nuevo-ingrediente-precio">Precio extra (€)</label>
                <input type="number" class="form-control" id="nuevo-ingrediente-precio" name="precio_extra" min="0" step="0.01" value="0" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" for="nuevo-ingrediente-activo">Estado</label>
                <select class="form-select" id="nuevo-ingrediente-activo" name="activo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <!-- buscador de la tabla -->
        <label for="filtrar-ingredientes">Filtrar ingredientes</label>
        <input type="search" id="filtrar-ingredientes" data-filtro="ingredientes" class="form-control mb-3">

        <!-- tabla, pulsando la cabecera se ordena y el JS rellena el tbody -->
        <table id="ingredientes" class="table">
            <thead>
                <tr>
                    <th scope="col" data-ordenar role="button">Estado</th>
                    <th scope="col" data-ordenar role="button">Id</th>
                    <th scope="col" data-ordenar role="button">Nombre</th>
                    <th scope="col" data-ordenar role="button">Precio_extra</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>
    <!-- pantalla de ofertas, hidden la esconde hasta que se pulsa en el menu -->
    <section data-view="ofertas" hidden>
        <!-- boton que enseña/oculta el formulario de crear -->
        <div>
            <button type="button" class="btn btn-primary mb-3" data-nuevo="ofertas">Crear oferta</button>
        </div>
        <!-- formulario de crear, cada name es el nombre de la columna en la BBDD -->
        <form class="row g-3 bg-light rounded-4 p-4 mb-3" data-crear="ofertas" hidden>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-nombre">Nombre</label>
                <input type="text" class="form-control" id="nueva-oferta-nombre" name="nombre" maxlength="150" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-tipo">Tipo</label>
                <select class="form-select" id="nueva-oferta-tipo" name="tipo">
                    <option value="descuento">descuento</option>
                    <option value="2x1">2x1</option>
                    <option value="combo">combo</option>
                    <option value="codigo">codigo</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-bold" for="nueva-oferta-descripcion">Descripción</label>
                <textarea class="form-control" id="nueva-oferta-descripcion" name="descripcion" rows="2"></textarea>
            </div>
            <!-- step="0.01" deja poner centimos, sin el solo acepta enteros -->
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-valor">Valor</label>
                <input type="number" class="form-control" id="nueva-oferta-valor" name="valor" min="0" step="0.01">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-codigo">Código</label>
                <input type="text" class="form-control" id="nueva-oferta-codigo" name="codigo" maxlength="50">
            </div>
            <!-- datetime-local pide fecha y hora, como el datetime de la BBDD -->
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-inicio">Fecha de inicio</label>
                <input type="datetime-local" class="form-control" id="nueva-oferta-inicio" name="fecha_inicio" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-fin">Fecha de fin</label>
                <input type="datetime-local" class="form-control" id="nueva-oferta-fin" name="fecha_fin">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold" for="nueva-oferta-activa">Estado</label>
                <select class="form-select" id="nueva-oferta-activa" name="activa">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <!-- buscador de la tabla -->
        <label for="filtrar-ofertas">Filtrar ofertas</label>
        <input type="search" id="filtrar-ofertas" data-filtro="ofertas" class="form-control mb-3">
        <!-- tabla, pulsando la cabecera se ordena y el JS rellena el tbody -->
        <table id="ofertas" class="table">
            <thead>
                <tr>
                    <th scope="col" data-ordenar role="button">Id</th>
                    <th scope="col" data-ordenar role="button">Nombre</th>
                    <th scope="col" data-ordenar role="button">Descripcion</th>
                    <th scope="col" data-ordenar role="button">Tipo</th>
                    <th scope="col" data-ordenar role="button">Valor</th>
                    <th scope="col" data-ordenar role="button">Codigo</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>



</div>
<!-- url es la URL base de la web, defer carga el JS cuando ya esta todo el HTML -->
<script src="<?= url ?>/assets/js/admin.js" defer></script>
