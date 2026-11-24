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
        //vaciamos la tabla para no duplicar filas al recargarla
        tablaProductos.replaceChildren();
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
          crearCelda(tr, r.id);
          crearCelda(tr, r.usuario_id);
          crearCelda(tr, r.fecha_pedido);
          crearCelda(tr, r.total);
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
        //vaciamos la tabla para no duplicar filas al recargarla
        tablaProductos.replaceChildren();
        this.usuarios.forEach((r) => {
          const tr = document.createElement("tr");
          crearCelda(tr, r.id);
          crearCelda(tr, r.nombre);
          crearCelda(tr, r.email);
          crearCelda(tr, r.telefono);
          crearCelda(tr, r.direccion);
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
        //vaciamos la tabla para no duplicar filas al recargarla
        tablaProductos.replaceChildren();
        this.categorias.forEach((r) => {
          const tr = document.createElement("tr");
          crearCelda(tr, r.activa ? "Activa" : "Inactiva");
          crearCelda(tr, r.id);
          crearCelda(tr, r.nombre);
          crearCelda(tr, r.descripcion);
          this.crearBotonDetalle(tr, "categorias", r.id);
          tablaProductos.append(tr);
        });
      });
  }
  cargarProductos() {
    fetch("index.php?controller=api&action=productos")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        const tablaProductos = document
          .getElementById("productos")
          .querySelector("tbody");
        //vaciamos la tabla para no duplicar filas al recargarla
        tablaProductos.replaceChildren();
        this.productos = r.map((datos) => new Producto(datos));
        this.productos.forEach((p) => tablaProductos.append(p.crearFila(this)));
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
        //vaciamos la tabla para no duplicar filas al recargarla
        tablaProductos.replaceChildren();
        this.ingredientes.forEach((r) => {
          const tr = document.createElement("tr");
          crearCelda(tr, r.activo ? "Activo" : "Inactiva");
          crearCelda(tr, r.id);
          crearCelda(tr, r.nombre);
          crearCelda(tr, r.precio_extra);
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
        //vaciamos la tabla para no duplicar filas al recargarla
        tablaProductos.replaceChildren();
        this.ofertas.forEach((r) => {
          const tr = document.createElement("tr");
          crearCelda(tr, r.id);
          crearCelda(tr, r.nombre);
          crearCelda(tr, r.descripcion);
          crearCelda(tr, r.tipo);
          crearCelda(tr, r.valor);
          crearCelda(tr, r.codigo);
          this.crearBotonDetalle(tr, "ofertas", r.id);

          tablaProductos.append(tr);
        });
      });
  }

  //vuelve a pedir y pintar solo una tabla, sin recargar la página
  recargarTabla(tabla) {
    switch (tabla) {
      case "productos":
        this.cargarProductos();
        break;
      case "categorias":
        this.cargarCategorias();
        break;
      case "ingredientes":
        this.cargarIngredientes();
        break;
      case "ofertas":
        this.cargarOfertas();
        break;
      case "usuarios":
        this.cargarUsuarios();
        break;
    }
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
          //en categorias y ofertas el campo se llama activa
          if (campo === "activo" || campo === "activa") {
            input = this.crearSelect([1, 0], valor, ["Activo", "Desactivado"]);
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
                // Si se ha guardado, recargamos solo la tabla y volvemos a ella;
                // si no, avisamos y nos quedamos en el formulario para corregir
                if (resultado.ok) {
                  this.recargarTabla(tabla);
                  document.querySelector("#detalle-volver").click();
                } else {
                  alert(resultado.error);
                }
              });
          });
        }
        contenido.replaceChildren(form);
      });
  }

  //textos es opcional: lo que se ve en cada opción, si es distinto de su valor
  crearSelect(opciones, valor, textos = opciones) {
    const select = document.createElement("select");
    select.className = "form-select";
    opciones.forEach((opcion, i) => {
      const option = document.createElement("option");
      option.value = opcion;
      option.textContent = textos[i];
      select.append(option);
    });
    //se marca después del bucle, cuando las opciones ya existen
    select.value = valor ?? "";
    return select;
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

  eliminar(tabla, id) {
    console.log("Eliminar de", tabla, id);
  }
}
let admin = new AdministradorVistas();
admin.inicializar();

function crearCelda(tr, texto) {
  const td = document.createElement("td");
  td.textContent = texto;
  tr.append(td);
}

class Producto {
  constructor(datos) {
    // copia id, nombre, precio... en el objeto
    Object.assign(this, datos);
  }

  crearFila(admin) {
    const tr = document.createElement("tr");
    crearCelda(tr, this.activo ? "Activo" : "Inactivo");
    crearCelda(tr, this.id);
    crearCelda(tr, this.categoria_id);
    crearCelda(tr, this.nombre);
    crearCelda(tr, this.descripcion);
    crearCelda(tr, this.precio);
    admin.crearBotonDetalle(tr, "productos", this.id);
    this.crearBotonActivo(tr, admin);
    return tr;
  }

  crearBotonActivo(tr, admin) {
    const td = document.createElement("td");
    const boton = document.createElement("button");
    boton.type = "button";
    boton.className = this.activo
      ? "btn btn-sm btn-outline-danger"
      : "btn btn-sm btn-outline-success";
    boton.textContent = this.activo ? "Desactivar" : "Activar";
    boton.addEventListener("click", () => this.cambiarActivo(admin));
    td.append(boton);
    tr.append(td);
  }

  cambiarActivo(admin) {
    // copia del producto, con activo al revés
    const datos = { ...this, activo: this.activo ? 0 : 1 };

    fetch(`index.php?controller=api&action=productos&id=${this.id}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(datos),
    })
      .then((respuesta) => respuesta.json())
      .then((resultado) => {
        if (resultado.ok) {
          admin.cargarProductos();
        } else {
          alert(resultado.error);
        }
      });
  }
}
