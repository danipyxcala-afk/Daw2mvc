<?php


class AdminController
{
    public function index()
    {

        //check del rol del usuario
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() != 'admin') {
            $_SESSION['aviso'] = "Este usuario no tiene acceso al panel de administracion";
            header("Location: " . url . "index.php?controller=home");
            exit();

        }

        $view = "views/admin/panel.php";
        include_once 'views/main.php';
    }
}
