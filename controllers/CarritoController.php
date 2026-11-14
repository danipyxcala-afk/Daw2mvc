<?php
//daos
include_once(__DIR__ . "/../dao/HamburguesasDAO.php");
include_once(__DIR__ . "/../dao/ComplementosDAO.php");
include_once(__DIR__ . "/../dao/BebidasDAO.php");
include_once(__DIR__ . "/../dao/PostresDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");
include_once(__DIR__ . "/../dao/IngredientesDAO.php");
include_once(__DIR__ . "/../dao/OfertasDAO.php");

//modelos
include_once(__DIR__ . "/../modelos/Hamburguesas.php");
include_once(__DIR__ . "/../modelos/Complementos.php");
include_once(__DIR__ . "/../modelos/Bebidas.php");
include_once(__DIR__ . "/../modelos/Postres.php");
include_once(__DIR__ . "/../modelos/Categorias.php");
include_once(__DIR__ . "/../modelos/Ofertas.php");


class CarritoController
{
    public function index()
    {
        $lineas = $_SESSION['carrito'] ?? [];
        $totales = $this->calcularTotales($lineas);
        $subtotal = $totales['subtotal'];
        $iva = $totales['iva'];
        $envio = $totales['envio'];
        $descuento = $totales['descuento'];
        $total = $totales['total'];

        $view = "views/carrito/carrito.php";
        include_once 'views/main.php';
    }

    public function cambiarCantidad()
    {
        $_SESSION['carrito'] = $_SESSION['carrito'] ?? [];
        $clave = $_POST['clave'] ?? null;
        $cantidad = $_POST['cantidad'] ?? null;
        if ($clave !== null && isset($_SESSION['carrito'][$clave])) {
            // Limitar la cantidad entre 1 y 99
            $cantidad = max(1, min(99, (int) $cantidad));
            $_SESSION['carrito'][$clave]['cantidad'] = $cantidad;
            $_SESSION['aviso'] = "Cantidad actualizada.";
        } else {
            $_SESSION['aviso'] = "No se pudo actualizar la cantidad.";
        }
        $this->redirigir("index.php?controller=carrito");
    }

    public function quitar()
    {
        // TODO lógica

        $clave = $_POST['clave'] ?? null;
        if ($clave !== null && isset($_SESSION['carrito'][$clave])) {
            unset($_SESSION['carrito'][$clave]);
            $_SESSION['aviso'] = "Línea eliminada del carrito.";
        } else {
            $_SESSION['aviso'] = "No se pudo eliminar la línea del carrito.";
        }
        $this->redirigir("index.php?controller=carrito");
    }


    public function aplicarCodigo()
    {
        $codigo = trim($_POST['codigo'] ?? '');
        if ($this->buscarCodigo($codigo)) {
            $_SESSION['codigo'] = $codigo;
            $_SESSION['aviso'] = "Código promocional aplicado: $codigo";

        } else {
            $_SESSION['aviso'] = "Código promocional inválido o caducado: $codigo";
            unset($_SESSION['codigo']);

        }
        $this->redirigir("index.php?controller=carrito");
    }

    private function buscarCodigo($codigo)
    {
        foreach (OfertasDAO::getCodigosActivos() as $oferta) {
            // strcasecmp compara sin mirar mayúsculas: "uni10" vale igual que "UNI10"
            if (strcasecmp($oferta->getCodigo(), $codigo) === 0) {
                return $oferta;
            }
        }
        return null;
    }


    public function datosPago()
    {
        // TODO lógica

    }


    public function confirmar()
    {
        // TODO lógica


    }


    private function calcularTotales($carrito)
    {
        $codigo = $_SESSION['codigo'] ?? null;
        $subtotal = 0;
        foreach ($carrito as $linea) {
            $subtotal += (float) $linea['precio_unitario'] * $linea['cantidad'];
        }
        $iva = $subtotal - ($subtotal / 1.10);
        // Envío gratis si el subtotal supera 50, de lo contrario 5
        $envio = $subtotal > 50 ? 0 : 5;
        $subtotal = $subtotal / 1.10;

        $descuento = 0;
        if (isset($codigo)) {
            $oferta = $this->buscarCodigo($codigo);
            if ($oferta) {
                $descuento = ($subtotal+$iva) * $oferta->getValor() / 100;
            }
        }

        $total = $subtotal +$iva+ $envio - $descuento;

        return [
            'subtotal' => $subtotal,
            'iva' => $iva,
            'envio' => $envio,
            'descuento' => $descuento,
            'total' => $total
        ];
    }
    private function redirigir($ruta)
    {
        header("Location: " . url . $ruta);
        exit();
    }
}

?>
