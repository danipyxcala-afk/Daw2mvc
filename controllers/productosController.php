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
        //Clases individuales para filtros
        $Hamburguesas = HamburguesasDAO::getAll();
        $Complementos = ComplementosDAO::getAll();
        $Bebidas = BebidasDAO::getAll();
        $Postres = PostresDAO::getAll();
        $categorias = CategoriasDAO::getAll();
        
        //Crear el conjunto Faltan ifs
        $listadoProductos[] = $Hamburguesas;
        $listadoProductos[] = $Complementos;
        $listadoProductos[] = $Bebidas;
        $listadoProductos[] = $Postres;


        $view = "views/productos/carta.php";
        include_once 'views/main.php';
    }
    public function buscarPildora(){
        
    }

}

?>