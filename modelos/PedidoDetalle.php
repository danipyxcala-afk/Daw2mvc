<?php
class PedidoDetalle
{
    protected $id;
    protected $pedido_id;
    protected $producto_id;
    protected $nombre_producto;
    protected $precio_unitario;
    protected $cantidad;
    protected $subtotal;

    public function __construct(
        $id = null,
        $pedido_id = null,
        $producto_id = null,
        $nombre_producto = null,
        $precio_unitario = null,
        $cantidad = null,
        $subtotal = null
    ) {
        if ($id !== null) {
            $this->id = $id;
        }
        if ($pedido_id !== null) {
            $this->pedido_id = $pedido_id;
        }
        if ($producto_id !== null) {
            $this->producto_id = $producto_id;
        }
        if ($nombre_producto !== null) {
            $this->nombre_producto = $nombre_producto;
        }
        if ($precio_unitario !== null) {
            $this->precio_unitario = $precio_unitario;
        }
        if ($cantidad !== null) {
            $this->cantidad = $cantidad;
        }
        if ($subtotal !== null) {
            $this->subtotal = $subtotal;
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
     * Get the value of pedido_id
     */
    public function getPedidoId()
    {
        return $this->pedido_id;
    }

    /**
     * Set the value of pedido_id
     *
     * @return  self
     */
    public function setPedidoId($pedido_id)
    {
        $this->pedido_id = $pedido_id;

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

    /**
     * Get the value of nombre_producto
     */
    public function getNombreProducto()
    {
        return $this->nombre_producto;
    }

    /**
     * Set the value of nombre_producto
     *
     * @return  self
     */
    public function setNombreProducto($nombre_producto)
    {
        $this->nombre_producto = $nombre_producto;

        return $this;
    }

    /**
     * Get the value of precio_unitario
     */
    public function getPrecioUnitario()
    {
        return $this->precio_unitario;
    }

    /**
     * Set the value of precio_unitario
     *
     * @return  self
     */
    public function setPrecioUnitario($precio_unitario)
    {
        $this->precio_unitario = $precio_unitario;

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

}
?>