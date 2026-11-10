<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Pedidos.php");
include_once(__DIR__ . "/../modelos/PedidoDetalle.php");
include_once(__DIR__ . "/../modelos/PedidoDetalleIngrediente.php");
class PedidosDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM pedidos");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $pedidos = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($pedido = $result->fetch_object("Pedidos")) {
            $pedidos[] = $pedido;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $pedidos;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM pedidos WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $pedido = $result->fetch_object("Pedidos");
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $pedido ?: null;

    }
    public static function insert($pedido)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO pedidos (usuario_id, estado, subtotal, descuento, total, metodo_pago, estado_pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto pedido
        $usuario_id = $pedido->getUsuarioId();
        $estado = $pedido->getEstado();
        $subtotal = $pedido->getSubtotal();
        $descuento = $pedido->getDescuento();
        $total = $pedido->getTotal();
        $metodo_pago = $pedido->getMetodoPago();
        $estado_pago = $pedido->getEstadoPago();
        // Asignamos los valores a los parámetros de la consulta el isdddss significa int string double double double string string
        $stmt->bind_param("isdddss", $usuario_id, $estado, $subtotal, $descuento, $total, $metodo_pago, $estado_pago);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM pedidos WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

        public static function getPedidosByUsuario($usuario_id)
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM pedidos WHERE usuario_id = ? order by fecha_pedido desc");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $usuario_id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $lineas = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($linea = $result->fetch_object("Pedidos")) {
            $lineas[] = $linea;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $lineas;
    }

    //  Tabla pedido_detalle 

    public static function getDetalle($pedido_id)
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM pedido_detalle WHERE pedido_id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $pedido_id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $lineas = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($linea = $result->fetch_object("PedidoDetalle")) {
            $lineas[] = $linea;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $lineas;
    }
    public static function insertDetalle($pedido_detalle)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO pedido_detalle (pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto pedido_detalle
        $pedido_id = $pedido_detalle->getPedidoId();
        $producto_id = $pedido_detalle->getProductoId();
        $nombre_producto = $pedido_detalle->getNombreProducto();
        $precio_unitario = $pedido_detalle->getPrecioUnitario();
        $cantidad = $pedido_detalle->getCantidad();
        $subtotal = $pedido_detalle->getSubtotal();
        // Asignamos los valores a los parámetros de la consulta el iisdid significa int int string double int double
        $stmt->bind_param("iisdid", $pedido_id, $producto_id, $nombre_producto, $precio_unitario, $cantidad, $subtotal);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function deleteDetalle($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM pedido_detalle WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

    //  Tabla pedido_detalle_ingrediente 

    public static function getIngredientesDetalle($pedido_detalle_id)
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM pedido_detalle_ingrediente WHERE pedido_detalle_id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $pedido_detalle_id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $ingredientes = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($ingrediente = $result->fetch_object("PedidoDetalleIngrediente")) {
            $ingredientes[] = $ingrediente;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ingredientes;
    }
    public static function insertIngredienteDetalle($pedido_detalle_ingrediente)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO pedido_detalle_ingrediente (pedido_detalle_id, ingrediente_id, nombre_ingrediente, precio_extra, accion) VALUES (?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto pedido_detalle_ingrediente
        $pedido_detalle_id = $pedido_detalle_ingrediente->getPedidoDetalleId();
        $ingrediente_id = $pedido_detalle_ingrediente->getIngredienteId();
        $nombre_ingrediente = $pedido_detalle_ingrediente->getNombreIngrediente();
        $precio_extra = $pedido_detalle_ingrediente->getPrecioExtra();
        $accion = $pedido_detalle_ingrediente->getAccion();
        // Asignamos los valores a los parámetros de la consulta el iisds significa int int string double string
        $stmt->bind_param("iisds", $pedido_detalle_id, $ingrediente_id, $nombre_ingrediente, $precio_extra, $accion);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function deleteIngredienteDetalle($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM pedido_detalle_ingrediente WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

}
?>
