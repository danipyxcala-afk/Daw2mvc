<?php
class PedidoDetalleIngrediente
{
    protected $id;
    protected $pedido_detalle_id;
    protected $ingrediente_id;
    protected $nombre_ingrediente;
    protected $precio_extra;
    protected $accion;

    public function __construct(
        $id = null,
        $pedido_detalle_id = null,
        $ingrediente_id = null,
        $nombre_ingrediente = null,
        $precio_extra = null,
        $accion = null
    ) {
        if ($id !== null) {
            $this->id = $id;
        }
        if ($pedido_detalle_id !== null) {
            $this->pedido_detalle_id = $pedido_detalle_id;
        }
        if ($ingrediente_id !== null) {
            $this->ingrediente_id = $ingrediente_id;
        }
        if ($nombre_ingrediente !== null) {
            $this->nombre_ingrediente = $nombre_ingrediente;
        }
        if ($precio_extra !== null) {
            $this->precio_extra = $precio_extra;
        }
        if ($accion !== null) {
            $this->accion = $accion;
        }
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
    public function getPedidoDetalleId()
    {
        return $this->pedido_detalle_id;
    }

    /**
     * Set the value of pedido_detalle_id
     *
     * @return  self
     */
    public function setPedidoDetalleId($pedido_detalle_id)
    {
        $this->pedido_detalle_id = $pedido_detalle_id;

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
     * Get the value of nombre_ingrediente
     */
    public function getNombreIngrediente()
    {
        return $this->nombre_ingrediente;
    }

    /**
     * Set the value of nombre_ingrediente
     *
     * @return  self
     */
    public function setNombreIngrediente($nombre_ingrediente)
    {
        $this->nombre_ingrediente = $nombre_ingrediente;

        return $this;
    }

    /**
     * Get the value of precio_extra
     */
    public function getPrecioExtra()
    {
        return $this->precio_extra;
    }

    /**
     * Set the value of precio_extra
     *
     * @return  self
     */
    public function setPrecioExtra($precio_extra)
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
?>