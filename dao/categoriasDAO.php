<?php
include_once(__DIR__ . "/../config/database.php");
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
        while ($categoria = $result->fetch_object("categorias")) {
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

        $categoria = $result->fetch_object("categorias");
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

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM categorias WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

}
?>
