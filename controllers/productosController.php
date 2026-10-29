<?php
//daos
include_once(__DIR__ . "/../dao/hamburguesasDAO.php");
include_once(__DIR__ . "/../dao/complementosDAO.php");
include_once(__DIR__ . "/../dao/bebidasDAO.php");
include_once(__DIR__ . "/../dao/postresDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");

//modelos
include_once(__DIR__ . "/../modelos/hamburguesas.php");
include_once(__DIR__ . "/../modelos/complementos.php");
include_once(__DIR__ . "/../modelos/bebidas.php");
include_once(__DIR__ . "/../modelos/postres.php");
include_once(__DIR__ . "/../modelos/Categorias.php");


class ProductosController
{
    public function index()
    {        
        if(!isset($_GET['pildora'])){
        $_GET['pildora']="Todo";
        }

        //Clases individuales para filtros
        $categorias = CategoriasDAO::getAll();
        $Hamburguesas = HamburguesasDAO::getAll();
        $Complementos = ComplementosDAO::getAll();
        $Bebidas = BebidasDAO::getAll();
        $Postres = PostresDAO::getAll();

        $listadoProductos["hamburguesas"] = $Hamburguesas;
        $listadoProductos["complementos"] = $Complementos;
        $listadoProductos["bebidas"] = $Bebidas;
        $listadoProductos["postres"] = $Postres;


        $view = "views/productos/carta.php";
        include_once 'views/main.php';
    }
    public function carta()
    {
        $seleccionadas = $_GET['pildora'];
        $categorias = CategoriasDAO::getAll();
        $listadoProductos = null;
        // echo "$seleccionadas El texto a la izquieda // ";
        switch ($seleccionadas) {
            case 'Hamburguesas':
                // echo "textorandom1";
                $listadoProductos["hamburguesas"] = HamburguesasDAO::getAll();
                break;
            case 'Complementos':
                // echo "textorandom2";
                $listadoProductos["complementos"] = ComplementosDAO::getAll();
                break;
            case 'Bebidas':
                $listadoProductos["bebidas"] = BebidasDAO::getAll();
                break;
            case 'Postres':
                $listadoProductos["postres"] = PostresDAO::getAll();
                break;
            default:
                $listadoProductos["hamburguesas"] = HamburguesasDAO::getAll();
                $listadoProductos["complementos"] = ComplementosDAO::getAll();
                $listadoProductos["bebidas"] = BebidasDAO::getAll();
                $listadoProductos["postres"] = PostresDAO::getAll();
                break;
        }
        $view = "views/productos/carta.php";
        include_once 'views/main.php';
    }

}

?>