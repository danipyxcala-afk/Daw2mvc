//controla el panel: pide los datos, pinta las tablas y cambia de vista
class AdministradorVistas {
  //al crear el panel se prepara la sesion
  constructor() {
    this.sesion = new Sesion();
  }

  //arranque: carga las tablas, prepara los eventos y abre la ultima vista (una sola vez)
  inicializar() {
    this.cargarCategorias();
    this.cargarIngredientes();
    this.cargarOfertas();
    this.cargarPedidos();
    this.cargarProductos();
    this.cargarUsuarios();
    this.cargarSesion();

    //querySelectorAll devuelve todos los elementos que cumplen el selector (aqui, solo los del menu admin)
    this.enlaces = document.querySelectorAll("#menu-admin a[data-view]");
    this.secciones = document.querySelectorAll("section[data-view]");

    //forEach recorre la lista; (e) => {...} es una funcion flecha y e es cada enlace
    this.enlaces.forEach((e) => {
      e.addEventListener("click", () => {
        //dataset.view lee el atributo data-view del html
        localStorage.setItem("vistaAdmin", e.dataset.view);
        this.mostrarVista(e.dataset.view);
      });
    });
    //boton volver al menu principal
    document.querySelector("#detalle-volver").addEventListener("click", () => {
      this.mostrarVista(this.vistaAnterior);
    });
    //al cerrar sesion borramos los datos del navegador; action*= busca los form cuyo action contiene ese texto
    document.querySelectorAll('form[action*="action=logout"]').forEach((f) => {
      f.addEventListener("submit", () => this.sesion.borrar());
    });
    //abrimos la ultima vista guardada, o el menu si no hay ninguna; ?? usa lo de la derecha si lo de la izquierda es null
    this.mostrarVista(localStorage.getItem("vistaAdmin") ?? "menu");
    //cada input filtra la tabla que indica su data-filtro
    document.querySelectorAll("[data-filtro]").forEach((input) => {
      input.addEventListener("input", () =>
        this.filtrarTabla(input.dataset.filtro),
      );
    });

    //al pulsar el titulo de una columna se ordena la tabla por ella; th[data-ordenar] son los titulos que tienen data-ordenar en el html
    document.querySelectorAll("th[data-ordenar]").forEach((th) => {
      th.addEventListener("click", () => {
        //la primera vez no hay data-sentido y sale "asc"; despues va alternando entre "asc" y "desc"
        const sentido = th.dataset.sentido === "asc" ? "desc" : "asc";

        //closest("tr") sube a la fila de titulos y se quita el sentido a todos: solo ordena la ultima columna pulsada
        th.closest("tr")
          .querySelectorAll("th")
          .forEach((otro) => {
            //delete borra el atributo data-sentido de ese th
            delete otro.dataset.sentido;
          });

        //guardamos el sentido nuevo en el titulo pulsado: data-sentido="asc"
        th.dataset.sentido = sentido;
        //ordenarTabla lee ese sentido y la columna del th, y mueve las filas
        this.ordenarTabla(th);
      });
    });
  }
  //enseña la vista elegida y pone en negrita su enlace del menu
  mostrarVista(vista) {
    //negrita en el enlace de la vista actual
    this.enlaces.forEach((enlace) => {
      //toggle pone la clase si la condicion es true y la quita si es false
      enlace.classList.toggle("fw-bold", enlace.dataset.view === vista);
    });
    //solo se ve la seccion de esa vista
    this.secciones.forEach((s) => {
      //!== da true o false: se esconden todas menos la elegida
      s.hidden = s.dataset.view !== vista;
    });
  }
  //pide los datos del admin, los guarda en el navegador y saluda con su nombre
  cargarSesion() {
    //fetch pide los datos; los then se ejecutan cuando llega la respuesta
    fetch("index.php?controller=api&action=sesion")
      .then((respuesta) => {
        //ok es false si la API responde con un error (por ejemplo 403)
        if (!respuesta.ok) {
          this.sesion.borrar();
          throw new Error("Sin sesión de administrador");
        }
        //json() convierte la respuesta en un objeto, como json_decode en PHP
        return respuesta.json();
      })
      .then((datos) => {
        this.sesion.guardar(datos);
        document.querySelector("#admin-nombre").textContent =
          this.sesion.leer().nombre;
      });
  }
  //pide los datos de una tabla y la pinta; crearFila convierte cada dato en un tr
  cargarTabla(tabla, crearFila) {
    //con las comillas ` se puede meter una variable dentro del texto: ${variable}
    fetch(`index.php?controller=api&action=${tabla}`)
      .then((respuesta) => respuesta.json())
      .then((r) =>
        this.pintarTabla(
          tabla,
          //map devuelve un array nuevo: de cada dato saca su fila
          r.map((datos) => crearFila(datos)),
        ),
      );
  }

  //pinta los pedidos; el estado es un select que se guarda al cambiarlo
  cargarPedidos() {
    const estados = [
      "pendiente",
      "confirmado",
      "preparando",
      "enviado",
      "entregado",
      "cancelado",
    ];
    //p es cada pedido; esta funcion crea su fila
    this.cargarTabla("pedidos", (p) => {
      const fila = this.crearFila("pedidos", p.id, [
        p.id,
        p.usuario_id,
        p.fecha_pedido,
        p.total,
      ]);
      //el estado es un select, en la primera celda
      const tdEstado = document.createElement("td");
      const select = this.crearSelect(estados, p.estado);
      select.classList.add("form-select-sm");
      //change salta cuando se elige otra opcion del select
      select.addEventListener("change", () => {
        enviarPut("pedidos", p.id, {
          estado: select.value,
          estado_pago: p.estado_pago,
        });
      });
      tdEstado.append(select);
      //prepend lo añade el primero (append lo añade el ultimo)
      fila.prepend(tdEstado);
      return fila;
    });
  }

  //pinta los usuarios
  cargarUsuarios() {
    //u es cada usuario; sin llaves, la flecha devuelve sola el resultado
    this.cargarTabla("usuarios", (u) =>
      this.crearFila("usuarios", u.id, [
        u.id,
        u.nombre,
        u.email,
        u.telefono,
        u.direccion,
      ]),
    );
  }

  //pinta las categorias, con su boton de activar o desactivar
  cargarCategorias() {
    //crea un objeto Categoria con los datos y le pide su fila
    this.cargarTabla("categorias", (datos) =>
      new Categoria(datos).crearFila(this),
    );
  }

  //pinta los productos, con su boton de activar o desactivar
  cargarProductos() {
    //crea un objeto Producto con los datos y le pide su fila
    this.cargarTabla("productos", (datos) =>
      new Producto(datos).crearFila(this),
    );
  }

  //pinta los ingredientes
  cargarIngredientes() {
    this.cargarTabla("ingredientes", (i) =>
      this.crearFila("ingredientes", i.id, [
        //condicion ? si se cumple : si no se cumple (un if corto)
        i.activo ? "Activado" : "Desactivado",
        i.id,
        i.nombre,
        i.precio_extra,
      ]),
    );
  }

  //pinta las ofertas
  cargarOfertas() {
    this.cargarTabla("ofertas", (o) =>
      this.crearFila("ofertas", o.id, [
        o.id,
        o.nombre,
        o.descripcion,
        o.tipo,
        o.valor,
        o.codigo,
      ]),
    );
  }

  //crea una fila con una celda por cada valor y el boton de detalle
  crearFila(tabla, id, valores) {
    const tr = document.createElement("tr");
    valores.forEach((valor) => crearCelda(tr, valor));
    this.crearBotonDetalle(tr, tabla, id);
    return tr;
  }

  //cambia las filas de una tabla por las nuevas, sin duplicarlas
  pintarTabla(tabla, filas) {
    const tbody = document.querySelector(`#${tabla} tbody`);
    //...filas saca los elementos del array: replaceChildren(fila1, fila2...)
    tbody.replaceChildren(...filas);
    this.filtrarTabla(tabla);
    //si se habia ordenado por una columna (su th tiene data-sentido), se vuelve a ordenar
    const th = document.querySelector(`#${tabla} th[data-sentido]`);
    if (th) this.ordenarTabla(th);
  }

  //esconde las filas de una tabla que no contienen el texto buscado
  filtrarTabla(tabla) {
    //busca el input que tiene el data-filtro de esa tabla
    const input = document.querySelector(`[data-filtro="${tabla}"]`);
    if (!input) return; //esa tabla no tiene filtro
    //trim quita los espacios de los lados y toLowerCase lo pasa a minusculas
    const texto = input.value.trim().toLowerCase();

    document.querySelectorAll(`#${tabla} tbody tr`).forEach((fila) => {
      //[...fila.cells] pasa las celdas a un array; filter quita las que tienen boton
      const celdas = [...fila.cells].filter(
        (td) => !td.querySelector("button"),
      );
      //some da true si al menos una celda cumple la condicion
      const coincide = celdas.some((td) => {
        //includes mira si un texto contiene otro, como str_contains en PHP
        return leerCelda(td).toLowerCase().includes(texto);
      });
      //! da la vuelta al valor: si no coincide, se esconde
      fila.hidden = !coincide;
    });
  }

  //ordena las filas de la tabla por la columna de ese th
  ordenarTabla(th) {
    //closest sube hasta la tabla del th; de ahi bajamos a su tbody
    const tbody = th.closest("table").querySelector("tbody");
    //cellIndex es el numero de columna: 0, 1, 2...
    const columna = th.cellIndex;

    //[...tbody.rows] pasa las filas a un array para poder usar sort; sort compara las filas de dos en dos: a y b
    const filas = [...tbody.rows].sort((a, b) => {
      //localeCompare compara dos textos (como strcmp): negativo si a va antes; numeric hace que 9 vaya antes que 10
      const resultado = leerCelda(a.cells[columna]).localeCompare(
        leerCelda(b.cells[columna]),
        "es",
        { numeric: true },
      );
      //asc deja el resultado; desc le cambia el signo
      return th.dataset.sentido === "asc" ? resultado : -resultado;
    });
    //append mueve las filas que ya estaban, en el orden nuevo
    tbody.append(...filas);
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
  //abre un registro en un formulario; solo se puede guardar en las tablas editables
  verDetalle(tabla, id) {
    //tablas que se pueden guardar (las que tienen PUT en la API); se añaden al hacer su PUT
    const editables = ["productos", "categorias"];
    //includes mira si la tabla esta en la lista, como in_array en PHP
    const editable = editables.includes(tabla);
    this.vistaAnterior = tabla;
    //dejar los datos vacios del detalle
    const contenido = document.querySelector("#detalle-contenido");
    //sin nada dentro, replaceChildren vacia el elemento
    contenido.replaceChildren();

    //el titulo dice Editar o Ver segun se pueda guardar o no
    document.querySelector("#detalle-titulo").textContent =
      `${editable ? "Editar" : "Ver"} ${tabla} #${id}`;

    this.secciones.forEach((s) => {
      s.hidden = s.dataset.view !== "detalle";
    });
    fetch(`index.php?controller=api&action=${tabla}&id=${id}`)
      .then((respuesta) => {
        if (!respuesta.ok) {
          //throw para aqui y no se ejecuta el siguiente then
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

        //como foreach ($r as $campo => $valor) en PHP
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
          //el id y los campos de las tablas que no se pueden guardar se quedan con readonly
          if (campo === "id" || !editable) {
            input.readOnly = true;
            input.classList.add("bg-body-secondary");
          }
          const roles = ["admin", "usuario"];

          if (campo === "rol") {
            input = this.crearSelect(roles, valor);
            input.name = campo;
            //los select no tienen readOnly: se bloquean con disabled si la tabla no es editable
            input.disabled = !editable;
          }
          //en categorias y ofertas el campo se llama activa
          if (campo === "activo" || campo === "activa") {
            input = this.crearSelect([1, 0], valor, [
              "Activado",
              "Desactivado",
            ]);
            input.name = campo;
            input.disabled = !editable;
          }
          grupo.append(label, input);
          form.append(grupo);
        });
        //el boton Guardar solo aparece en las tablas que se pueden guardar
        if (editable) {
          const boton = document.createElement("button");
          boton.type = "submit";
          boton.className = "btn btn-primary";
          boton.textContent = "Guardar";
          form.append(boton);

          form.addEventListener("submit", (e) => {
            //evita que el formulario recargue la pagina
            e.preventDefault();
            //FormData recoge los campos por su name y fromEntries los pasa a un objeto
            const datos = Object.fromEntries(new FormData(form));
            //si se ha guardado, recargamos la tabla y volvemos a ella; si no, nos quedamos para corregir
            enviarPut(tabla, id, datos).then((ok) => {
              if (ok) {
                this.recargarTabla(tabla);
                //click() pulsa el boton Volver desde el codigo
                document.querySelector("#detalle-volver").click();
              }
            });
          });
        }
        contenido.replaceChildren(form);
      });
  }

  //crea un select; textos es opcional: lo que se ve en cada opción, si es distinto de su valor
  crearSelect(opciones, valor, textos = opciones) {
    const select = document.createElement("select");
    select.className = "form-select";
    //opcion es el valor y i su posicion (0, 1, 2...)
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
  //crea el boton Detalle y lo añade a la fila
  crearBotonDetalle(tr, tabla, id) {
    const tdDetalle = document.createElement("td");
    const botonDetalle = document.createElement("button");
    botonDetalle.type = "button";
    botonDetalle.className = "btn btn-sm btn-outline-primary";
    botonDetalle.textContent = "Detalle";
    //con () => se espera al clic; sin ello se ejecutaria al momento
    botonDetalle.addEventListener("click", () => this.verDetalle(tabla, id));
    tdDetalle.append(botonDetalle);
    tr.append(tdDetalle);
  }
}

//crea un td con ese texto y lo añade a la fila
function crearCelda(tr, texto) {
  const td = document.createElement("td");
  //textContent lo mete como texto, no como html (como htmlspecialchars)
  td.textContent = texto;
  tr.append(td);
}

//devuelve el valor de una celda: lo elegido si tiene select, o su texto
function leerCelda(td) {
  const select = td.querySelector("select");
  //si hay select se usa lo elegido; si no, el texto de la celda
  return select ? select.value : td.textContent;
}

//envia los cambios de un registro a la API; devuelve true si se ha guardado
function enviarPut(tabla, id, datos) {
  //devuelve una promesa: el resultado llega mas tarde y se recoge con then
  return fetch(`index.php?controller=api&action=${tabla}&id=${id}`, {
    method: "PUT",
    //avisa de que los datos van en JSON
    headers: { "Content-Type": "application/json" },
    //stringify pasa el objeto a texto JSON, como json_encode en PHP
    body: JSON.stringify(datos),
  })
    .then((respuesta) => respuesta.json())
    .then((resultado) => {
      //la API manda ok si se ha guardado y error si no
      if (!resultado.ok) alert(resultado.error);
      return resultado.ok;
    })
    //catch salta si falla la conexion o la respuesta no es JSON
    .catch(() => alert("No se ha podido conectar con el servidor"));
}

//un producto: crea su fila y se activa o desactiva
class Producto {
  //recibe los datos de la API
  constructor(datos) {
    //copia id, nombre, precio... en el objeto
    Object.assign(this, datos);
  }

  //devuelve la fila del producto; admin es el panel, para usar su boton de detalle
  crearFila(admin) {
    const tr = document.createElement("tr");
    crearCelda(tr, this.activo ? "Activado" : "Desactivado");
    crearCelda(tr, this.id);
    crearCelda(tr, this.categoria_id);
    crearCelda(tr, this.nombre);
    crearCelda(tr, this.descripcion);
    crearCelda(tr, this.precio);
    admin.crearBotonDetalle(tr, "productos", this.id);
    this.crearBotonActivo(tr, admin);
    return tr;
  }

  //crea el boton de activar o desactivar, segun como este el producto
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

  //envia a la API el producto con el estado contrario y recarga la tabla
  cambiarActivo(admin) {
    //copia del producto, con activo al revés; ...this copia todas las propiedades y activo pisa solo esa
    const datos = { ...this, activo: this.activo ? 0 : 1 };

    //ok es lo que devuelve enviarPut cuando termina
    enviarPut("productos", this.id, datos).then((ok) => {
      if (ok) admin.cargarProductos();
    });
  }
}

//una categoria: crea su fila y se activa o desactiva
class Categoria {
  //recibe los datos de la API
  constructor(datos) {
    //copia id, nombre, descripcion... en el objeto
    Object.assign(this, datos);
  }

  //devuelve la fila de la categoria; admin es el panel, para usar su boton de detalle
  crearFila(admin) {
    const tr = document.createElement("tr");
    crearCelda(tr, this.activa ? "Activado" : "Desactivado");
    crearCelda(tr, this.id);
    crearCelda(tr, this.nombre);
    crearCelda(tr, this.descripcion);
    admin.crearBotonDetalle(tr, "categorias", this.id);
    this.crearBotonActivo(tr, admin);
    return tr;
  }

  //crea el boton de activar o desactivar, segun como este la categoria
  crearBotonActivo(tr, admin) {
    const td = document.createElement("td");
    const boton = document.createElement("button");
    boton.type = "button";
    boton.className = this.activa
      ? "btn btn-sm btn-outline-danger"
      : "btn btn-sm btn-outline-success";
    boton.textContent = this.activa ? "Desactivar" : "Activar";
    boton.addEventListener("click", () => this.cambiarActivo(admin));
    td.append(boton);
    tr.append(td);
  }

  //envia a la API la categoria con el estado contrario y recarga la tabla
  cambiarActivo(admin) {
    //copia de la categoría, con activa al revés; ...this copia todas las propiedades y activa pisa solo esa
    const datos = { ...this, activa: this.activa ? 0 : 1 };

    enviarPut("categorias", this.id, datos).then((ok) => {
      if (ok) admin.cargarCategorias();
    });
  }
}

//datos del admin guardados en el navegador (no dan permisos, eso lo mira PHP)
class Sesion {
  //guarda los datos del admin
  guardar(datos) {
    //sessionStorage solo guarda texto, por eso se pasa a JSON
    sessionStorage.setItem("sesionAdmin", JSON.stringify(datos));
  }

  //devuelve los datos guardados
  leer() {
    //parse hace lo contrario: del texto saca el objeto
    return JSON.parse(sessionStorage.getItem("sesionAdmin"));
  }

  //borra los datos al cerrar sesion
  borrar() {
    sessionStorage.removeItem("sesionAdmin");
  }
}

//crea el panel y lo arranca
const admin = new AdministradorVistas();
admin.inicializar();
