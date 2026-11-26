<div class="container">
    <nav id="menu-admin" class="navbar mb-5">
        <!-- Importante poner # para no recargar pag -->
        <a href="#" class="fw-bold" data-view="menu">Menu</a>
        <a href="#" data-view="pedidos">Pedidos</a>
        <a href="#" data-view="productos">Productos</a>
        <a href="#" data-view="ingredientes">Ingredientes</a>
        <a href="#" data-view="categorias">Categorias</a>
        <a href="#" data-view="ofertas">Ofertas</a>
        <a href="#" data-view="usuarios">Usuarios</a>

    </nav>
    <section data-view="menu">
        <h1>Hola <span id="admin-nombre"></span></h1>
        <p>Aqui tienes disponibles los paneles de pedidos para gestionarlos</p>
    </section>

    <section data-view="pedidos" hidden>
        <label for="filtrar-pedidos">Filtrar pedidos</label>
        <input type="search" id="filtrar-pedidos" data-filtro="pedidos" class="form-control mb-3">
        <!-- Revisar idea de productos para filtrar pedidos pendientes -->
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

    <section data-view="detalle" hidden>
        <div class="bg-light rounded-4 p-4 p-sm-5">
            <h2 class="fs-3 mb-4" id="detalle-titulo">Detalle</h2>
            <div id="detalle-contenido"></div>
            <button type="button" class="btn btn-outline-secondary mt-3" id="detalle-volver">Volver</button>
        </div>
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

    <section data-view="usuarios" hidden>
        <label for="filtrar-usuarios">Filtrar usuarios</label>
        <input type="search" id="filtrar-usuarios" data-filtro="usuarios" class="form-control mb-3">
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

    <section data-view="productos" hidden>
        <!-- <nav id="navprod" class="navbar mb-5">
            idea para filtrar dentro del filtro
            Importante poner # para no recargar pag
            <a href="#" data-view="Todo">Hamburgesas</a>
        </nav> -->
        <label for="filtrar-productos">Filtrar productos</label>
        <input type="search" id="filtrar-productos" data-filtro="productos" class="form-control mb-3">
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

    <section data-view="categorias" hidden>
        <label for="filtrar-categorias">Filtrar categorías</label>
        <input type="search" id="filtrar-categorias" data-filtro="categorias" class="form-control mb-3">

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
    <section data-view="ingredientes" hidden>
        <label for="filtrar-ingredientes">Filtrar ingredientes</label>
        <input type="search" id="filtrar-ingredientes" data-filtro="ingredientes" class="form-control mb-3">

        <!-- Revisar idea de productos para filtrar pedidos pendientes -->
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
    <section data-view="ofertas" hidden>
        <label for="filtrar-ofertas">Filtrar ofertas</label>
        <input type="search" id="filtrar-ofertas" data-filtro="ofertas" class="form-control mb-3">
        <!-- Revisar idea de productos para filtrar pedidos pendientes -->
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
<script src="<?= url ?>/assets/js/admin.js" defer></script>
