# Preguntas para entender Daw2mvc

Guía de estudio orientada a alumnos. El objetivo es comprender **el 100 % del proyecto actual** y pensar **ampliaciones futuras** sin memorizar código a ciegas.

**Cómo usarla**

1. Intenta responder mirando el código (no hace falta internet).
2. Prueba en el navegador las URLs y “qué pasaría si…”.
3. Las preguntas marcadas con ★ son especialmente recomendables en clase.
4. Las de la sección *Ampliaciones* se pueden usar como parte del projecto.

---

## A. Visión general y estructura del proyecto

1. ★ ¿Qué es el patrón MVC y qué carpeta del proyecto corresponde a cada letra (Model, View, Controller)?
model/ datos y acceso a BD
Views/ lo que se muestra
controllers/ recibe la peticion y cordina
2. ¿Para qué sirve `index.php` en este proyecto? ¿Es una vista, un modelo o algo distinto?
recibe que acciones tiene que realizar y abre el archivo correspondiente
3. ¿Qué papel tienen `config/parameters.php` y `config/dataBase.php`? ¿Pertenecen al MVC “puro” o son infraestructura?
database es la conexion con la base de datos
parameters sirve para la conexion al link que se especifica. 
El MVC depende de ellos para funcionar ya que el dao se conecta a la database y el usuario a los parameters
4. ¿Por qué hay un fichero `sql/init.sql` si el PHP ya “habla” con la base de datos?
Es para montar la base de datos de ejemplo que va a utilizar el programa
5. ★ Dibuja (en papel o mentalmente) el árbol de carpetas y explica en una frase cada una: `controllers/`, `models/`, `views/`, `config/`, `sql/`.
controllers logica de cada peticion
modelos entidades y daos
views vistas para el usuario
config parametros a la BBDD y conexion a la web
sql scripts para BBDD
6. ¿Qué diferencia hay entre una **entidad** (`Camiseta`, `Producto`) y un **DAO** (`CamisetaDAO`)?
CamisetaDAO es el que interpreta los datos de la BBDD
La entidad es quien tiene los getters y seters
7. ¿Por qué `Producto` es `abstract` y `Camiseta` no lo es?
Porque producto es cualquier cosa y camiseta se especifica, por ejemplo podria haber un selector para escoger crear un pantalon o cualquier cosa pero heredaria de producto y su clase seria pantalon
8. ¿Qué significan las constantes `TYPE_CAMISETA` y `TYPE_PANTALONES` si de momento solo usamos camisetas?
Esta preparado para la respuesta anterior

---

## B. Flujo de la aplicación (petición → respuesta)

9. ★ Explica paso a paso qué ocurre cuando abres `http://localhost:8000/` (sin parámetros).
No puede acceder porque el index.php ve que existe y hace redirect a al controlador
10. ★ Explica paso a paso qué ocurre con `?controller=producto&action=index`.

11. ¿Qué ocurre si entras a `?controller=producto` **sin** `action`? ¿Quién decide la action por defecto?
el index php define los parametros en accion
12. ¿Dónde se define `default_controller` y `default_action`? ¿Qué pasa si las cambias?
el controlador default es la variable producto para que salga el texto y la default action es index que abre la pagina principal
define("default_controller", "producto");
define("default_action", "index");

13. ★ Sigue el flujo completo de **crear un producto**: desde el enlace “Crear producto” hasta que vuelve a aparecer en el listado. Nombra ficheros y métodos.
la accion la actualiza cuando se hace click en la A e identifica la id del producto. Esto hace que se carge la pantalla show con la id que se ha seleccionado

14. Sigue el flujo de **ver un producto** (`show`) y el de **eliminar** (`destroy`). ¿En qué se parecen y en qué se diferencian?
El destroy elimina y no tiene una pantalla para mostrar que se ha eliminado, quizas a esta accion habria que poner un tostr de que se ha eliminado correctamente, el view en cambio cambia la pantalla que esta

15. ¿Qué hace `header('Location:...')` seguido de `exit`? ¿Qué pasaría si olvidas el `exit`?
si no se pone el exit sigue ejecutando la web en segundo plano
16. ¿Por qué `store` y `destroy` **no** incluyen una vista (`main.php`) y en cambio hacen redirect?
porque son acciones que modifican datos y no tienen nada que mostrar
17. ★ ¿Qué es el patrón Post-Redirect-Get (PRG) y dónde lo ves aplicado en este código?
es para evitar tener que hacer f5 al usuario
18. Si dos alumnos abren la misma URL a la vez, ¿comparten variables PHP `$productos`? ¿Por qué?
lo unico que se comparte es la BBDD el resto para cada usuario sera diferente y no se interfiere entre usuarios

---

## C. Front controller (`index.php`)

19. ★ ¿Qué es un *front controller* y por qué casi todo pasa por `index.php`?
es el unico punto de entrada y toda la web y errores pasan por ella
20. ¿Cómo se construye el nombre de la clase a partir de `$_GET['controller']`? Ejemplo con `producto`.
a partir del controlador hace la comunicacion con el modelo para hacer las acciones, es decir en el producto tiene las funciones para almacenar eliminar mostrar los productos comunicandose con la BBDD
21. ¿Cómo se decide qué fichero incluir en `controllers/`?
el controlador es quien hace la comunicacion intermedia entre las vistas y los modelos y dao, para que el usuario no pueda hacer cosas malignas, dependiendo las necesidades, quizas si un producto solo tiene un controlador y se sobre satura es mejor separar
22. ¿Qué hace `showError()`? ¿Por qué usa `http_response_code` y después `include` de `main.php`?
En el caso que haya un error crea unas variables para poder mostrarlas ademas de utilizar la pantalla de error.php
23. ★ ¿Qué diferencia hay entre un error 404 y un error 500 en este `index.php`? Pon un ejemplo de cada uno.
404 la pagina no existe,
500 lleva a la pagina nuestra
24. ¿Qué hace `class_exists` y por qué se comprueba **después** de hacer `include_once` del fichero?
solo se define cuando se carga el fichero que se esta incluyendo

25. ¿Qué hace `is_callable([$controller, $action])`? ¿Por qué no basta con `method_exists`?

26. ★ ¿Qué pasaría si alguien pide `?controller=producto&action=__construct`? ¿Está permitido? ¿Por qué?
No esta permitido porque la pagina no esta creada y es un metodo que no esta en el controlador si no que esta en el modelo
27. ¿Qué pasaría si el fichero `productoController.php` existiera pero la clase se llamara `ProductoCtrl`?
daria error 500 por error en el nombre
28. ¿Qué riesgo hay si no validas el nombre del `controller` antes de usarlo en una ruta de fichero? (piensa en `../`)
29. ¿Por qué `include_once` y no `include` o `require`? ¿Cuándo preferirías `require_once`?
include_once solamente te carga 1 vez el documento
include te carga todas las veces el documento si lo pones 10 veces lo carga 10 veces
requiere_once lanza error si falta el archivo

---

## D. Controlador (`productoController`)

30. ★ ¿Qué responsabilidades tiene el controlador? ¿Qué **no** debería hacer (SQL directo, HTML largo…)?
debe validar la entrada, llamar al modelo, llamar al dao, es decir es un interlocutor, y hacer logica para prevenir
31. Explica qué hace cada action: `index`, `create`, `store`, `show`, `destroy`.
index lista los productos
create muestra el formulario
store valida y guarda el post
show muestra un producto al detalle
destroy elimina un archivo
32. ¿Por qué `create` solo muestra el formulario y `store` es quien guarda?
para que cada accion tenga una responsabilidad, crear unicamente lo añade en bbdd y store unicamente guarda, entonces puedes guardar cualquier producto si tiene los mismos primitivos

33. ★ ¿Para qué sirve `TALLAS_VALIDAS`? ¿Qué pasa si envías una talla `XYZ` por POST?
es otra verificacion para que no puedas crear en BBDD una talla que no existe

34. ¿Por qué se usa `trim` en el nombre y `(float)` en el precio?
para evitar espacios, lo convierte en numero
35. ¿Qué comprueba `ctype_digit` en `show` y `destroy`? ¿Qué pasaría con `?id=3abc` o `?id=-1`?
comprueba si la id es una cadena numerica y el - es una letra así que tambien petaria con ello
36. ★ En `show`, si el `id` no existe en la BD, ¿qué hace el código? ¿Te parece buena UX? ¿Cómo lo mejorarías sin complicar mucho?

redirige directamente al menu, si no quieres que haga eso showError(404, "Producto no encontrado")

37. ¿Por qué `store` lee de `$_POST` y `destroy`/`show` de `$_GET`?
post es para un formulario que modifica algo
get es para algo que tenga que leer de la url
38. ★ ¿Qué problema de seguridad/usabilidad tiene eliminar con un enlace GET (`action=destroy`)? ¿Cómo lo harías con un formulario POST?
que modificando la url puedes eliminar otra id, esto desde el controlador podrias añadir una variable global que verifique que este en la misma id
39. Si mañana añades `edit` y `update`, ¿qué haría cada uno y qué vistas necesitarías?
necesitaria una vista para editar y luego añadir en el controlador los 2 metodos
---

## E. Modelo, herencia y propiedades

40. ★ ¿Por qué los nombres de las propiedades (`nombre`, `talla`, `precio`, `id`) deben coincidir con las columnas de la tabla?
porque si no, no se puede crear el objeto del modelo
41. ¿Qué es un getter y un setter? ¿Por qué no se accede a `$producto->nombre` desde la vista?
porque tiene que estar encapsulado, es decir esta en protected, tendria que estar en public pero es riesgo así que mejor hacer getters y setters
42. ★ Explica el constructor de `Producto`: ¿por qué los parámetros por defecto son `null` y solo asigna si no son `null`?
porque de base tiene que inicializar con algo, no puede inicializarce sin nada
43. ★ ¿Qué pasaría si el constructor hiciera siempre `$this->nombre = $nombre` con `$nombre = ''` por defecto, y luego usas `fetch_object("Camiseta")`?
que si el valor es blanco borraria objetos en la bbdd
44. ¿Qué hace `parent::__construct(...)` en `Camiseta`?
llama al constructor padre para crear camisetas
45. ¿`Camiseta` añade atributos propios ahora mismo? ¿Qué atributo nuevo pondrías (ej. `manga_corta`) y qué habría que tocar (clase, SQL, vistas, DAO)?
tendrias que añadirlo en la clase abstracta despues tendrias que añadirlo en la clase normal, el dao no tendrias que modificar nada pero si tendrias que modificar el sql
46. ¿Para qué sirve `setId` si el `id` lo genera la base de datos con `AUTO_INCREMENT`?
Sirve para asignar manualmente el id a algo

---

## F. DAO, mysqli y `fetch_object`

47. ★ ¿Qué significa DAO (Data Access Object)? ¿Qué ganas separándolo del controlador?
Es quien controla las base de datos, haces que las base de datos unicamente se utilicen en los DAOS
48. ¿Por qué los métodos del DAO son `static`? ¿Se podría hacer sin `static`? Ventajas/inconvenientes.
se llaman sin instanciar con static tendrias que crear una varibale
49. Explica línea a línea `getAll()`: `connect` → `prepare` → `execute` → `get_result` → bucle → `close`.
abre conexion
prepara la query
ejecuta la query
obtiene resultado de la query
mete con un fetch en el objeto correspondiente
cierra la conexion y devuelve el objeto
50. ★ ¿Qué hace exactamente `$result->fetch_object("Camiseta")`?
toma la siguiente hasta que de null
51. ★ ¿En qué orden ocurre: rellenar propiedades desde la fila SQL y llamar al constructor? ¿Por qué importa?
primero crea el objeto y rellena las propiedades, si alguna propiedad no existe se queda el null
52. ¿Qué diferencia hay entre `fetch_object("Camiseta")` y `fetch_assoc()`? ¿Cuándo usarías cada uno?
fetch object devuelve un objeto de clase indicada
fetch assoc devuelve un array sin identificacion
53. En `getById` y `destroy`, ¿para qué sirve `bind_param("i", $id)`? ¿Qué evita respecto a concatenar el id en el SQL?
es para evitar sql injection
54. En `store`, ¿qué significan los tipos `"ssd"` de `bind_param`?
s = string / d = double, y cada uno de los parametros nombre talla precio
55. ★ ¿Por qué en `store` se copian `$nombre`, `$talla`, `$precio` a variables locales antes de `bind_param`?
porque no puedes hacer directamente $producto ->getNombre() porque da error
56. ¿Qué devolvería `getById(99999)` si no hay fila? ¿Cómo lo representa el código (`?: null`)?devuelve null, y el ?: normaliza el null para el controlador

57. ¿Qué pasaría si en el SQL la columna se llamara `name` pero la propiedad de la clase fuera `$nombre`?
quedaria sin rellenar en null
58. ¿Por qué se cierra `$stmt` y `$con` al final de cada método? ¿Qué pasaría a largo plazo si no los cierras?
lo cierras porque si no tendrias muchisimas conexiones acumuladas
59. ★ Compara responsabilidad: ¿quién conoce SQL, quién conoce HTML, quién conoce reglas de validación de talla? el dao html validacion de talla el controlador

---

## G. Vistas y layout (header / footer)

60. ★ ¿Qué es `views/main.php` y qué hace `<?php include_once $view; ?>`?
añade el menu necesario al html y el header siempre es el mismo
61. ¿Quién define la variable `$view` antes de incluir `main.php`?
el controlador justo antes de añadir el main
62. ★ ¿Cómo pondrías un **header** y un **footer** comunes en toda la web sin repetir HTML en cada vista? Describe al menos dos formas (ej. bloques en `main.php`, o `header.php`/`footer.php`).
con include once al principio y final del html main
63. Si el menú de navegación debe salir en listado, create y show, ¿dónde lo colocarías y por qué?

64. ¿Qué ventaja tiene que `listado.php`, `create.php` y `show.php` **no** traigan `<html>` completo?
65. ★ ¿Qué hace `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` en las vistas? ¿Qué riesgo evitas?
66. ¿Qué mostraría el listado si `$productos` es un array vacío? ¿Dónde está ese mensaje?
67. ¿Cómo cambiarías el título de la pestaña (`<title>`) según la página (Listado / Crear / Detalle) sin complicar demasiado?
68. Si mueves el CSS de `main.php` a `public/css/estilo.css`, ¿qué enlaces habría que añadir y dónde?

---

## H. Base de datos y configuración

69. ¿Qué crea `sql/init.sql`? ¿Por qué usa `DROP TABLE IF EXISTS`? ¿Es peligroso en producción?
70. ¿Qué tipo de dato es `talla` en SQL (`ENUM`) y qué implicación tiene al insertar valores?
71. ★ Si cambias la contraseña de MySQL, ¿qué fichero tocas? ¿Deberías subir esa contraseña a Git? ¿Por qué?
72. ¿Para qué sirve `set_charset("utf8mb4")`?
73. Si la base se llama distinto a `daw2mvc`, ¿qué hay que cambiar?
74. ¿Qué diferencia hay entre conectar a `localhost` y a `127.0.0.1`? (nivel introductorio)

---

## I. “¿Qué pasaría si…?” (depuración y comprensión)

75. ★ ¿Qué pasaría si renombras la clase a `ProductoController` (P mayúscula) pero la URL sigue siendo `controller=producto`?
76. ¿Qué pasaría si en `listado.php` escribes `$producto->nombre` en lugar de `getNombre()`?
77. ★ ¿Qué pasaría si borras `include_once 'views/main.php'` en `index()` y solo dejas el path en `$view`?
78. ¿Qué pasaría si en el formulario de create el `action` del form apunta a `action=index` en vez de `store`?
79. ¿Qué pasaría si `DataBase::connect()` falla? ¿Dónde se ve el error?
80. ★ ¿Qué pasaría si alguien entra a `?controller=producto&action=store` con GET (sin formulario)?
81. ¿Qué pasaría si dos productos se llaman igual? ¿Lo impide el código actual?
82. ¿Qué pasaría si el precio llega como `"12,50"` (coma) en vez de `"12.50"`?
83. ★ Abre `?controller=noexiste`. ¿Qué ves? ¿Qué código HTTP debería devolver?
84. Abre `?controller=producto&action=foo`. ¿Qué ocurre y por qué?

---

## J. MVC en la práctica (diseño)

85. ★ Si metes un `echo "<h1>Hola</h1>"` dentro de `CamisetaDAO`, ¿rompiendo qué principio del MVC estás?
86. Si metes la consulta SQL dentro de `productoController::index`, ¿qué problema tendrás cuando haya otro controlador que también liste camisetas?
87. ★ ¿La validación de tallas debería vivir en el controlador, en el modelo o en ambos? Razona una respuesta sencilla para clase.
88. ¿Por qué este proyecto no usa un framework (Laravel, Symfony) y aun así es útil para aprender?

---

## K. Ampliaciones: otro apartado (administrador) y otras vistas

89. ★ Quieres un área **administrador** con otra “cara” (otro layout). ¿Crearías `views/admin/main.php` distinto de `views/main.php`? ¿Cómo decidiría el controlador qué layout usar?
90. ★ Diseña a alto nivel un `adminController` (o `usuarioController`): ¿qué actions tendrías (`login`, `logout`, `dashboard`)?
91. ¿Cómo protegerías las rutas de admin para que un visitante normal no pueda entrar? (sesión PHP, idea general)
92. Si el admin lista productos pero con botones extra (editar, estadísticas), ¿reutilizas `CamisetaDAO::getAll()` o creas otro DAO? ¿Por qué?
93. ★ Propón la estructura de carpetas para: tienda pública + panel admin, manteniendo un solo `index.php`.
94. ¿Cómo harías que `?controller=admin&action=index` use CSS distinto sin copiar todas las vistas?
95. Si añades la entidad `Pantalones`, ¿qué ficheros nuevos creas y cuáles reutilizas gracias a `Producto`?
96. ¿Cómo implementarías `edit` + `update` reutilizando casi el mismo formulario que `create`?
97. ★ Cómo añadirías un campo `stock` (entero) de punta a punta: SQL → modelo → DAO → formulario → listado.
98. Cómo añadirías búsqueda/filtro por talla en el listado (`?talla=M`). ¿En qué capa pondrías el `WHERE`?
99. Cómo paginarías el listado (10 por página). ¿Qué parámetros GET usarías?
100. ★ Cómo sacarías header y footer a `views/partials/header.php` y `footer.php` y los incluirías desde `main.php`. Escribe el esqueleto mental del `main.php` resultante.

---

## L. Ampliaciones: calidad, seguridad y “siguiente nivel”

101. ¿Qué es XSS y dónde estáis ya protegiendo (parcialmente) en las vistas?
102. ¿Qué es SQL Injection y cómo os ayudan los *prepared statements*?
103. ¿Qué es un token CSRF (idea) y en qué formularios lo pondrías primero?
104. ¿Cómo mostrarías un mensaje “Producto creado correctamente” tras el redirect? (idea de *flash* con `$_SESSION`)
105. ¿Qué mejorarías del `README.md` para que un compañero monte el proyecto en 5 minutos?
106. ★ Si el proyecto crece a 10 controladores, ¿qué problema tiene cargar includes a mano? ¿Qué es un autoload (idea)?
107. ¿Qué testras a mano antes de dar por buena una práctica? Lista un checklist de 5 pruebas en el navegador.