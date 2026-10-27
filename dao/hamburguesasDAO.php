<?php
include_once(__DIR__ . "/../config/database.php");
include_once(__DIR__ . "/../modelos/Hamburguesas.php");
class HamburguesasDAO
{
    public static function getAll()
    {
        //Conexion a BBDD + Consultas
        $con = DataBase::connect();
        //importante poner en mayus para que salga en rojo :3
        $stmt = $con->prepare("SELECT * FROM productos WHERE categoria_id = 1");
        // Esto asignara a cada ? el valor que queramos
        // $stmt->bind_param("i", $id);
        //Ejecuta la query
        $stmt->execute();
        $result = $stmt->get_result();

        // Creamos Array guardar datos
        $hamburguesas = [];
        //utilizamos fetch object par aque sepa de que clase tiene que utilizar el constructor
        while ($hamburguesa = $result->fetch_object("Hamburguesas")) {
            $hamburguesas[] = $hamburguesa;
        }
        //Cerramos conexiones
        $stmt->close();
        $con->close();
        return $hamburguesas;
    }
    public static function getById($id)
    {
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM productos WHERE id = ? AND categoria_id = 1");
        // Esto asignara a cada ? el valor que queramos
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $producto = $result->fetch_object("Hamburguesas");
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
        $categoria_id = $producto->getCategoria_id();
        $nombre = $producto->getNombre();
        $descripcion = $producto->getDescripcion();
        $precio = $producto->getPrecio();
        $imagen = $producto->getImagen();
        $activo = $producto->getActivo();
        // Asignamos los valores a los parámetros de la consulta el issdsi significa int string string double string int
        $stmt->bind_param("issdsi", $categoria_id, $nombre, $descripcion, $precio, $imagen, $activo);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM productos WHERE id = ? AND categoria_id = 1");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

}
?>
