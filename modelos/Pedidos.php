<?php
class Pedidos
{
    protected $id;
    protected $usuario_id;
    protected $estado;
    protected $fecha_pedido;
    protected $subtotal;
    protected $descuento;
    protected $total;
    protected $metodo_pago;
    protected $estado_pago;

    public function __construct(
        $id = null,
        $usuario_id = null,
        $estado = null,
        $fecha_pedido = null,
        $subtotal = null,
        $descuento = null,
        $total = null,
        $metodo_pago = null,
        $estado_pago = null
    ) {
        if ($id !== null) {
            $this->id = $id;
        }
        if ($usuario_id !== null) {
            $this->usuario_id = $usuario_id;
        }
        if ($estado !== null) {
            $this->estado = $estado;
        }
        if ($fecha_pedido !== null) {
            $this->fecha_pedido = $fecha_pedido;
        }
        if ($subtotal !== null) {
            $this->subtotal = $subtotal;
        }
        if ($descuento !== null) {
            $this->descuento = $descuento;
        }
        if ($total !== null) {
            $this->total = $total;
        }
        if ($metodo_pago !== null) {
            $this->metodo_pago = $metodo_pago;
        }
        if ($estado_pago !== null) {
            $this->estado_pago = $estado_pago;
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
     * Get the value of usuario_id
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * Set the value of usuario_id
     *
     * @return  self
     */
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get the value of fecha_pedido
     */
    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    /**
     * Set the value of fecha_pedido
     *
     * @return  self
     */
    public function setFechaPedido($fecha_pedido)
    {
        $this->fecha_pedido = $fecha_pedido;

        return $this;
    }

    /**
     * Get the value of subtotal
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Set the value of subtotal
     *
     * @return  self
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    /**
     * Get the value of descuento
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set the value of descuento
     *
     * @return  self
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get the value of total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of total
     *
     * @return  self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get the value of metodo_pago
     */
    public function getMetodoPago()
    {
        return $this->metodo_pago;
    }

    /**
     * Set the value of metodo_pago
     *
     * @return  self
     */
    public function setMetodoPago($metodo_pago)
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    /**
     * Get the value of estado_pago
     */
    public function getEstadoPago()
    {
        return $this->estado_pago;
    }

    /**
     * Set the value of estado_pago
     *
     * @return  self
     */
    public function setEstadoPago($estado_pago)
    {
        $this->estado_pago = $estado_pago;

        return $this;
    }

}
?>