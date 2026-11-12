<?php
include_once(__DIR__ . "/ProductosController.php");
class HomeController
{
    function index()
    {

        //Llamar a la lista de productos creado en otro metodo para no repetirlo
        $controladorproductos = new ProductosController();
        $pd = $controladorproductos->getListadoProductos();

        // Juntamos todas las categorías en una sola lista y elegimos uno al azar
        $todosProductos = array_merge(...array_values($pd));
        $productoAleatorio = $todosProductos[array_rand($todosProductos)];

        //  si en bbdd es activa == 0 no se mostraria en cliente
        // Creado en otro metodo para no tener que repetirlo
        $categorias = $controladorproductos->getCategoriasActivas();
        $coloresCategorias = $controladorproductos->getColoresCat();

        // La tabla categorias no guarda imagen: indicamos cuál representa a cada una
        $imagenesCategorias = [
            "Hamburguesas" => "img/productos/classic-burger.webp",
            "Complementos" => "img/productos/patatas-classicas.webp",
            "Bebidas" => "img/productos/batido-chocolate.webp",
            "Postres" => "img/productos/brownie-con-helado.webp",
        ];

        $view = "views/inicio/home.php";
        include_once 'views/main.php';
    }
}
?>