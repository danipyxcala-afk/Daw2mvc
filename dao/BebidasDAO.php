<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Bebidas.php");
class BebidasDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM productos WHERE categoria_id = 3");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $bebidas = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($bebida = $result->fetch_object("Bebidas")) {
            $bebidas[] = $bebida;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $bebidas;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ? AND categoria_id = 3");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $producto = $result->fetch_object("Bebidas");
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $producto ?: null;

    }
    public static function insert($producto)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, precio, imagen, activo) VALUES (?, ?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto producto
        // Siempre la categoría de este DAO (bebidas), así no se puede guardar otra cosa por error
        $categoria_id = 3;
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $imagen = $producto->getImagen();
        $activo = $producto->getActivo();
        // Asignamos los valores a los parámetros de la consulta el issdsi significa int string string double string int
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
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM productos WHERE id = ? AND categoria_id = 3");
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

    public static function update($producto)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        // La categoría no se cambia aquí: este DAO solo trabaja con bebidas (categoría 3)
        $stmt = $con->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, activo = ? WHERE id = ? AND categoria_id = 3");
        // Obtenemos los valores del objeto producto
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $imagen = $producto->getImagen();
        $activo = $producto->getActivo();
        $id = $producto->getId();
        // ssdsii significa string string double string int int (el último es el id del WHERE)
        $stmt->bind_param("ssdsii", $nombre, $descripcion, $precio, $imagen, $activo, $id);
        $stmt->execute();
        // Filas cambiadas (ojo: da 0 si se guardan los mismos datos que ya tenía)
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
        $stmt = $con->prepare("SELECT * FROM productos WHERE categoria_id = 3");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos (cada fila es un array asociativo)
        $bebidas = [];
        while ($bebida = $result->fetch_assoc()) {
            $bebidas[] = $bebida;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $bebidas;
    }

    public static function getByIdJson($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ? AND categoria_id = 3");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $bebida = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $bebida ?: null;
    }
}
