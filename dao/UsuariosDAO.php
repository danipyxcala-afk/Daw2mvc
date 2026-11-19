<?php
include_once(__DIR__ . "/../config/DataBase.php");
include_once(__DIR__ . "/../modelos/Usuarios.php");

class UsuariosDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM usuarios");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $usuarios = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($usuario = $result->fetch_object("Usuarios")) {
            $usuarios[] = $usuario;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $usuarios;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuarios WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuario = $result->fetch_object("Usuarios");
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $usuario ?: null;

    }
    public static function getByEmail($email)
    {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_object("Usuarios");
        $stmt->close();
        $con->close();
        return $usuario ?: null;
    }

    public static function insert($usuario)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, email, password, telefono, direccion, fecha_nacimiento, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // Obtenemos los valores del objeto usuario
        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();
        $telefono = $usuario->getTelefono();
        $direccion = $usuario->getDireccion();
        $fecha_nacimiento = $usuario->getFechaNacimiento();
        $rol = $usuario->getRol();
        // Asignamos los valores a los parámetros de la consulta
        // "sssssss" indica los tipos de datos de los parámetros: s = string, d = double, i = integer
        $stmt->bind_param("sssssss", $nombre, $email, $password, $telefono, $direccion, $fecha_nacimiento, $rol);
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
        $stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
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

    // Actualiza los datos del usuario SIN tocar la contraseña (para eso está updatePassword)
    public static function update($usuario)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, direccion = ?, fecha_nacimiento = ?, rol = ? WHERE id = ?");
        // Obtenemos los valores del objeto usuario
        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $telefono = $usuario->getTelefono();
        $direccion = $usuario->getDireccion();
        $fecha_nacimiento = $usuario->getFechaNacimiento();
        $rol = $usuario->getRol();
        $id = $usuario->getId();
        // ssssssi significa 6 string + int (el id del WHERE)
        $stmt->bind_param("ssssssi", $nombre, $email, $telefono, $direccion, $fecha_nacimiento, $rol, $id);
        $stmt->execute();
        // Filas cambiadas (ojo: da 0 si se guardan los mismos datos que ya tenía)
        $filas = $stmt->affected_rows;

        // Cerramos la conexión
        $stmt->close();
        $con->close();

        return $filas;
    }

    // Cambia solo la contraseña. Recibe el hash ya hecho con password_hash()
    public static function updatePassword($id, $password)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        // si significa string int
        $stmt->bind_param("si", $password, $id);
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
        // Columnas escritas una a una para NO enviar el password (hash) en el JSON
        $stmt = $con->prepare("SELECT id, nombre, email, telefono, direccion, fecha_nacimiento, rol, fecha_registro FROM usuarios");
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos (cada fila es un array asociativo)
        $usuarios = [];
        while ($usuario = $result->fetch_assoc()) {
            $usuarios[] = $usuario;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $usuarios;
    }

    public static function getByIdJson($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        // Columnas escritas una a una para NO enviar el password (hash) en el JSON
        $stmt = $con->prepare("SELECT id, nombre, email, telefono, direccion, fecha_nacimiento, rol, fecha_registro FROM usuarios WHERE id = ?");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuario = $result->fetch_assoc();
        //Cerramos conexiones
        $stmt->close();
        $con->close();

        return $usuario ?: null;
    }
}
