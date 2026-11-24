<?php
include_once(__DIR__ . "/../dao/ProductosDAO.php");
include_once(__DIR__ . "/../dao/PedidosDAO.php");
include_once(__DIR__ . "/../dao/UsuariosDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");
include_once(__DIR__ . "/../dao/IngredientesDAO.php");
include_once(__DIR__ . "/../dao/OfertasDAO.php");

class ApiController
{
    public function index()
    {
        http_response_code(404);
        echo json_encode(["error" => "Indica una acción."]);
    }
    public function productos()
    {
        $this->checkUser();

        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            //visualizar
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=productos&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(ProductosDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=productos
                    echo json_encode(ProductosDAO::getAllJson());
                }

                break;
            //crear
            case 'POST':
                # code...
                break;
            //modificar
            case 'PUT':
                $datos = json_decode(file_get_contents('php://input'));
                // para que no explote el codigo cuando se pida a bd
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
                $nombre = trim($datos->nombre ?? "");
                $descripcion = trim($datos->descripcion ?? "");
                $precio = trim($datos->precio ?? "");
                $categoriaId = trim($datos->categoria_id ?? "");
                $imagen = trim($datos->imagen ?? "");
                $activo = trim($datos->activo ?? "");
                //validacion errores del formulario
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

                if (count($errores) > 0) {
                    http_response_code(400);
                    echo json_encode(["error" => implode(' ', $errores)]);
                    break;
                }

                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setCategoriaId($categoriaId);
                $producto->setImagen($imagen);
                $producto->setActivo($activo);



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
    public function usuarios()
    {
        $this->checkUser();

        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=usuarios&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(UsuariosDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(UsuariosDAO::getAllJson());
                }

                break;
            case 'POST':
                # code...
                break;
            case 'PUT':
                # code...
                break;
            default:
                $this->noMetodo();

                break;
        }
    }
    public function pedidos()
    {
        $this->checkUser();

        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=pedidos&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(PedidosDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(PedidosDAO::getAllJson());
                }

                break;
            case 'POST':
                # code...
                break;
            case 'PUT':
                $datos = json_decode(file_get_contents('php://input'));
                // para que no explote el codigo cuando se pida a bd
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


                PedidosDAO::updateEstado($_GET['id'], $estado, $estadoPago);
                echo json_encode(["ok" => true]);
                break;
            default:
                $this->noMetodo();

                break;
        }
    }

    public function categorias()
    {
        $this->checkUser();
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=categorias&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(CategoriasDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(CategoriasDAO::getAllJson());
                }

                break;
            case 'POST':
                # code...
                break;
            case 'PUT':
                # code...
                break;
            default:
                $this->noMetodo();
                break;
        }
    }
    public function ingredientes()
    {
        $this->checkUser();
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=categorias&id=1
                if (isset($_GET['id'])) {
                    echo json_encode(IngredientesDAO::getByIdJson($_GET['id']));
                } else {
                    //controller=api&action=usuarios
                    echo json_encode(IngredientesDAO::getAllJson());
                }

                break;
            case 'POST':
                # code...
                break;
            case 'PUT':
                # code...
                break;
            default:
                $this->noMetodo();
                break;
        }
    }
    public function ofertas()
    {
        $this->checkUser();
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
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
            case 'POST':
                # code...
                break;
            case 'PUT':
                # code...
                break;
            default:
                $this->noMetodo();
                break;
        }
    }

    //añadir ingredientes y ofertas
    private function checkUser()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() != 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "No tienes acceso a la API"]);
            exit();

        }
    }
    private function noMetodo()
    {
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);

    }
}
