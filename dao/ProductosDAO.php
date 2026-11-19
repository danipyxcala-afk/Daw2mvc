<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Hamburguesas.php");
include_once(__DIR__ . "/../modelos/Complementos.php");
include_once(__DIR__ . "/../modelos/Bebidas.php");
include_once(__DIR__ . "/../modelos/Postres.php");

// DAO de todos los productos (de cualquier categoría).
// Los DAO de cada categoría (HamburguesasDAO, BebidasDAO...) siguen sirviendo para la carta.
class ProductosDAO
{
    // Productos es abstracta (no se puede hacer new Productos ni fetch_object("Productos")),
    // así que según la categoría elegimos qué clase hija crear
    private const CLASES = [
        1 => "Hamburguesas",
        2 => "Complementos",
        3 => "Bebidas",
        4 => "Postres",
    ];

    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos ORDER BY categoria_id, id");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $productos = [];
        // fetch_assoc porque la clase (Hamburguesas, Bebidas...) depende de cada fila
        while ($fila = $result->fetch_assoc()) {
            $productos[] = self::crearProducto($fila);
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $productos;
    }

    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $fila = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $fila ? self::crearProducto($fila) : null;
    }

    public static function insert($producto)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, precio, imagen, activo) VALUES (?, ?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto producto
        $categoria_id = $producto->getCategoriaId();
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $imagen = $producto->getImagen();
        $activo = $producto->getActivo();
        // issdsi significa int string string double string int
        $stmt->bind_param("issdsi", $categoria_id, $nombre, $descripcion, $precio, $imagen, $activo);
        // Ejecutamos la consulta
        $stmt->execute();
        // Guardamos el id nuevo ANTES de cerrar la conexión (la API lo devuelve)
        $id = $con->insert_id;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $id;
    }

    public static function update($producto)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE productos SET categoria_id = ?, nombre = ?, descripcion = ?, precio = ?, imagen = ?, activo = ? WHERE id = ?");
        // Obtenemos los valores del objeto producto
        $categoria_id = $producto->getCategoriaId();
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $imagen = $producto->getImagen();
        $activo = $producto->getActivo();
        $id = $producto->getId();
        // issdsii = los 6 del insert + el id del WHERE al final
        $stmt->bind_param("issdsii", $categoria_id, $nombre, $descripcion, $precio, $imagen, $activo, $id);
        $stmt->execute();
        // Filas cambiadas (ojo: da 0 si se guardan los mismos datos que ya tenía)
        $filas = $stmt->affected_rows;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
    }

    public static function delete($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        // Ojo: si el producto está en algún pedido o tiene ingredientes, la clave ajena no deja borrarlo
        $stmt = $con->prepare("DELETE FROM productos WHERE id = ?");
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

    // Convierte una fila de la BBDD en el objeto de su clase (Hamburguesas, Bebidas...)
    private static function crearProducto($fila)
    {
        $clase = self::CLASES[$fila['categoria_id']];
        return new $clase(
            $fila['id'],
            $fila['categoria_id'],
            $fila['nombre'],
            $fila['descripcion'],
            $fila['precio'],
            $fila['imagen'],
            $fila['activo']
        );
    }

    //  Métodos para la API (devuelven arrays para json_encode)
    //  json_encode no ve los atributos protected de los objetos (saldría {}), por eso fetch_assoc

    public static function getAllJson()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos ORDER BY categoria_id, id");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos (cada fila es un array asociativo)
        $productos = [];
        while ($producto = $result->fetch_assoc()) {
            $productos[] = $producto;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $productos;
    }

    public static function getByIdJson($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $producto = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $producto ?: null;
    }
}
