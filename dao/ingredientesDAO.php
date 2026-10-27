<?php
include_once("config/dataBase.php");
include_once("modelos/ingredientes.php");
include_once("modelos/producto_ingrediente.php");
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
        while ($ingrediente = $result->fetch_object("ingredientes")) {
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

        $ingrediente = $result->fetch_object("ingredientes");
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
        $precio_extra = $ingrediente->getPrecio_extra();
        $activo = $ingrediente->getActivo();
        // Asignamos los valores a los parámetros de la consulta el sdi significa string double int
        $stmt->bind_param("sdi", $nombre, $precio_extra, $activo);
        // Ejecutamos la consulta
        $stmt->execute();

        // Cerramos la conexión
        $stmt->close();
        $con->close();

    }
    public static function delete($id){
        //Conexion a BBDD + Consulta
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM ingredientes WHERE id = ?");
        // Asignamos el valor del parámetro de la consulta
        $stmt->bind_param("i", $id);
        $stmt->execute();
        // Cerramos la conexión
        $stmt->close();
        $con->close();
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
        while ($ingrediente = $result->fetch_object("producto_ingrediente")) {
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
        $producto_id = $producto_ingrediente->getProducto_id();
        $ingrediente_id = $producto_ingrediente->getIngrediente_id();
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
        // Cerramos la conexión
        $stmt->close();
        $con->close();
    }

}
?>
