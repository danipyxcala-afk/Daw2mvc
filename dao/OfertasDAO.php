<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Ofertas.php");
include_once(__DIR__ . "/../modelos/OfertaProducto.php");
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
        while ($oferta = $result->fetch_object("Ofertas")) {
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

        $oferta = $result->fetch_object("Ofertas");
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
        $fecha_inicio = $oferta->getFechaInicio();
        $fecha_fin = $oferta->getFechaFin();
        $activa = $oferta->getActiva();
        // Asignamos los valores a los parámetros de la consulta el sssdsssi significa string string string double string string string int
        $stmt->bind_param("sssdsssi", $nombre, $descripcion, $tipo, $valor, $codigo, $fecha_inicio, $fecha_fin, $activa);
        // Ejecutamos la consulta
        $stmt->execute();
        // Guardamos el id nuevo ANTES de cerrar la conexión (la API lo devuelve)
        $id = $con->insert_id;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $id;
    }
    public static function delete($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM ofertas WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Filas borradas (0 = no existía)
        $filas = $stmt->affected_rows;
        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
    }

    public static function update($oferta)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE ofertas SET nombre = ?, descripcion = ?, tipo = ?, valor = ?, codigo = ?, fecha_inicio = ?, fecha_fin = ?, activa = ? WHERE id = ?");
        // Obtenemos los valores del objeto oferta
        $nombre = $oferta->getNombre();
        $descripcion = $oferta->getDescripcion();
        $tipo = $oferta->getTipo();
        $valor = $oferta->getValor();
        $codigo = $oferta->getCodigo();
        $fecha_inicio = $oferta->getFechaInicio();
        $fecha_fin = $oferta->getFechaFin();
        $activa = $oferta->getActiva();
        $id = $oferta->getId();
        // sssdsssii = los 8 del insert + el id del WHERE al final
        $stmt->bind_param("sssdsssii", $nombre, $descripcion, $tipo, $valor, $codigo, $fecha_inicio, $fecha_fin, $activa, $id);
        $stmt->execute();
        // Filas cambiadas (ojo: da 0 si se guardan los mismos datos que ya tenía)
        $filas = $stmt->affected_rows;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
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
        while ($producto = $result->fetch_object("OfertaProducto")) {
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
        $oferta_id = $oferta_producto->getOfertaId();
        $producto_id = $oferta_producto->getProductoId();
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
        // Filas borradas (0 = no existía)
        $filas = $stmt->affected_rows;
        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
    }


    //  Métodos para la API (devuelven arrays para json_encode)
    //  json_encode no ve los atributos protected de los objetos (saldría {}), por eso fetch_assoc

    public static function getAllJson()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos (cada fila es un array asociativo)
        $ofertas = [];
        while ($oferta = $result->fetch_assoc()) {
            $ofertas[] = $oferta;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ofertas;
    }

    public static function getByIdJson($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ofertas WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $oferta = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $oferta ?: null;
    }
}
