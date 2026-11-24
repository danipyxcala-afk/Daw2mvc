<?php
include_once(__DIR__ . "/../modelos/Usuarios.php");
include_once(__DIR__ . "/../dao/UsuariosDAO.php");
include_once(__DIR__ . "/../dao/PedidosDAO.php");
include_once(__DIR__ . "/../dao/OfertasDAO.php");

class UserController
{

    //pantalla inicial
    public function index()
    {   // Si el usuario ya ha iniciado sesión, redirigir a la página de usuario
        if (isset($_SESSION['usuario'])) {
            $this->puser();
            exit();
        } else {
            $this->plogin();
            exit();
        }
    }

    //Muestra la pantalla de login
    public function plogin()
    {
        $view = "views/usuario/login.php";
        include_once 'views/main.php';
    }

    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url . "index.php?controller=user&action=plogin");
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        // Obtener el usuario por correo electrónico
        $usuario = UsuariosDAO::getByEmail($email);

        if ($usuario && password_verify($password, $usuario->getPassword())) {
            session_regenerate_id(true);
            $usuario->setPassword(null);
            $_SESSION['usuario'] = $usuario;
            header("Location: " . url . "index.php?controller=user&action=puser");
        } else {
            $_SESSION['aviso'] = "Credenciales inválidas. Por favor, inténtalo de nuevo.";
            header("Location: " . url . "index.php?controller=user&action=plogin");
        }
        exit();

    }

    //muestra la pantalla de registro
    public function pregistro()
    {
        $view = "views/usuario/registro.php";
        include_once 'views/main.php';
    }

    public function registro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->pregistro();
            exit();
        }
        $errores = [];

        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $telefono = trim($_POST['telefono'] ?? '') ?: null;
        $direccion = trim($_POST['direccion'] ?? '') ?: null;
        $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '') ?: null;

        //verificador de que los campos obligatorios este filled
        if ($nombre === '' || mb_strlen($nombre) > 100) {
            $errores[] = "El nombre es obligatorio y debe tener como máximo 100 caracteres";
        }
        if (strlen($password) < 8) {
            $errores[] = "La contraseña debe tener al menos 8 caracteres";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $errores[] = "El email no es válido";
        }
        if ($telefono !== null && !preg_match('/^[0-9 +]{6,20}$/', $telefono)) {
            $errores[] = "El teléfono no es válido";
        }
        if ($fecha_nacimiento !== null && $fecha_nacimiento > date('Y-m-d')) {
            $errores[] = "La fecha de nacimiento no puede ser posterior al día de hoy";
        }

        if (count($errores) > 0) {
            $_SESSION['aviso'] = implode(' ', $errores);
            $this->pregistro();
            exit();
        }

        // Verificar si el usuario ya existe antes de registrarlo
        if (UsuariosDAO::getByEmail($email)) {
            $_SESSION['aviso'] = "El usuario ya existe. Por favor, inicia sesión";
            // Redirigir a la pantalla de login
            header("Location: " . url . "index.php?controller=user&action=plogin");
            exit();
        }
        // Codificar la contraseña antes de enviarla al DAO
        $passwordCodificada = password_hash($password, PASSWORD_DEFAULT);
        $usuario = new Usuarios(null, $nombre, $email, $passwordCodificada, $telefono, $direccion, $fecha_nacimiento);
        // Llamar al método insert del DAO para guardar el usuario en la base de datos
        UsuariosDAO::insert($usuario);

        $_SESSION['aviso'] = "Cuenta creada. Ya puedes iniciar sesion.";
        // Después de registrar al usuario, redirigir a la pantalla de login
        header("Location: " . url . "index.php?controller=user&action=plogin");
        exit();

    }
    //pantalla de usuario y cargar registro de compras del usuario
    public function puser()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: " . url . "index.php?controller=user&action=plogin");
            exit();
        }

        $pedidos = PedidosDAO::getPedidosByUsuario($_SESSION['usuario']->getId());
        // Array para almacenar los detalles de cada pedido y un resumen de los pedidos
        $detalles = [];
        $resumen = ['num' => count($pedidos), 'gastado' => 0, 'ultimo' => $pedidos ? $pedidos[0]->getEstado() : null];
        // Calcular el total gastado y obtener los detalles de cada pedido
        foreach ($pedidos as $pedido) {
            if ($pedido->getEstado() !== 'cancelado') {
                $resumen['gastado'] += (float) $pedido->getTotal();
            }
            // Obtener los detalles de cada pedido y sus modificaciones
            foreach (PedidosDAO::getDetalle($pedido->getId()) as $linea) {
                // Obtener las modificaciones de cada línea del pedido, excluyendo los ingredientes incluidos
                $mods = array_filter(
                    PedidosDAO::getIngredientesDetalle($linea->getId()),
                    fn($i) => $i->getAccion() !== 'incluido'
                );
                // Guardar los detalles y modificaciones en un array asociativo para cada pedido
                $detalles[$pedido->getId()][] = ['linea' => $linea, 'mods' => $mods];
            }
        }

        $view = "views/usuario/panel.php";
        include_once 'views/main.php';
    }
    public function logout()
    {
        // Cerrar sesión y redirigir al inicio
        unset($_SESSION['usuario']);
        session_regenerate_id(true);
        $_SESSION['aviso'] = "Has cerrado sesión correctamente.";
        header("Location: " . url . "index.php?controller=home");
        exit();
    }
    public function actualizarDatos()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . url . "index.php?controller=user&action=puser");
            exit();
        }
        if (!isset($_SESSION['usuario'])) {
            header("Location: " . url . "index.php?controller=user&action=plogin");
            exit();
        }

        $telefono = trim($_POST['telefono'] ?? '') ?: null;
        $email = trim($_POST['email'] ?? '') ?: null;
        $fechaNacimiento = trim($_POST['fechaNacimiento'] ?? '') ?: null;
        $direccion = trim($_POST['direccion'] ?? '') ?: null;

        $errores = [];
        //verificador de que los campos obligatorios este filled
        $password = $_POST['password'] ?? '';
        if ($password !== '' && strlen($password) < 8) {
            $errores[] = "La contraseña debe tener al menos 8 caracteres";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $errores[] = "El email no es válido";
        }
        $otro = UsuariosDAO::getByEmail($email);
        if ($otro && $otro->getId() != $_SESSION['usuario']->getId()) {
            $errores[] = "Ese email ya lo usa otra cuenta";
        }
        if ($telefono !== null && !preg_match('/^[0-9 +]{6,20}$/', $telefono)) {
            $errores[] = "El teléfono no es válido";
        }
        if ($fechaNacimiento !== null && $fechaNacimiento > date('Y-m-d')) {
            $errores[] = "La fecha de nacimiento no puede ser posterior al día de hoy";
        }

        if (count($errores) > 0) {
            $_SESSION['aviso'] = implode(' ', $errores);
            header("Location: " . url . "index.php?controller=user&action=puser");
            exit();
        }

        $_SESSION['usuario']->setEmail($email);
        $_SESSION['usuario']->setTelefono($telefono);
        $_SESSION['usuario']->setDireccion($direccion);
        $_SESSION['usuario']->setFechaNacimiento($fechaNacimiento);

        UsuariosDAO::update($_SESSION['usuario']);
        if ($password !== '') {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            UsuariosDAO::updatePassword($_SESSION['usuario']->getId(), $hash);
        }

        $_SESSION['aviso'] = "Usuario actualizado";
        header("Location: " . url . "index.php?controller=user&action=puser");
        exit();
    }
}
