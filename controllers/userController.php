<?php
include_once(__DIR__ . "/../modelos/Usuarios.php");
include_once(__DIR__ . "/../dao/usuariosDAO.php");

class userController
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
        $view = "views/PanelUsuario/login.php";
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
        $view = "views/PanelUsuario/registro.php";
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
        $view = "views/PanelUsuario/user.php";
        include_once 'views/main.php';
    }

}

?>