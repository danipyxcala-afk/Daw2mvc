<?php
class ProductoIngrediente
{
    protected $producto_id;
    protected $ingrediente_id;
    protected $cantidad;

    public function __construct(
        $producto_id = null,
        $ingrediente_id = null,
        $cantidad = null
    ) {
        if ($producto_id !== null) {
            $this->producto_id = $producto_id;
        }
        if ($ingrediente_id !== null) {
            $this->ingrediente_id = $ingrediente_id;
        }
        if ($cantidad !== null) {
            $this->cantidad = $cantidad;
        }
    }

    /**
     * Get the value of producto_id
     */
    public function getProductoId()
    {
        return $this->producto_id;
    }

    /**
     * Set the value of producto_id
     *
     * @return  self
     */
    public function setProductoId($producto_id)
    {
        $this->producto_id = $producto_id;

        return $this;
    }

    /**
     * Get the value of ingrediente_id
     */
    public function getIngredienteId()
    {
        return $this->ingrediente_id;
    }

    /**
     * Set the value of ingrediente_id
     *
     * @return  self
     */
    public function setIngredienteId($ingrediente_id)
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