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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordCodificada = password_hash($password, PASSWORD_DEFAULT); // Codificar la contraseña antes de enviarla al DAO
            $telefono = trim($_POST['telefono']) ?: null;
            $direccion = trim($_POST['direccion']) ?: null;
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?: null;
            // Verificar si el usuario ya existe antes de registrarlo
            if (UsuariosDAO::getByEmail($email)) {
                $_SESSION['aviso'] = "El usuario ya existe. Por favor, inicia sesión.";
                header("Location: " . url . "index.php?controller=user&action=plogin");
                exit();
            }
            $usuario = new Usuarios(null, $nombre, $email, $passwordCodificada, $telefono, $direccion, $fecha_nacimiento);
            // Llamar al método insert del DAO para guardar el usuario en la base de datos
            UsuariosDAO::insert($usuario);

            // Después de registrar al usuario, redirigir a la pantalla de login
            header("Location: " . url . "index.php?controller=user&action=plogin");
            exit();
        }
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
        // Obtener los códigos de descuento activos y filtrar el código de bienvenida si el usuario ya ha realizado pedidos
        $codigos = OfertasDAO::getCodigosActivos();
        if ($resumen['num'] > 0) {
            // Filtrar el código de bienvenida si el usuario ya ha realizado pedidos
            $codigos = array_filter($codigos, fn($c) => $c->getCodigo() !== 'BIENVENIDA15');
        }

        $view = "views/usuario/panel.php";
        include_once 'views/main.php';
    }
    public function logout()
    {
        unset($_SESSION['usuario']);
        session_regenerate_id(true);
        $_SESSION['aviso'] = "Has cerrado sesión correctamente.";
        header("Location: " . url . "index.php?controller=home");
        exit();
    }
}


?>