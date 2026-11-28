<?php
//DAOs que usa la API, __DIR__ es la carpeta de este archivo
include_once(__DIR__ . "/../dao/ProductosDAO.php");
include_once(__DIR__ . "/../dao/PedidosDAO.php");
include_once(__DIR__ . "/../dao/UsuariosDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");
include_once(__DIR__ . "/../dao/IngredientesDAO.php");
include_once(__DIR__ . "/../dao/OfertasDAO.php");

class ApiController
{
    //si no se indica accion no hay nada que devolver, 404
    public function index()
    {
        http_response_code(404);
        echo json_encode(["error" => "Indica una acción."]);
    }
    //API de productos para el panel de admin
    public function productos()
    {
        $this->checkUser();

        //segun el metodo de la peticion se ve, se crea o se modifica
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=productos&id=1
                if (isset($_GET['id'])) {
                    $productos = ProductosDAO::getByIdJson($_GET['id']);
                    //reviso que exita el producto para poder asignarle ingredientes en la variable
                    if ($productos) {
                        $productos['ingredientes'] = IngredientesDAO::getDetalleByProducto($productos['id']);
                    }

                    echo json_encode($productos);
                } else {
                    //controller=api&action=productos
                    echo json_encode(ProductosDAO::getAllJson());
                }

                break;
            //crear
            case 'POST':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));

                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $categoria_id = trim($datos->categoria_id ?? "");
                $nombre = trim($datos->nombre ?? "");
                //descripcion e imagen son opcionales: si llegan vacias se guardan como null
                $descripcion = trim($datos->descripcion ?? "") ?: null;
                $precio = trim($datos->precio ?? "");
                $imagen = trim($datos->imagen ?? "") ?: null;
                $activo = trim($datos->activo ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];
                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 150) {
                    $errores[] = "El nombre no puede pasar de 150 caracteres.";
                }

                if (!is_numeric($precio) || $precio < 0 || $precio >= 100000000) {
                    $errores[] = "El precio tiene que ser un número positivo (con punto, no coma).";
                }

                //solo las 4 categorias que conoce ProductosDAO (cada una tiene su clase hija)
                if (!in_array($categoria_id, ["1", "2", "3", "4"], true)) {
                    $errores[] = "La categoría no es válida.";
                }

                if ($imagen !== null && mb_strlen($imagen) > 255) {
                    $errores[] = "La ruta de la imagen es demasiado larga.";
                }

                if ($activo !== '0' && $activo !== '1') {
                    $errores[] = "Activo tiene que ser 0 o 1.";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //Productos es abstracta, asi que se crea la clase hija segun la categoria
                $producto = "";
                switch ($categoria_id) {
                    case '1':
                        $producto = new Hamburguesas(
                            null,
                            $categoria_id,
                            $nombre,
                            $descripcion,
                            $precio,
                            $imagen,
                            $activo
                        );
                        break;
                    case '2':
                        $producto = new Complementos(
                            null,
                            $categoria_id,
                            $nombre,
                            $descripcion,
                            $precio,
                            $imagen,
                            $activo
                        );

                        break;
                    case '3':
                        $producto = new Bebidas(
                            null,
                            $categoria_id,
                            $nombre,
                            $descripcion,
                            $precio,
                            $imagen,
                            $activo
                        );

                        break;
                    case '4':
                        $producto = new Postres(
                            null,
                            $categoria_id,
                            $nombre,
                            $descripcion,
                            $precio,
                            $imagen,
                            $activo
                        );

                        break;
                    default:
                        # code...
                        break;
                }

                //Guardar en BBDD, 201 si va bien y 409 si la BBDD no lo deja guardar
                try {
                    $id = ProductosDAO::insert($producto);
                    http_response_code(201);
                    echo json_encode(["ok" => true, "id" => $id]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido crear el registro"]);
                }
                break;
            //modificar
            case 'PUT':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));
                //sin id no sabemos que registro cambiar
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta el id"]);
                    break;
                }
                //pedir a bd y si llega null que salga y pare la ejecucion del update
                $producto = ProductosDAO::getById($_GET['id']);
                if (!$producto) {
                    http_response_code(404);
                    echo json_encode(["error" => "Producto no encontrado"]);
                    break;
                }
                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $nombre = trim($datos->nombre ?? "");
                $descripcion = trim($datos->descripcion ?? "");
                $precio = trim($datos->precio ?? "");
                $categoriaId = trim($datos->categoria_id ?? "");
                $imagen = trim($datos->imagen ?? "");
                $activo = trim($datos->activo ?? "");
                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];
                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 150) {
                    $errores[] = "El nombre no puede pasar de 150 caracteres.";
                }

                if (!is_numeric($precio) || $precio < 0 || $precio >= 100000000) {
                    $errores[] = "El precio tiene que ser un número positivo (con punto, no coma).";
                }

                if (filter_var($categoriaId, FILTER_VALIDATE_INT) === false || !CategoriasDAO::getById($categoriaId)) {
                    $errores[] = "La categoría no existe.";
                }

                if ($imagen !== null && mb_strlen($imagen) > 255) {
                    $errores[] = "La ruta de la imagen es demasiado larga.";
                }

                if ($activo !== '0' && $activo !== '1') {
                    $errores[] = "Activo tiene que ser 0 o 1.";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //Cambiar los datos con los set
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setCategoriaId($categoriaId);
                $producto->setImagen($imagen);
                $producto->setActivo($activo);



                //Guardar en BBDD
                ProductosDAO::update($producto);
                echo json_encode(["ok" => true]);

                break;
            case 'DELETE':

                break;
            default:
                $this->noMetodo();

                break;
        }
    }

    //devuelve los datos del admin que ha iniciado sesion
    public function sesion()
    {
        $this->checkUser(); // si no es admin, 403 y se para
        $usuario = $_SESSION['usuario'];
        echo json_encode([
            "id" => $usuario->getId(),
            "nombre" => $usuario->getNombre(),
            "rol" => $usuario->getRol(),
        ]);
    }
    //API de usuarios para el panel de admin
    public function usuarios()
    {
        $this->checkUser();

        //segun el metodo de la peticion se ve, se crea o se modifica
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar, con id uno solo y sin id todos
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=usuarios&id=1
                if (isset($_GET['id'])) {
                    $usuarios = UsuariosDAO::getByIdJson($_GET['id']);
                    if ($usuarios) {
                        $usuarios['pedidosArray'] = PedidosDAO::getPedidosByUsuarioJson($usuarios['id']);
                    }
                    echo json_encode($usuarios);
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(UsuariosDAO::getAllJson());
                }

                break;
            //crear
            case 'POST':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));

                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $nombre = trim($datos->nombre ?? "");
                $email = trim($datos->email ?? "");
                $password = trim($datos->password ?? "");
                //si llega vacio se guarda null porque es opcional
                $telefono = trim($datos->telefono ?? "") ?: null;
                $direccion = trim($datos->direccion ?? "") ?: null;
                $fecha_nacimiento = trim($datos->fecha_nacimiento ?? "") ?: null;
                $rol = trim($datos->rol ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];

                if ($nombre === '' || mb_strlen($nombre) > 100) {
                    $errores[] = "El nombre es obligatorio y debe tener como máximo 100 caracteres";
                }
                if (strlen($password) < 8) {
                    $errores[] = "La contraseña debe tener al menos 8 caracteres";
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
                    $errores[] = "El email no es válido";
                }
                if ($telefono !== null && !preg_match('/^[0-9 +]{6,20}$/', $telefono)) {
                    $errores[] = "El teléfono no es válido";
                }
                if ($fecha_nacimiento !== null && $fecha_nacimiento > date('Y-m-d')) {
                    $errores[] = "La fecha de nacimiento no puede ser posterior al día de hoy";
                }

                if ($rol != "usuario" && $rol != "admin") {
                    $errores[] = "Se esta creando con un rol NO permitido";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }


                //crear el objeto con los datos, sin id porque lo pone la BBDD
                $cat = new Usuarios(
                    null,
                    $nombre,
                    $email,
                    //la contraseña se guarda cifrada, al entrar se comprueba con password_verify
                    password_hash($password, PASSWORD_DEFAULT),
                    $telefono,
                    $direccion,
                    $fecha_nacimiento,
                    $rol,
                    null
                );


                //Guardar en BBDD, 201 si va bien y 409 si la BBDD no lo deja guardar
                try {
                    $id = UsuariosDAO::insert($cat);
                    http_response_code(201);
                    echo json_encode(["ok" => true, "id" => $id]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido crear el registro"]);
                }
                break;
            //modificar
            case 'PUT':
                # code...
                break;
            default:
                $this->noMetodo();

                break;
        }
    }
    //API de pedidos para el panel de admin
    public function pedidos()
    {
        $this->checkUser();

        //segun el metodo de la peticion se ve, se crea o se modifica
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar, con id uno solo y sin id todos
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=pedidos&id=1
                if (isset($_GET['id'])) {
                    $pedidos = PedidosDAO::getByIdJson($_GET['id']);

                    if ($pedidos) {
                        $pedidos['detalle'] = PedidosDAO::getDetalleJson($pedidos['id']);
                        //por cada linea del pedido, con $key se escribe en el array original y no en la copia $value
                        foreach ($pedidos['detalle'] as $key => $value) {
                            //los ingredientes de esa linea, guardados dentro de ella en el original
                            $pedidos['detalle'][$key]['ingredientes'] = PedidosDAO::getIngredientesDetalleJson($value['id']);

                        }

                    }
                    echo json_encode($pedidos);
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(PedidosDAO::getAllJson());
                }

                break;
            //Ojo: no se usa, desde el panel no se crean pedidos
            case 'POST':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));

                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $usuario_id = trim($datos->usuario_id ?? "");
                $estado = trim($datos->estado ?? "");
                $fecha_pedido = trim($datos->fecha_pedido ?? "");
                $subtotal = trim($datos->subtotal ?? "");
                $descuento = trim($datos->descuento ?? "");
                $total = trim($datos->total ?? "");
                $metodo_pago = trim($datos->metodo_pago ?? "");
                $estado_pago = trim($datos->estado_pago ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];


                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //crear el objeto con los datos, sin id porque lo pone la BBDD
                $cat = new Pedidos(
                    null,
                    $usuario_id,
                    $estado,
                    $fecha_pedido,
                    $subtotal,
                    $descuento,
                    $total,
                    $metodo_pago,
                    $estado_pago
                );


                //Guardar en BBDD, 201 si va bien y 409 si la BBDD no lo deja guardar
                try {
                    $id = PedidosDAO::insert($cat);
                    http_response_code(201);
                    echo json_encode(["ok" => true, "id" => $id]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido crear el registro"]);
                }
                break;
            //modificar
            case 'PUT':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));
                //sin id no sabemos que registro cambiar
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta el id"]);
                    break;
                }
                //pedir a bd y si llega null que salga y pare la ejecucion del update
                $pedido = PedidosDAO::getById($_GET['id']);
                if (!$pedido) {
                    http_response_code(404);
                    echo json_encode(["error" => "Pedido no encontrado"]);
                    break;
                }
                $estado = $datos->estado ?? '';
                $estadoPago = $datos->estado_pago ?? '';

                //solo se aceptan los estados que hay en la BBDD
                $estados = [
                    'pendiente',
                    'confirmado',
                    'preparando',
                    'enviado',
                    'entregado',
                    'cancelado',
                ];
                $estadosPago = [
                    'pendiente',
                    'pagado',
                    'fallido'
                ];
                if (!in_array($estado, $estados, true)) {
                    http_response_code(400);
                    echo json_encode(["error" => "Estado no valido"]);
                    break;
                }
                if (!in_array($estadoPago, $estadosPago, true)) {
                    http_response_code(400);
                    echo json_encode(["error" => "Estado de pago no valido"]);
                    break;
                }


                //solo se cambia el estado del pedido y el del pago
                PedidosDAO::updateEstado($_GET['id'], $estado, $estadoPago);
                echo json_encode(["ok" => true]);
                break;
            default:
                $this->noMetodo();

                break;
        }
    }

    //API de categorias para el panel de admin
    public function categorias()
    {
        $this->checkUser();
        //segun el metodo de la peticion se ve, se crea o se modifica
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar, con id uno solo y sin id todos
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=categorias&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(CategoriasDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=categorias
                    echo json_encode(CategoriasDAO::getAllJson());
                }

                break;
            //crear
            case 'POST':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));

                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $nombre = trim($datos->nombre ?? "");
                $descripcion = trim($datos->descripcion ?? "");
                $activa = trim($datos->activa ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];
                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 150) {
                    $errores[] = "El nombre no puede pasar de 150 caracteres.";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //crear el objeto con los datos, sin id porque lo pone la BBDD
                $cat = new Categorias(null, $nombre, $descripcion, $activa);

                //Guardar en BBDD, 201 si va bien y 409 si la BBDD no lo deja guardar
                try {
                    $id = CategoriasDAO::insert($cat);
                    http_response_code(201);
                    echo json_encode(["ok" => true, "id" => $id]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido crear el registro"]);
                }

                break;
            //modificar
            case 'PUT':

                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));
                //sin id no sabemos que registro cambiar
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta el id"]);
                    break;
                }
                //pedir a bd y si llega null que salga y pare la ejecucion del update
                $categorias = CategoriasDAO::getById($_GET['id']);
                if (!$categorias) {
                    http_response_code(404);
                    echo json_encode(["error" => "Categoría no encontrada"]);
                    break;
                }
                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $activa = trim($datos->activa ?? "");
                $nombre = trim($datos->nombre ?? "");
                $descripcion = trim($datos->descripcion ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];
                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 100) {
                    $errores[] = "El nombre no puede pasar de 100 caracteres.";
                }

                if ($activa !== '0' && $activa !== '1') {
                    $errores[] = "Activo tiene que ser 0 o 1.";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //Cambiar los datos con los set
                $categorias->setNombre($nombre);
                $categorias->setDescripcion($descripcion);
                $categorias->setActiva($activa);

                //Guardar en BBDD, 409 si la BBDD no lo deja guardar
                try {
                    CategoriasDAO::update($categorias);
                    echo json_encode(["ok" => true]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido guardar. ¿Ya existe ese nombre?"]);
                }

                break;
            default:
                $this->noMetodo();
                break;
        }
    }
    //API de ingredientes para el panel de admin
    public function ingredientes()
    {
        $this->checkUser();
        //segun el metodo de la peticion se ve, se crea o se modifica
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar, con id uno solo y sin id todos
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=categorias&id=1
                if (isset($_GET['id'])) {
                    $ingredientes = IngredientesDAO::getByIdJson($_GET['id']);

                    echo json_encode($ingredientes);
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(IngredientesDAO::getAllJson());
                }

                break;
            //crear
            case 'POST':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));

                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $nombre = trim($datos->nombre ?? "");
                $precio_extra = trim($datos->precio_extra ?? "");
                $activo = trim($datos->activo ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];

                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 100) {
                    $errores[] = "El nombre no puede pasar de 100 caracteres.";
                }
                if (!is_numeric($precio_extra) || $precio_extra < 0 || $precio_extra >= 100000000) {
                    $errores[] = "El precio tiene que ser un número positivo (con punto, no coma).";
                }
                if ($activo !== '0' && $activo !== '1') {
                    $errores[] = "Activo tiene que ser 0 o 1.";
                }
                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //crear el objeto con los datos, sin id porque lo pone la BBDD
                $cat = new Ingredientes(
                    null,
                    $nombre,
                    $precio_extra,
                    $activo
                );


                //Guardar en BBDD, 201 si va bien y 409 si la BBDD no lo deja guardar
                try {
                    $id = IngredientesDAO::insert($cat);
                    http_response_code(201);
                    echo json_encode(["ok" => true, "id" => $id]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido crear el registro"]);
                }
                break;
            //modificar
            case 'PUT':

                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));
                //sin id no sabemos que registro cambiar
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta el id"]);
                    break;
                }
                //pedir a bd y si llega null que salga y pare la ejecucion del update
                $ingredientes = IngredientesDAO::getById($_GET['id']);
                if (!$ingredientes) {
                    http_response_code(404);
                    echo json_encode(["error" => "Ingrediente no encontrado"]);
                    break;
                }
                //el id no se lee del cuerpo: el objeto de getById ya trae el de la URL
                $nombre = trim($datos->nombre ?? "");
                $precio_extra = trim($datos->precio_extra ?? "");
                $activo = trim($datos->activo ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];
                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 100) {
                    $errores[] = "El nombre no puede pasar de 100 caracteres.";
                }
                if (!is_numeric($precio_extra) || $precio_extra < 0 || $precio_extra >= 100000000) {
                    $errores[] = "El precio tiene que ser un número positivo (con punto, no coma).";
                }
                if ($activo !== '0' && $activo !== '1') {
                    $errores[] = "Activo tiene que ser 0 o 1.";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }
                //Cambiar los datos con los set
                $ingredientes->setNombre($nombre);
                $ingredientes->setPrecioExtra($precio_extra);
                $ingredientes->setActivo($activo);

                //Guardar en BBDD, 409 si la BBDD no lo deja guardar
                try {
                    IngredientesDAO::update($ingredientes);
                    echo json_encode(["ok" => true]);
                } catch (mysqli_sql_exception $e) {
                    http_response_code(409);
                    echo json_encode(["error" => "No se ha podido guardar. ¿Ya existe ese nombre?"]);
                }
                break;
            default:
                $this->noMetodo();
                break;
        }
    }
    //API de ofertas para el panel de admin
    public function ofertas()
    {
        $this->checkUser();
        //segun el metodo de la peticion se ve, se crea o se modifica
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar, con id uno solo y sin id todos
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=categorias&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(OfertasDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(OfertasDAO::getAllJson());
                }

                break;
            //crear
            case 'POST':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));

                //el ?? "" es por si no llega el campo, asi trim no da aviso
                $nombre = trim($datos->nombre ?? "");
                //si llega vacio se guarda null porque es opcional
                $descripcion = trim($datos->descripcion ?? "") ?: null;
                $tipo = trim($datos->tipo ?? "");
                $valor = trim($datos->valor ?? "") ?: null;
                $codigo = trim($datos->codigo ?? "") ?: null;
                $fecha_inicio = trim($datos->fecha_inicio ?? "");
                $fecha_fin = trim($datos->fecha_fin ?? "") ?: null;
                $activa = trim($datos->activa ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];

                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 150) {
                    $errores[] = "El nombre no puede pasar de 150 caracteres.";
                }
                $listaDescuentos = ["descuento", "2x1", "combo", "codigo"];
                if (!in_array($tipo, $listaDescuentos)) {
                    $errores[] = "El Tipo de descuento no existe en BD";
                }
                //el valor es opcional (un 2x1 no lo usa); si lo hay, tiene que ser un numero no negativo
                if ($valor !== null && (!is_numeric($valor) || $valor < 0)) {
                    $errores[] = "El valor tiene que ser un número positivo (con punto, no coma).";
                }
                if ($activa !== '0' && $activa !== '1') {
                    $errores[] = "Activa tiene que ser 0 o 1.";
                }
                //el codigo es opcional (solo lo usan las ofertas de tipo codigo); si lo hay, maximo 50
                if ($codigo !== null && mb_strlen($codigo) > 50) {
                    $errores[] = "El código no puede pasar de 50 caracteres.";
                }
                if ($fecha_inicio === "") {
                    $errores[] = "Fecha de inicio es obligatoria";
                }
                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                //crear el objeto con los datos, sin id porque lo pone la BBDD
                $cat = new Ofertas(
                    null,
                    $nombre,
                    $descripcion,
                    $tipo,
                    $valor,
                    $codigo,
                    $fecha_inicio,
                    $fecha_fin,
                    $activa
                );


                //Guardar en BBDD, 201 si va bien y 409 si la BBDD no lo deja guardar
                try {
                    $id = OfertasDAO::insert($cat);
                    http_response_code(201);
                    echo json_encode(["ok" => true, "id" => $id]);
                } catch (mysqli_sql_exception $e) {
                    //el codigo es unico: si ya existe, la base de datos no deja guardarlo
                    http_response_code(409);
                    echo json_encode(["error" => "Ya existe una oferta con ese código."]);
                }
                break;

            //modificar
            case 'PUT':
                //leer el JSON que manda el fetch (con JSON $_POST llega vacio)
                $datos = json_decode(file_get_contents('php://input'));
                //sin id no sabemos que registro cambiar
                if (!isset($_GET['id'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta el id"]);
                    break;
                }
                //pedir a bd y si llega null que salga y pare la ejecucion del update
                $ofertas = OfertasDAO::getById($_GET['id']);
                if (!$ofertas) {
                    http_response_code(404);
                    echo json_encode(["error" => "Oferta no encontrada"]);
                    break;
                }
                //el id no se lee del cuerpo: el objeto de getById ya trae el de la URL
                $nombre = trim($datos->nombre ?? "");
                //si llega vacio se guarda null porque es opcional
                $descripcion = trim($datos->descripcion ?? "") ?: null;
                $tipo = trim($datos->tipo ?? "");
                $valor = trim($datos->valor ?? "") ?: null;
                $codigo = trim($datos->codigo ?? "") ?: null;
                $fecha_inicio = trim($datos->fecha_inicio ?? "");
                $fecha_fin = trim($datos->fecha_fin ?? "") ?: null;
                //en ofertas la columna se llama activa, no activo
                $activa = trim($datos->activa ?? "");

                //Comprobar los campos y guardar todos los errores juntos
                $errores = [];
                if ($nombre === '') {
                    $errores[] = "El nombre es obligatorio.";
                } elseif (mb_strlen($nombre) > 150) {
                    $errores[] = "El nombre no puede pasar de 150 caracteres.";
                }
                $listaDescuentos = ["descuento", "2x1", "combo", "codigo"];
                if (!in_array($tipo, $listaDescuentos)) {
                    $errores[] = "El Tipo de descuento no existe en BD";
                }
                if ($valor !== null && (!is_numeric($valor) || $valor < 0)) {
                    $errores[] = "El valor tiene que ser un número positivo (con punto, no coma).";
                }
                if ($codigo !== null && mb_strlen($codigo) > 50) {
                    $errores[] = "El código no puede pasar de 50 caracteres.";
                }
                if ($fecha_inicio === "") {
                    $errores[] = "Fecha de inicio es obligatoria";
                }
                if ($activa !== '0' && $activa !== '1') {
                    $errores[] = "Activa tiene que ser 0 o 1.";
                }

                //Si hay errores devolvemos 400 con todos y paramos
                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }
                //Cambiar los datos con los set
                $ofertas->setNombre($nombre);
                $ofertas->setDescripcion($descripcion);
                $ofertas->setTipo($tipo);
                $ofertas->setValor($valor);
                $ofertas->setCodigo($codigo);
                $ofertas->setFechaInicio($fecha_inicio);
                $ofertas->setFechaFin($fecha_fin);
                $ofertas->setActiva($activa);

                //Guardar en BBDD, 409 si la BBDD no lo deja guardar
                try {
                    OfertasDAO::update($ofertas);
                    echo json_encode(["ok" => true]);
                } catch (mysqli_sql_exception $e) {
                    //el codigo es unico: si ya existe, la base de datos no deja guardarlo
                    http_response_code(409);
                    echo json_encode(["error" => "Ya existe una oferta con ese código."]);
                }
                break;
            default:
                $this->noMetodo();
                break;
        }
    }

    //si no es admin responde 403 y el exit para todo el script
    private function checkUser()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() != 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "No tienes acceso a la API"]);
            exit();

        }
    }
    //405 si la accion no acepta ese metodo (por ejemplo un DELETE donde no lo hay)
    private function noMetodo()
    {
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);

    }
}
