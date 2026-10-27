<?php
include_once("modelos/hamburguesas.php");
include_once("modelos/complementos.php");
include_once("modelos/bebidas.php");
include_once("modelos/postres.php");
include_once("dao/hamburguesasDAO.php");
include_once("dao/complementosDAO.php");
include_once("dao/bebidasDAO.php");
include_once("dao/postresDAO.php");

class ProductosController
{
    public function index()
    {
        $productos[] = HamburguesasDAO::getAll();
        $productos[] = ComplementosDAO::getAll();
        $productos[] = BebidasDAO::getAll();
        $productos[] = PostresDAO::getAll();

        $view = "views/productos/listado.php";
        include_once 'views/main.php';
    }
}

?>