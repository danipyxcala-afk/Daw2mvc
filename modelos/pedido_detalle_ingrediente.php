<?php
class pedido_detalle_ingrediente
{
    private $id;
    private $pedido_detalle_id;
    private $ingrediente_id;
    private $nombre_ingrediente;
    private $precio_extra;
    private $accion;

    public function __construct(
        $id = null,
        $pedido_detalle_id = null,
        $ingrediente_id = null,
        $nombre_ingrediente = null,
        $precio_extra = null,
        $accion = null
    ) {
        $this->id = $id;
        $this->pedido_detalle_id = $pedido_detalle_id;
        $this->ingrediente_id = $ingrediente_id;
        $this->nombre_ingrediente = $nombre_ingrediente;
        $this->precio_extra = $precio_extra;
        $this->accion = $accion;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of pedido_detalle_id
     */
    public function getPedido_detalle_id()
    {
        return $this->pedido_detalle_id;
    }

    /**
     * Set the value of pedido_detalle_id
     *
     * @return  self
     */
    public function setPedido_detalle_id($pedido_detalle_id)
    {
        $this->pedido_detalle_id = $pedido_detalle_id;

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
     * Get the value of nombre_ingrediente
     */
    public function getNombre_ingrediente()
    {
        return $this->nombre_ingrediente;
    }

    /**
     * Set the value of nombre_ingrediente
     *
     * @return  self
     */
    public function setNombre_ingrediente($nombre_ingrediente)
    {
        $this->nombre_ingrediente = $nombre_ingrediente;

        return $this;
    }

    /**
     * Get the value of precio_extra
     */
    public function getPrecio_extra()
    {
        return $this->precio_extra;
    }

    /**
     * Set the value of precio_extra
     *
     * @return  self
     */
    public function setPrecio_extra($precio_extra)
    {
        $this->precio_extra = $precio_extra;

        return $this;
    }

    /**
     * Get the value of accion
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set the value of accion
     *
     * @return  self
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

}
