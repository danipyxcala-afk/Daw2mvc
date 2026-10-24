<?php
class pedido_detalle
{
    private $id;
    private $pedido_id;
    private $producto_id;
    private $nombre_producto;
    private $precio_unitario;
    private $cantidad;
    private $subtotal;

    public function __construct(
        $id = null,
        $pedido_id = null,
        $producto_id = null,
        $nombre_producto = null,
        $precio_unitario = null,
        $cantidad = null,
        $subtotal = null
    ) {
        $this->id = $id;
        $this->pedido_id = $pedido_id;
        $this->producto_id = $producto_id;
        $this->nombre_producto = $nombre_producto;
        $this->precio_unitario = $precio_unitario;
        $this->cantidad = $cantidad;
        $this->subtotal = $subtotal;
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
    public function getPedido_id()
    {
        return $this->pedido_id;
    }

    /**
     * Set the value of pedido_id
     *
     * @return  self
     */
    public function setPedido_id($pedido_id)
    {
        $this->pedido_id = $pedido_id;

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

    /**
     * Get the value of nombre_producto
     */
    public function getNombre_producto()
    {
        return $this->nombre_producto;
    }

    /**
     * Set the value of nombre_producto
     *
     * @return  self
     */
    public function setNombre_producto($nombre_producto)
    {
        $this->nombre_producto = $nombre_producto;

        return $this;
    }

    /**
     * Get the value of precio_unitario
     */
    public function getPrecio_unitario()
    {
        return $this->precio_unitario;
    }

    /**
     * Set the value of precio_unitario
     *
     * @return  self
     */
    public function setPrecio_unitario($precio_unitario)
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
