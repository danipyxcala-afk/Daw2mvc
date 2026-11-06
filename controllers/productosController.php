<?php
//daos
include_once(__DIR__ . "/../dao/hamburguesasDAO.php");
include_once(__DIR__ . "/../dao/complementosDAO.php");
include_once(__DIR__ . "/../dao/bebidasDAO.php");
include_once(__DIR__ . "/../dao/postresDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");
include_once(__DIR__ . "/../dao/ingredientesDAO.php");

//modelos
include_once(__DIR__ . "/../modelos/hamburguesas.php");
include_once(__DIR__ . "/../modelos/complementos.php");
include_once(__DIR__ . "/../modelos/bebidas.php");
include_once(__DIR__ . "/../modelos/postres.php");
include_once(__DIR__ . "/../modelos/Categorias.php");


class ProductosController
{
    private const CATEGORIA_BEBIDAS = 3;
    private const CANTIDAD_MAXIMA = 99;

    public function index()
    {
        if (!isset($_GET['pildora'])) {
            $_GET['pildora'] = "Todo";
        }

        //Clases individuales para filtros
        $categorias = CategoriasDAO::getAll();
        $categoriasActivas = $this->getCategoriasActivas();
        $coloresCategorias = $this->getColoresCat();
        $listadoProductos = $this->getListadoProductos();


        $view = "views/productos/carta.php";
        include_once 'views/main.php';
    }
    public function carta()
    {
        $seleccionadas = $_GET['pildora'];
        $categorias = CategoriasDAO::getAll();
        $categoriasActivas = $this->getCategoriasActivas();
        $coloresCategorias = $this->getColoresCat();

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

    // Pantalla de un producto, donde el cliente lo personaliza
    public function detalle()
    {
        $producto = $this->getProductoActivo($_GET['id'] ?? 0);

        $ingredientes = $this->getIngredientesProducto($producto);
        $ingredientesBase = $ingredientes['base'];
        $extras = $ingredientes['extras'];

        $categoria = CategoriasDAO::getById($producto->getCategoria_id());
        $colorCategoria = $this->getColorCategoria($producto->getCategoria_id());

        $view = "views/productos/detalle.php";
        include_once 'views/main.php';
    }
    public function anadirCarrito(){
        //TODO logica
    }

    // Busca el producto en cada categoría. Si no existe o no está activo, muestra el error 404
    private function getProductoActivo($id)
    {
        $id = (int) $id;
        $producto = HamburguesasDAO::getById($id)
            ?: ComplementosDAO::getById($id)
            ?: BebidasDAO::getById($id)
            ?: PostresDAO::getById($id);

        if (!$producto || !$producto->getActivo()) {
            showError(404, "No existe este producto");
        }
        return $producto;
    }

    // Separa los ingredientes en base (cantidad > 0) y extras (cantidad = 0)
    private function getIngredientesProducto($producto)
    {
        $esBebida = (int) $producto->getCategoria_id() === self::CATEGORIA_BEBIDAS;
        $resultado = ['base' => [], 'extras' => []];

        foreach (IngredientesDAO::getDetalleByProducto($producto->getId()) as $ingrediente) {
            if ((float) $ingrediente['cantidad'] > 0) {
                // En las bebidas solo se puede quitar el hielo, no la bebida
                $ingrediente['fija'] = $esBebida && $ingrediente['nombre'] !== 'Hielo';
                $resultado['base'][] = $ingrediente;
            } else {
                $resultado['extras'][] = $ingrediente;
            }
        }
        return $resultado;
    }

    // Mismo color que en la home y la carta: según la posición entre las categorías activas
    private function getColorCategoria($categoria_id)
    {
        $colores = $this->getColoresCat();
        $posicion = 0;
        foreach ($this->getCategoriasActivas() as $categoria) {
            if ($categoria->getId() == $categoria_id) {
                return $colores[$posicion % count($colores)];
            }
            $posicion++;
        }
        return null;
    }

    private function redirigir($ruta)
    {
        header("Location: " . url . $ruta);
        exit;
    }

    public function getCategoriasActivas()
    {
        return array_filter(CategoriasDAO::getAll(), function ($categoria) {
            return $categoria->getActiva();
        });
    }
    public function getColoresCat()
    {
        return ["oscuro", "medio", "claro", "gris"];

    }
    public function getListadoProductos()
    {

        $Hamburguesas = HamburguesasDAO::getAll();
        $Complementos = ComplementosDAO::getAll();
        $Bebidas = BebidasDAO::getAll();
        $Postres = PostresDAO::getAll();

        $listadoProductos["hamburguesas"] = $Hamburguesas;
        $listadoProductos["complementos"] = $Complementos;
        $listadoProductos["bebidas"] = $Bebidas;
        $listadoProductos["postres"] = $Postres;
        return $listadoProductos;
    }
}

?>