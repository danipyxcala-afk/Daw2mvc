<?php
include_once(__DIR__ . "/../config/database.php");
include_once(__DIR__ . "/../modelos/usuarios.php");
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
        while ($usuario = $result->fetch_object("usuarios")) {
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

        $usuario = $result->fetch_object("usuarios");
        //Cerramos conexiones
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
        $fecha_nacimiento = $usuario->getFecha_nacimiento();
        $rol = $usuario->getRol();
        // Asignamos los valores a los parámetros de la consulta el sssssss significa string string string string string string string
        $stmt->bind_param("sssssss", $nombre, $email, $password, $telefono, $direccion, $fecha_nacimiento, $rol);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM usuarios WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

}
?>


