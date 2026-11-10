<?php
class OfertaProducto
{
    protected $oferta_id;
    protected $producto_id;

    public function __construct(
        $oferta_id = null,
        $producto_id = null
    ) {
        if ($oferta_id !== null) {
            $this->oferta_id = $oferta_id;
        }
        if ($producto_id !== null) {
            $this->producto_id = $producto_id;
        }
    }

    /**
     * Get the value of oferta_id
     */
    public function getOfertaId()
    {
        return $this->oferta_id;
    }

    /**
     * Set the value of oferta_id
     *
     * @return  self
     */
    public function setOfertaId($oferta_id)
    {
        $this->oferta_id = $oferta_id;

        return $this;
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

}
?>