<?php

class loginController
{
    public function index()
    {
        $view = "views/PanelUsuario/login.php";
        include_once 'views/main.php';
    }
    public function registro()
    {
        $view = "views/PanelUsuario/registro.php";
        include_once 'views/main.php';
    }
    public function login(){
        
    }
}

?>