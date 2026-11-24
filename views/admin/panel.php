<div class="container">
    <nav id="menu-admin" class="navbar mb-5">
        <!-- Importante poner # para no recargar pag -->
        <a href="#" class="fw-bold" data-view="menu">Menu</a>
        <a href="#" data-view="pedidos">Pedidos</a>
        <a href="#" data-view="usuarios">Usuarios</a>
        <a href="#" data-view="productos">Productos</a>
        <a href="#" data-view="ingredientes">Ingredientes</a>
        <a href="#" data-view="categorias">Categorias</a>
        <a href="#" data-view="ofertas">Ofertas</a>

    </nav>
    <section data-view="menu">
        <h1>Hola <?= dato($_SESSION['usuario']->getNombre()) ?></h1>
        <p>Aqui tienes disponibles los paneles de pedidos para gestionarlos</p>
    </section>

    <section data-view="pedidos" hidden>

        <!-- Revisar idea de productos para filtrar pedidos pendientes -->
        <table id="pedidos" class="table">
            <thead>
                <tr>
                    <th scope="col">estadoPed</th>
                    <th scope="col">idPed</th>
                    <th scope="col">clienteId</th>
                    <th scope="col">fechaPedido</th>
                    <th scope="col">Total</th>
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
    </section>

    <section data-view="usuarios" hidden>
        <table id="usuarios" class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">telefono</th>
                    <th scope="col">direccion</th>
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
        <table id="productos" class="table">
            <thead>
                <tr>
                    <th scope="col">Activo</th>
                    <th scope="col">ID</th>
                    <th scope="col">Cat_Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>

    <section data-view="categorias" hidden>
        <table id="categorias" class="table">
            <thead>
                <tr>
                    <th scope="col">Activo</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>
    <section data-view="ingredientes" hidden>

        <!-- Revisar idea de productos para filtrar pedidos pendientes -->
        <table id="ingredientes" class="table">
            <thead>
                <tr>
                    <th scope="col">Activo</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio_extra</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>
    <section data-view="ofertas" hidden>

        <!-- Revisar idea de productos para filtrar pedidos pendientes -->
        <table id="ofertas" class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Detalle</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>



</div>
<script src="<?= url ?>/assets/js/admin.js" defer></script>
