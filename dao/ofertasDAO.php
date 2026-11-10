<?php
include_once(__DIR__ . "/../config/database.php");
include_once(__DIR__ . "/../modelos/ofertas.php");
include_once(__DIR__ . "/../modelos/oferta_producto.php");
class OfertasDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM ofertas");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $ofertas = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($oferta = $result->fetch_object("ofertas")) {
            $ofertas[] = $oferta;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ofertas;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $oferta = $result->fetch_object("ofertas");
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $oferta ?: null;

    }
    public static function insert($oferta)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO ofertas (nombre, descripcion, tipo, valor, codigo, fecha_inicio, fecha_fin, activa) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto oferta
        $nombre = $oferta->getNombre();
        $descripcion = $oferta->getDescripcion();
        $tipo = $oferta->getTipo();
        $valor = $oferta->getValor();
        $codigo = $oferta->getCodigo();
        $fecha_inicio = $oferta->getFecha_inicio();
        $fecha_fin = $oferta->getFecha_fin();
        $activa = $oferta->getActiva();
        // Asignamos los valores a los parámetros de la consulta el sssdsssi significa string string string double string string string int
        $stmt->bind_param("sssdsssi", $nombre, $descripcion, $tipo, $valor, $codigo, $fecha_inicio, $fecha_fin, $activa);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function delete($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM ofertas WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

    public static function getCodigosActivos()
    {
        $con = DataBase::connect();
        // Consulta para obtener los códigos de ofertas activas
        $stmt = $con->prepare("SELECT * FROM ofertas WHERE tipo = 'codigo' AND activa = 1 AND fecha_inicio <= NOW() AND (fecha_fin IS NULL OR fecha_fin >= NOW())");

        $stmt->execute();
        $result = $stmt->get_result();

        $codigos = [];
        while ($oferta = $result->fetch_object("Ofertas")) {
            $codigos[] = $oferta;
        }
        $stmt->close();
        $con->close();

        return $codigos;
    }

    //  Tabla oferta_producto 

    public static function getByOferta($oferta_id)
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM oferta_producto WHERE oferta_id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $oferta_id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $productos = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($producto = $result->fetch_object("oferta_producto")) {
            $productos[] = $producto;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $productos;
    }
    public static function insertProducto($oferta_producto)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO oferta_producto (oferta_id, producto_id) VALUES (?, ?)");
        // Obtenemos los valores del objeto oferta_producto
        $oferta_id = $oferta_producto->getOferta_id();
        $producto_id = $oferta_producto->getProducto_id();
        // Asignamos los valores a los parámetros de la consulta el ii significa int int
        $stmt->bind_param("ii", $oferta_id, $producto_id);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function deleteProducto($oferta_id, $producto_id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM oferta_producto WHERE oferta_id = ? AND producto_id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("ii", $oferta_id, $producto_id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

}
?>