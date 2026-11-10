<?php
class Usuarios
{
    protected $id;
    protected $nombre;
    protected $email;
    protected $password;
    protected $telefono;
    protected $direccion;
    protected $fecha_nacimiento;
    protected $rol;
    protected $fecha_registro;

    public function __construct(
        $id = null,
        $nombre = null,
        $email = null,
        $password = null,
        $telefono = null,
        $direccion = null,
        $fecha_nacimiento = null,
        $rol = null,
        $fecha_registro = null
    ) {
        // Asignamos los valores a las propiedades del objeto solo si no son nulos
        if ($id !== null) {
            $this->id = $id;
        }
        if ($nombre !== null) {
            $this->nombre = $nombre;
        }
        if ($email !== null) {
            $this->email = $email;
        }
        if ($password !== null) {
            $this->password = $password;
        }
        if ($telefono !== null) {
            $this->telefono = $telefono;
        }
        if ($direccion !== null) {
            $this->direccion = $direccion;
        }
        if ($fecha_nacimiento !== null) {
            $this->fecha_nacimiento = $fecha_nacimiento;
        }
        if ($rol !== null) {
            $this->rol = $rol;
        }else{
            $this->rol = 'usuario'; // Valor por defecto para el rol
        }
        if ($fecha_registro !== null) {
            $this->fecha_registro = $fecha_registro;
        }
    }

    /**
     * Get the value of fecha_registro
     */
    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    /**
     * Set the value of fecha_registro
     *
     * @return  self
     */
    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of fecha_nacimiento
     */
    public function getFechaNacimiento()
    {
        return $this->fecha_nacimiento;
    }

    /**
     * Set the value of fecha_nacimiento
     *
     * @return  self
     */
    public function setFechaNacimiento($fecha_nacimiento)
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

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


}
?>