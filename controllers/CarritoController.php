<?php
//daos
include_once(__DIR__ . "/../dao/HamburguesasDAO.php");
include_once(__DIR__ . "/../dao/ComplementosDAO.php");
include_once(__DIR__ . "/../dao/BebidasDAO.php");
include_once(__DIR__ . "/../dao/PostresDAO.php");
include_once(__DIR__ . "/../dao/CategoriasDAO.php");
include_once(__DIR__ . "/../dao/IngredientesDAO.php");
include_once(__DIR__ . "/../dao/OfertasDAO.php");
include_once(__DIR__ . "/../dao/PedidosDAO.php");


//modelos
include_once(__DIR__ . "/../modelos/Hamburguesas.php");
include_once(__DIR__ . "/../modelos/Complementos.php");
include_once(__DIR__ . "/../modelos/Bebidas.php");
include_once(__DIR__ . "/../modelos/Postres.php");
include_once(__DIR__ . "/../modelos/Categorias.php");
include_once(__DIR__ . "/../modelos/Ofertas.php");
include_once(__DIR__ . "/../modelos/Pedidos.php");
include_once(__DIR__ . "/../modelos/PedidoDetalle.php");
include_once(__DIR__ . "/../modelos/PedidoDetalleIngrediente.php");

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

        if (!isset($_SESSION['usuario'])) {
            $_SESSION['aviso'] = "Debes iniciar sesión para continuar con el pago.";
            $this->redirigir("index.php?controller=user&action=plogin");
        }
        if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) === 0) {
            $_SESSION['aviso'] = "El carrito está vacío. Añade productos antes de continuar con el pago.";
            $this->redirigir("index.php?controller=productos&action=carta");
        }

        $lineas = $_SESSION['carrito'];
        $totales = $this->calcularTotales($lineas);
        $subtotal = $totales['subtotal'];
        $iva = $totales['iva'];
        $envio = $totales['envio'];
        $descuento = $totales['descuento'];
        $metodosPago = $this->getMetodosPago();
        $total = $totales['total'];

        $view = "views/carrito/pago.php";
        include_once 'views/main.php';

    }

    //Guarda el pedido, sus líneas y sus ingredientes en la BD y redirige a la confirmación
    public function confirmar()
    {
        //comprobaciones iniciales para que se pueda confirmar el pedido, si no se cumplen no puede hacer el pedido

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirigir("index.php?controller=carrito");
        }
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['aviso'] = "Debes iniciar sesión para continuar con el pago.";
            $this->redirigir("index.php?controller=user&action=plogin");
        }
        if (!isset($_SESSION['carrito']) || count($_SESSION['carrito']) === 0) {
            $_SESSION['aviso'] = "El carrito está vacío. Añade productos antes de continuar con el pago.";
            $this->redirigir("index.php?controller=productos&action=carta");
        }
        $metodoPago = $_POST['metodo_pago'] ?? null;
        if (!in_array($metodoPago, array_keys($this->getMetodosPago()))) {
            $_SESSION['aviso'] = "Método de pago inválido.";
            $this->redirigir("index.php?controller=carrito&action=datosPago");
        }

        $lineas = $_SESSION['carrito'];
        $totales = $this->calcularTotales($lineas);
        $subtotal = $totales['subtotal'] + $totales['iva'];
        $usuario = $_SESSION['usuario'];
        // se tiene que crear sin id porque lo asigna la bd
        $pedido = new Pedidos(null, $usuario->getId(), 'pendiente', null, $subtotal, $totales['descuento'], $totales['total'], $metodoPago, 'pagado');
        $pedidoId = PedidosDAO::insert($pedido);

        foreach ($lineas as $linea) {
            $detalle = new PedidoDetalle(null, $pedidoId, $linea['id'], $linea['nombre'], $linea['precio_unitario'], $linea['cantidad'], ($linea['precio_unitario'] * $linea['cantidad']));
            $detalleId = PedidosDAO::insertDetalle($detalle);
            foreach ($linea['quitados'] ?? [] as $quitado) {
                $ingrediente = new PedidoDetalleIngrediente(null, $detalleId, $quitado['id'], $quitado['nombre'], 0, 'quitado');
                PedidosDAO::insertIngredienteDetalle($ingrediente);
            }
            foreach ($linea['extras'] ?? [] as $extra) {
                $ingrediente = new PedidoDetalleIngrediente(null, $detalleId, $extra['id'], $extra['nombre'], $extra['precio_extra'], 'añadido');
                PedidosDAO::insertIngredienteDetalle($ingrediente);
            }
        }

        unset($_SESSION['carrito']);
        unset($_SESSION['codigo']);
        $_SESSION['aviso'] = "Pedido realizado correctamente!";

        $this->redirigir("index.php?controller=carrito&action=pedidoConfirmado&id=" . $pedidoId);
    }
    public function pedidoConfirmado()
    {
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['aviso'] = "Debes iniciar sesión para continuar con el pago.";
            $this->redirigir("index.php?controller=user&action=plogin");
        }
        $id = (int) ($_GET['id'] ?? 0);
        $pedido = PedidosDAO::getById($id);
        // Si el pedido NO existe, O no es de este usuario → fuera
        if (!$pedido || $pedido->getUsuarioId() != $_SESSION['usuario']->getId()) {
            $_SESSION['aviso'] = "Pedido no encontrado.";
            $this->redirigir("index.php?controller=user&action=puser");
        }

        $detalles = [];

        foreach (PedidosDAO::getDetalle($pedido->getId()) as $linea) {

            $mods = array_filter(
                PedidosDAO::getIngredientesDetalle($linea->getId()),
                fn($i) => $i->getAccion() !== 'incluido'
            );

            $detalles[] = ['linea' => $linea, 'mods' => $mods];
        }

        $view = "views/carrito/confirmacion.php";
        include_once 'views/main.php';
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
                $descuento = ($subtotal + $iva) * $oferta->getValor() / 100;
            }
        }

        $total = $subtotal + $iva + $envio - $descuento;

        return [
            'subtotal' => $subtotal,
            'iva' => $iva,
            'envio' => $envio,
            'descuento' => $descuento,
            'total' => $total
        ];
    }
    public function getMetodosPago()
    {
        return [
            'tarjeta' => 'Tarjeta',
            'efectivo' => 'Efectivo al recibir el pedido',
            'bizum' => 'Bizum',
        ];
    }

    private function redirigir($ruta)
    {
        header("Location: " . url . $ruta);
        exit();
    }
}
