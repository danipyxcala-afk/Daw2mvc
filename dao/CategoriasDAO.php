<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Categorias.php");
class CategoriasDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM categorias");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $categorias = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($categoria = $result->fetch_object("Categorias")) {
            $categorias[] = $categoria;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $categorias;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM categorias WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $categoria = $result->fetch_object("Categorias");
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $categoria ?: null;

    }
    public static function insert($categoria)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO categorias (nombre, descripcion, activa) VALUES (?, ?, ?)");
        // Obtenemos los valores del objeto categoria
        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $activa = $categoria->getActiva();
        // Asignamos los valores a los parámetros de la consulta el ssi significa string string int
        $stmt->bind_param("ssi", $nombre, $descripcion, $activa);
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
        $stmt = $con->prepare("DELETE FROM categorias WHERE id = ?");
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

    public static function update($categoria)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE categorias SET nombre = ?, descripcion = ?, activa = ? WHERE id = ?");
        // Obtenemos los valores del objeto categoria
        $nombre = $categoria->getNombre();
        $descripcion = $categoria->getDescripcion();
        $activa = $categoria->getActiva();
        $id = $categoria->getId();
        // ssii significa string string int int (el último es el id del WHERE)
        $stmt->bind_param("ssii", $nombre, $descripcion, $activa, $id);
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
        $stmt = $con->prepare("SELECT * FROM categorias");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos (cada fila es un array asociativo)
        $categorias = [];
        while ($categoria = $result->fetch_assoc()) {
            $categorias[] = $categoria;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $categorias;
    }

    public static function getByIdJson($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM categorias WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $categoria = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $categoria ?: null;
    }
}
