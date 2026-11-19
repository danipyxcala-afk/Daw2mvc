<div class="container">
    <nav class="navbar mb-5">
        <!-- Importante poner # para no recargar pag -->
        <a href="#" data-view="menu">Menu</a>
        <a href="#" data-view="pedidos">Pedidos</a>
        <a href="#" data-view="usuarios">Usuarios</a>
        <a href="#" data-view="productos">Productos</a>
        <a href="#" data-view="categorias">Categorias</a>

    </nav>
    <section data-view="menu">
        <h1>hola Admin!</h1>
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
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
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
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>

    <section data-view="productos" hidden>
        <!-- idea para filtrar dentro del filtro <nav id="navprod" class="navbar mb-5">
            Importante poner # para no recargar pag
            <a href="#" data-view="Todo">Menu</a>
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
                    <th scope="col">Eliminar</th>
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
                    <th scope="col">Activa</th>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Detalle</th>
                    <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </section>




</div>
<script src="<?= url ?>/assets/js/admin.js" defer></script>
