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
          td6.textContent = r.activo ? "Activo" : "Desactivado";
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

          // const td7 = document.createElement("td");
          // td7.textContent = r.id;
          // tr.append(td7);
          // const td7 = document.createElement("td");
          // td7.textContent = r.id;
          // tr.append(td7);

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
          // const td5 = document.createElement("td");
          // td5.textContent = r.precio;
          // tr.append(td5);
          // const td7 = document.createElement("td");
          // td7.textContent = r.id;
          // tr.append(td7);

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
          // const td5 = document.createElement("td");
          // td5.textContent = r.precio;
          // tr.append(td5);
          // const td7 = document.createElement("td");
          // td7.textContent = r.id;
          // tr.append(td7);

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
          td6.textContent = r.activa;
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
          // const td4 = document.createElement("td");
          // td4.textContent = r.direccion;
          // tr.append(td4);
          // const td5 = document.createElement("td");
          // td5.textContent = r.precio;
          // tr.append(td5);
          // const td7 = document.createElement("td");
          // td7.textContent = r.id;
          // tr.append(td7);

          tablaProductos.append(tr);
        });
      });

      /*
    fetch("")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.usuarios = r;
      });
    fetch("")
      .then((respuesta) => respuesta.json())
      .then((r) => {
        this.pedidos = r;
      });
*/
    this.enlaces = document.querySelectorAll("a");
    this.secciones = document.querySelectorAll("section");

    this.enlaces.forEach((e) => {
      e.addEventListener("click", () => {
        //console.log(e.dataset.view);
        this.vista = e.dataset.view;
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
  }
}
let admin = new AdministradorVistas();
admin.inicializar();
