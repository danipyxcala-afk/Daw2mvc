<?php
include_once(__DIR__ . "/../dao/ProductosDAO.php");
include_once(__DIR__ . "/../dao/PedidosDAO.php");
include_once(__DIR__ . "/../dao/UsuariosDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");


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
                # code...
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
