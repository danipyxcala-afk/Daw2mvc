<?php
class oferta_producto
{
    private $oferta_id;
    private $producto_id;

    public function __construct(
        $oferta_id = null,
        $producto_id = null
    ) {
        $this->oferta_id = $oferta_id;
        $this->producto_id = $producto_id;
    }

    /**
     * Get the value of oferta_id
     */
    public function getOferta_id()
    {
        return $this->oferta_id;
    }

    /**
     * Set the value of oferta_id
     *
     * @return  self
     */
    public function setOferta_id($oferta_id)
    {
        $this->oferta_id = $oferta_id;

        return $this;
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

}
