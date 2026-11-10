<?php include_once(__DIR__."/Productos.php");

class Bebidas extends Productos
{
    public function __construct(
        $id = null,
        $categoria_id = null,
        $nombre = null,
        $descripcion = null,
        $precio = null,
        $imagen = null,
        $activo = null
    ) {
        parent::__construct($id, $categoria_id, $nombre, $descripcion, $precio, $imagen, $activo);
    }
}
?>