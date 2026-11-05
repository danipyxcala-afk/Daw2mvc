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

    // Recibe el formulario de detalle y guarda el producto en el carrito de la sesión
    public function anadirCarrito()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir("index.php?controller=productos");
        }

        $producto = $this->getProductoActivo($_POST['id'] ?? 0);
        $ingredientes = $this->getIngredientesProducto($producto);

        // Solo nos fiamos de los ids: nombres y precios se leen siempre de la base de datos,
        // así nadie puede cambiar un precio o colar un ingrediente de otro producto desde el navegador
        $idsQuitados = array_map('intval', (array) ($_POST['quitados'] ?? []));
        $idsExtras = array_map('intval', (array) ($_POST['extras'] ?? []));

        $quitados = [];
        foreach ($ingredientes['base'] as $ingrediente) {
            if (!$ingrediente['fija'] && in_array((int) $ingrediente['id'], $idsQuitados)) {
                $quitados[] = [
                    'ingrediente_id' => (int) $ingrediente['id'],
                    'nombre' => $ingrediente['nombre'],
                ];
            }
        }

        // El producto debe conservar al menos un ingrediente base
        if (count($ingredientes['base']) > 0 && count($quitados) === count($ingredientes['base'])) {
            $_SESSION['aviso'] = "Deja al menos un ingrediente en tu producto.";
            $this->redirigir("index.php?controller=productos&action=detalle&id=" . (int) $producto->getId());
        }

        $extras = [];
        $precioUnitario = (float) $producto->getPrecio();
        foreach ($ingredientes['extras'] as $ingrediente) {
            if (in_array((int) $ingrediente['id'], $idsExtras)) {
                $extras[] = [
                    'ingrediente_id' => (int) $ingrediente['id'],
                    'nombre' => $ingrediente['nombre'],
                    'precio_extra' => (float) $ingrediente['precio_extra'],
                ];
                $precioUnitario += (float) $ingrediente['precio_extra'];
            }
        }

        $cantidad = max(1, min(self::CANTIDAD_MAXIMA, (int) ($_POST['cantidad'] ?? 1)));

        // La clave identifica el producto y su personalización:
        // si se repite exactamente igual sumamos la cantidad, si no, es otra línea del carrito
        $clave = $producto->getId()
            . '|' . implode(',', array_column($quitados, 'ingrediente_id'))
            . '|' . implode(',', array_column($extras, 'ingrediente_id'));

        if (isset($_SESSION['carrito'][$clave])) {
            $total = $_SESSION['carrito'][$clave]['cantidad'] + $cantidad;
            $_SESSION['carrito'][$clave]['cantidad'] = min(self::CANTIDAD_MAXIMA, $total);
        } else {
            $_SESSION['carrito'][$clave] = [
                'producto_id' => (int) $producto->getId(),
                'nombre' => $producto->getNombre(),
                'imagen' => $producto->getImagen(),
                'precio_unitario' => round($precioUnitario, 2),
                'cantidad' => $cantidad,
                'quitados' => $quitados,
                'extras' => $extras,
            ];
        }

        $_SESSION['aviso'] = $producto->getNombre() . " se ha añadido al carrito.";
        $this->redirigir("index.php?controller=productos");
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