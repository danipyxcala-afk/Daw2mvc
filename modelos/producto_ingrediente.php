<?php
class Producto_ingrediente
{
    protected $producto_id;
    protected $ingrediente_id;
    protected $cantidad;

    public function __construct(
        $producto_id = null,
        $ingrediente_id = null,
        $cantidad = null
    ) {
        $this->producto_id = $producto_id;
        $this->ingrediente_id = $ingrediente_id;
        $this->cantidad = $cantidad;
    }

    /**
     * Get the value of producto_id
     */
    public function getProducto_id()
    {
        return $this->producto_id;
    }

    /**
     * Set the value of producto_id
     *
     * @return  self
     */
    public function setProducto_id($producto_id)
    {
        $this->producto_id = $producto_id;

        return $this;
    }

    /**
     * Get the value of ingrediente_id
     */
    public function getIngrediente_id()
    {
        return $this->ingrediente_id;
    }

    /**
     * Set the value of ingrediente_id
     *
     * @return  self
     */
    public function setIngrediente_id($ingrediente_id)
    {
        $this->ingrediente_id = $ingrediente_id;

        return $this;
    }

    /**
     * Get the value of cantidad
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     *
     * @return  self
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

}
?>