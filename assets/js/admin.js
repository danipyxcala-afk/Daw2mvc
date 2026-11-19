class AdministradorVistas {
  constructor() {
    this.productos = null;
    this.categorias = null;
    this.ingredientes = null;
    this.ofertas = null;
    this.usuarios = null;
    this.pedidos = null;
  }

  inicializar() {
    fetch("index.php?controller=api&action=productos")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.productos = r;
        const tablaProductos = document
          .getElementById("productos")
          .querySelector("tbody");
        this.productos.forEach((r) => {
          const tr = document.createElement("tr");
          const td6 = document.createElement("td");
          td6.textContent = r.activo ? "Activo" : "Inactivo";
          tr.append(td6);
          const td1 = document.createElement("td");
          td1.textContent = r.id;
          tr.append(td1);
          const td2 = document.createElement("td");
          td2.textContent = r.categoria_id;
          tr.append(td2);
          const td3 = document.createElement("td");
          td3.textContent = r.nombre;
          tr.append(td3);
          const td4 = document.createElement("td");
          td4.textContent = r.descripcion;
          tr.append(td4);
          const td5 = document.createElement("td");
          td5.textContent = r.precio;
          tr.append(td5);
          this.crearBotones(tr, "productos", r.id);

          tablaProductos.append(tr);
        });
      });
    fetch("index.php?controller=api&action=pedidos")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.pedidos = r;
        const tablaProductos = document
          .getElementById("pedidos")
          .querySelector("tbody");
        this.pedidos.forEach((r) => {
          const tr = document.createElement("tr");
          const td6 = document.createElement("td");
          td6.textContent = r.estado;
          tr.append(td6);
          const td1 = document.createElement("td");
          td1.textContent = r.id;
          tr.append(td1);
          const td2 = document.createElement("td");
          td2.textContent = r.usuario_id;
          tr.append(td2);
          const td3 = document.createElement("td");
          td3.textContent = r.fecha_pedido;
          tr.append(td3);
          const td4 = document.createElement("td");
          td4.textContent = r.total;
          tr.append(td4);
          this.crearBotones(tr, "pedidos", r.id);

          tablaProductos.append(tr);
        });
      });
    fetch("index.php?controller=api&action=usuarios")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.usuarios = r;
        const tablaProductos = document
          .getElementById("usuarios")
          .querySelector("tbody");
        this.usuarios.forEach((r) => {
          const tr = document.createElement("tr");
          const td6 = document.createElement("td");
          td6.textContent = r.id;
          tr.append(td6);
          const td1 = document.createElement("td");
          td1.textContent = r.nombre;
          tr.append(td1);
          const td2 = document.createElement("td");
          td2.textContent = r.email;
          tr.append(td2);
          const td3 = document.createElement("td");
          td3.textContent = r.telefono;
          tr.append(td3);
          const td4 = document.createElement("td");
          td4.textContent = r.direccion;
          tr.append(td4);
          this.crearBotones(tr, "usuarios", r.id);

          tablaProductos.append(tr);
        });
      });

    fetch("index.php?controller=api&action=categorias")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.categorias = r;
        const tablaProductos = document
          .getElementById("categorias")
          .querySelector("tbody");
        this.categorias.forEach((r) => {
          const tr = document.createElement("tr");
          const td6 = document.createElement("td");
          td6.textContent = r.activa ? "Activa" : "Inactiva";
          tr.append(td6);
          const td1 = document.createElement("td");
          td1.textContent = r.id;
          tr.append(td1);
          const td2 = document.createElement("td");
          td2.textContent = r.nombre;
          tr.append(td2);
          const td3 = document.createElement("td");
          td3.textContent = r.descripcion;
          tr.append(td3);
          this.crearBotones(tr, "categorias", r.id);

          tablaProductos.append(tr);
        });
      });

    //con esto unicamente pilla los del menu admin
    this.enlaces = document.querySelectorAll("#menu-admin a[data-view]");
    this.secciones = document.querySelectorAll("section[data-view]");

    this.enlaces.forEach((e) => {
      e.addEventListener("click", () => {
        //console.log(e.dataset.view);
        this.vista = e.dataset.view;
        this.enlaces.forEach((enlace) => {
          enlace.classList.toggle("fw-bold", enlace === e);
        });

        this.secciones.forEach((u) => {
          if (u.dataset.view == e.dataset.view) {
            //mostramos seccion correspondiente
            u.hidden = false;
          } else {
            u.hidden = true;
          }
        });
      });
    });
    //boton volver al menu principal
    document.querySelector("#detalle-volver").addEventListener("click", () => {
      this.secciones.forEach((s) => {
        s.hidden = s.dataset.view !== this.vistaAnterior;
      });
    });
  }

  crearBotones(tr, tabla, id) {
    // Celda con el botón Detalle
    const tdDetalle = document.createElement("td");
    const botonDetalle = document.createElement("button");
    botonDetalle.type = "button";
    botonDetalle.className = "btn btn-sm btn-outline-primary";
    botonDetalle.textContent = "Detalle";
    botonDetalle.addEventListener("click", () => this.verDetalle(tabla, id));
    tdDetalle.append(botonDetalle);
    tr.append(tdDetalle);

    // Celda con el botón Eliminar
    const tdEliminar = document.createElement("td");
    const botonEliminar = document.createElement("button");
    botonEliminar.type = "button";
    botonEliminar.className = "btn btn-sm btn-outline-danger";
    botonEliminar.textContent = "Eliminar";
    botonEliminar.addEventListener("click", () => this.eliminar(tabla, id));
    tdEliminar.append(botonEliminar);
    tr.append(tdEliminar);
  }

  verDetalle(tabla, id) {
    this.vistaAnterior = tabla;

    this.secciones.forEach((s) => {
      s.hidden = s.dataset.view !== "detalle";
    });

    document.querySelector("#detalle-contenido").textContent =
      "Detalle de " + tabla + " " + id;
  }

  eliminar(tabla, id) {
    console.log("Eliminar de", tabla, id);
  }
}
let admin = new AdministradorVistas();
admin.inicializar();
