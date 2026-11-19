<?php
include_once(__DIR__ . "/../dao/ProductosDAO.php");
include_once(__DIR__ . "/../dao/PedidosDAO.php");
include_once(__DIR__ . "/../dao/UsuariosDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");


class ApiController
{
    public function index()
    {

        $view = "views/admin/panel.php";
        include_once 'views/main.php';
    }
    public function productos()
    {
        $this->checkUser();

        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=productos&id=1
                if ($_GET['id'] !== null) {
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
                if ($_GET['id'] !== null) {
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

                break;
        }
    }
    public function pedidos()
    {
        $this->checkUser();

        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=usuarios&id=1
                if ($_GET['id'] !== null) {
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

                break;
        }
    }

    public function categorias()
    {
        $this->checkUser();
        switch ($metodo = $_SERVER['REQUEST_METHOD']) {
            case 'GET':
                //El get mira si tiene la id en el link
                //controller=api&action=usuarios&id=1
                if ($_GET['id'] !== null) {
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

                break;
        }
    }
    public function checkUser()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() != 'admin') {
            $_SESSION['aviso'] = "Este usuario no tiene acceso al panel de administracion/api";
            header("Location: " . url . "index.php?controller=home");
            exit();

        }
    }
}
