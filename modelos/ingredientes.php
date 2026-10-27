<?php
class Ingredientes
{
    protected $id;
    protected $nombre;
    protected $precio_extra;
    protected $activo;

    public function __construct(
        $id = null,
        $nombre = null,
        $precio_extra = null,
        $activo = null
    ) {
        if ($id !== null) {
            $this->id = $id;
        }
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        if ($precio_extra !== null) {
            $this->precio_extra = $precio_extra;
        }
        if ($activo !== null) {
            $this->activo = $activo;
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
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
     * Get the value of activo
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of activo
     *
     * @return  self
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

}
?>