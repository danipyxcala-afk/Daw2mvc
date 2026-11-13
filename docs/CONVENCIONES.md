# Convención de nombres

> Reglas de nombres que sigue todo el proyecto Sigmeat. Volver al [README](../README.md).

Todo el proyecto sigue estas reglas. Están basadas en los estándares PSR-1 y PSR-4 de PHP y en BEM para el CSS.

| Qué | Regla | Ejemplo |
|---|---|---|
| Clases PHP | PascalCase | `UserController`, `UsuariosDAO`, `PedidoDetalle` |
| Archivo de una clase | el mismo nombre exacto que la clase | `UserController.php`, `PedidoDetalle.php` |
| `include`, `fetch_object`, `extends` | el nombre exacto, con sus mayúsculas | `fetch_object("Usuarios")`, `extends Productos` |
| Métodos | camelCase | `getFechaNacimiento()`, `getPedidosByUsuario()` |
| Propiedades de los modelos | igual que la columna de la BBDD (snake_case) | `$fecha_nacimiento` |
| Carpetas de vistas | minúsculas | `views/inicio`, `views/usuario`, `views/productos` |
| Clases CSS | BEM en minúsculas con guiones, en español | `card-producto__img`, `boton--primario`, `entrada-home` |
| URL | en minúsculas; el router pone la mayúscula con `ucfirst` | `?controller=user` → `UserController` |

**Por qué las propiedades siguen en snake_case:** `fetch_object` rellena el objeto usando los nombres de las columnas.
Si la propiedad se llamara `$fechaNacimiento`, PHP crearía otra distinta llamada `$fecha_nacimiento` y el getter devolvería `null`.
Por eso solo los métodos van en camelCase: `getFechaNacimiento()` devuelve `$this->fecha_nacimiento`.

**Mayúsculas en Windows:** Windows no distingue `usuarios.php` de `Usuarios.php`, pero el hosting Linux sí.
Para cambiar solo las mayúsculas de un archivo hay que hacerlo en dos pasos, para que git lo registre:
`git mv usuarios.php tmp.php` y después `git mv tmp.php Usuarios.php`.
