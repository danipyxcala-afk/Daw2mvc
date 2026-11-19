<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Ingredientes.php");
include_once(__DIR__ . "/../modelos/ProductoIngrediente.php");
class IngredientesDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM ingredientes");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $ingredientes = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($ingrediente = $result->fetch_object("Ingredientes")) {
            $ingredientes[] = $ingrediente;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ingredientes;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ingredientes WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ingrediente = $result->fetch_object("Ingredientes");
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $ingrediente ?: null;

    }
    public static function insert($ingrediente)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO ingredientes (nombre, precio_extra, activo) VALUES (?, ?, ?)");
        // Obtenemos los valores del objeto ingrediente
        $nombre = $ingrediente->getNombre();
        $precio_extra = $ingrediente->getPrecioExtra();
        $activo = $ingrediente->getActivo();
        // Asignamos los valores a los parámetros de la consulta el sdi significa string double int
        $stmt->bind_param("sdi", $nombre, $precio_extra, $activo);
        // Ejecutamos la consulta
        $stmt->execute();
        // Guardamos el id nuevo ANTES de cerrar la conexión (la API lo devuelve)
        $id = $con->insert_id;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $id;
    }
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM ingredientes WHERE id = ?");
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

    public static function update($ingrediente)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE ingredientes SET nombre = ?, precio_extra = ?, activo = ? WHERE id = ?");
        // Obtenemos los valores del objeto ingrediente
        $nombre = $ingrediente->getNombre();
        $precio_extra = $ingrediente->getPrecioExtra();
        $activo = $ingrediente->getActivo();
        $id = $ingrediente->getId();
        // sdii significa string double int int (el último es el id del WHERE)
        $stmt->bind_param("sdii", $nombre, $precio_extra, $activo, $id);
        $stmt->execute();
        // Filas cambiadas (ojo: da 0 si se guardan los mismos datos que ya tenía)
        $filas = $stmt->affected_rows;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
    }
    //  Tabla producto_ingrediente 

    public static function getByProducto($producto_id)
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM producto_ingrediente WHERE producto_id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $producto_id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $ingredientes = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($ingrediente = $result->fetch_object("ProductoIngrediente")) {
            $ingredientes[] = $ingrediente;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ingredientes;
    }
    // Ingredientes de un producto con su nombre y precio (para la pantalla de detalle).
    // Devuelve arrays porque mezcla datos de las dos tablas.
    public static function getDetalleByProducto($producto_id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare(
            "SELECT i.id, i.nombre, i.precio_extra, pi.cantidad
             FROM producto_ingrediente pi
             INNER JOIN ingredientes i ON i.id = pi.ingrediente_id
             WHERE pi.producto_id = ? AND i.activo = 1
             ORDER BY i.id"
        );
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ingredientes = [];
        while ($ingrediente = $result->fetch_assoc()) {
            $ingredientes[] = $ingrediente;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ingredientes;
    }
    public static function insertProducto($producto_ingrediente)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO producto_ingrediente (producto_id, ingrediente_id, cantidad) VALUES (?, ?, ?)");
        // Obtenemos los valores del objeto producto_ingrediente
        $producto_id = $producto_ingrediente->getProductoId();
        $ingrediente_id = $producto_ingrediente->getIngredienteId();
        $cantidad = $producto_ingrediente->getCantidad();
        // Asignamos los valores a los parámetros de la consulta el iid significa int int double
        $stmt->bind_param("iid", $producto_id, $ingrediente_id, $cantidad);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function deleteProducto($producto_id, $ingrediente_id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM producto_ingrediente WHERE producto_id = ? AND ingrediente_id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("ii", $producto_id, $ingrediente_id);
        $stmt->execute();
        // Filas borradas (0 = no existía)
        $filas = $stmt->affected_rows;
        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
    }

    public static function updateProducto($producto_ingrediente)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE producto_ingrediente SET cantidad = ? WHERE producto_id = ? AND ingrediente_id = ?");
        // Obtenemos los valores del objeto producto_ingrediente
        $cantidad = $producto_ingrediente->getCantidad();
        $producto_id = $producto_ingrediente->getProductoId();
        $ingrediente_id = $producto_ingrediente->getIngredienteId();
        // dii significa double int int
        $stmt->bind_param("dii", $cantidad, $producto_id, $ingrediente_id);
        $stmt->execute();
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
        $stmt = $con->prepare("SELECT * FROM ingredientes");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos (cada fila es un array asociativo)
        $ingredientes = [];
        while ($ingrediente = $result->fetch_assoc()) {
            $ingredientes[] = $ingrediente;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $ingredientes;
    }

    public static function getByIdJson($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM ingredientes WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ingrediente = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $ingrediente ?: null;
    }
}
