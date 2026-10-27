<?php include_once("modelos/productos.php");

class Hamburgesas extends productos
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