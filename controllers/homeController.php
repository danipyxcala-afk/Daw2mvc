<?php
class homeController
{
    function index()
    {
        $view = "views/inicio/home.php";
        include_once 'views/main.php';
    }
}
?>