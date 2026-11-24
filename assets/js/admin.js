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
    this.cargarCategorias();
    this.cargarIngredientes();
    this.cargarOfertas();
    this.cargarPedidos();
    this.cargarProductos();
    this.cargarUsuarios();

    //con esto unicamente pilla los del menu admin
    this.enlaces = document.querySelectorAll("#menu-admin a[data-view]");
    this.secciones = document.querySelectorAll("section[data-view]");

    this.enlaces.forEach((e) => {
      e.addEventListener("click", () => {
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
  cargarPedidos() {
    fetch("index.php?controller=api&action=pedidos")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.pedidos = r;
        const tablaProductos = document
          .getElementById("pedidos")
          .querySelector("tbody");
        const estados = [
          "pendiente",
          "confirmado",
          "preparando",
          "enviado",
          "entregado",
          "cancelado",
        ];
        this.pedidos.forEach((r) => {
          const tr = document.createElement("tr");
          const td6 = document.createElement("td");
          const select = this.crearSelect(estados, r.estado);
          select.classList.add("form-select-sm");
          select.addEventListener("change", () => {
            fetch(`index.php?controller=api&action=pedidos&id=${r.id}`, {
              method: "PUT",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({
                estado: select.value,
                estado_pago: r.estado_pago,
              }),
            }).then((respuesta) => respuesta.json());
          });
          td6.append(select);
          tr.append(td6);
          this.crearCelda(tr, r.id);
          this.crearCelda(tr, r.usuario_id);
          this.crearCelda(tr, r.fecha_pedido);
          this.crearCelda(tr, r.total);
          this.crearBotonDetalle(tr, "pedidos", r.id);

          tablaProductos.append(tr);
        });
      });
  }
  cargarUsuarios() {
    fetch("index.php?controller=api&action=usuarios")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.usuarios = r;
        const tablaProductos = document
          .getElementById("usuarios")
          .querySelector("tbody");
        this.usuarios.forEach((r) => {
          const tr = document.createElement("tr");
          this.crearCelda(tr, r.id);
          this.crearCelda(tr, r.nombre);
          this.crearCelda(tr, r.email);
          this.crearCelda(tr, r.telefono);
          this.crearCelda(tr, r.direccion);
          this.crearBotonDetalle(tr, "usuarios", r.id);

          tablaProductos.append(tr);
        });
      });
  }
  cargarCategorias() {
    fetch("index.php?controller=api&action=categorias")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.categorias = r;
        const tablaProductos = document
          .getElementById("categorias")
          .querySelector("tbody");
        this.categorias.forEach((r) => {
          const tr = document.createElement("tr");
          this.crearCelda(tr, r.activa ? "Activa" : "Inactiva");
          this.crearCelda(tr, r.id);
          this.crearCelda(tr, r.nombre);
          this.crearCelda(tr, r.descripcion);
          this.crearBotonDetalle(tr, "categorias", r.id);

          tablaProductos.append(tr);
        });
      });
  }
  cargarProductos() {
    fetch("index.php?controller=api&action=productos")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.productos = r;
        const tablaProductos = document
          .getElementById("productos")
          .querySelector("tbody");
        this.productos.forEach((r) => {
          const tr = document.createElement("tr");
          this.crearCelda(tr, r.activo ? "Activo" : "Inactivo");
          this.crearCelda(tr, r.id);
          this.crearCelda(tr, r.categoria_id);
          this.crearCelda(tr, r.nombre);
          this.crearCelda(tr, r.descripcion);
          this.crearCelda(tr, r.precio);
          this.crearBotonDetalle(tr, "productos", r.id);

          tablaProductos.append(tr);
        });
      });
  }
  cargarIngredientes() {
    fetch("index.php?controller=api&action=ingredientes")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.ingredientes = r;
        const tablaProductos = document
          .getElementById("ingredientes")
          .querySelector("tbody");
        this.ingredientes.forEach((r) => {
          const tr = document.createElement("tr");
          this.crearCelda(tr, r.activo ? "Activo" : "Inactiva");
          this.crearCelda(tr, r.id);
          this.crearCelda(tr, r.nombre);
          this.crearCelda(tr, r.precio_extra);
          this.crearBotonDetalle(tr, "ingredientes", r.id);

          tablaProductos.append(tr);
        });
      });
  }
  cargarOfertas() {
    fetch("index.php?controller=api&action=ofertas")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.ofertas = r;
        const tablaProductos = document
          .getElementById("ofertas")
          .querySelector("tbody");
        this.ofertas.forEach((r) => {
          const tr = document.createElement("tr");
          this.crearCelda(tr, r.id);
          this.crearCelda(tr, r.nombre);
          this.crearCelda(tr, r.descripcion);
          this.crearCelda(tr, r.tipo);
          this.crearCelda(tr, r.valor);
          this.crearCelda(tr, r.codigo);
          this.crearBotonDetalle(tr, "ofertas", r.id);

          tablaProductos.append(tr);
        });
      });
  }
  crearBotonDetalle(tr, tabla, id) {
    // Celda con el botón Detalle
    const tdDetalle = document.createElement("td");
    const botonDetalle = document.createElement("button");
    botonDetalle.type = "button";
    botonDetalle.className = "btn btn-sm btn-outline-primary";
    botonDetalle.textContent = "Detalle";
    botonDetalle.addEventListener("click", () => this.verDetalle(tabla, id));
    tdDetalle.append(botonDetalle);
    tr.append(tdDetalle);
  }
  crearBotonEliminar(tr, tabla, id) {
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
    //dejar los datos vacios del detalle
    const contenido = document.querySelector("#detalle-contenido");
    contenido.replaceChildren();

    document.querySelector("#detalle-titulo").textContent =
      `Editar ${tabla} #${id}`;

    this.secciones.forEach((s) => {
      s.hidden = s.dataset.view !== "detalle";
    });
    fetch(`index.php?controller=api&action=${tabla}&id=${id}`)
      .then((respuesta) => {
        if (!respuesta.ok) {
          throw new Error("Error " + respuesta.status);
        }
        return respuesta.json();
      })
      .then((r) => {
        if (r === null) {
          contenido.textContent = "No se ha encontrado.";
          return;
        }
        const form = document.createElement("form");
        form.className = "row";

        Object.entries(r).forEach(([campo, valor]) => {
          //crear elementos para añadir los botones
          const grupo = document.createElement("div");
          const label = document.createElement("label");
          let input = document.createElement("input");
          //crear clases para añadir
          grupo.className = "col-md-6 mb-3";
          label.className = "form-label fw-bold";
          input.className = "form-control";

          label.textContent = campo;

          input.name = campo;
          input.value = valor ?? "";
          //la tabla pedidos y los campos ID no se pueden editar y se quedan con readonly
          if (campo === "id" || tabla === "pedidos") {
            input.readOnly = true;
            input.classList.add("bg-body-secondary");
          }
          const roles = ["admin", "usuario"];

          if (campo === "rol") {
            input = this.crearSelect(roles, valor);
            input.name = campo;
          }
          grupo.append(label, input);
          form.append(grupo);
        });
        //si la tabla es pedidos no aparece el boton de actualizar
        if (tabla !== "pedidos") {
          const boton = document.createElement("button");
          boton.type = "submit";
          boton.className = "btn btn-primary";
          boton.textContent = "Guardar";
          form.append(boton);

          form.addEventListener("submit", (e) => {
            e.preventDefault();
            const datos = Object.fromEntries(new FormData(form));
            fetch(`index.php?controller=api&action=${tabla}&id=${id}`, {
              method: "PUT",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify(datos),
            })
              .then((respuesta) => respuesta.json())
              .then((resultado) => {
                // Si se ha guardado, recargamos para ver los datos nuevos;
                // si no, avisamos y nos quedamos en el formulario para corregir
                if (resultado.ok) {
                  location.reload();
                } else {
                  alert(resultado.error);
                }
              });
          });
        }
        contenido.replaceChildren(form);
      });
  }
  crearCelda(tr, texto) {
    const td = document.createElement("td");
    td.textContent = texto;
    tr.append(td);
  }

  crearSelect(opciones, valor) {
    const select = document.createElement("select");
    select.className = "form-select";
    opciones.forEach((opcion) => {
      const option = document.createElement("option");
      option.value = opcion;
      option.textContent = opcion;
      select.append(option);
    });
    //se marca después del bucle, cuando las opciones ya existen
    select.value = valor ?? "";
    return select;
  }

  eliminar(tabla, id) {
    console.log("Eliminar de", tabla, id);
  }
}
let admin = new AdministradorVistas();
admin.inicializar();
