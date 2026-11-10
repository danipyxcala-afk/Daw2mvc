<?php
define("url", "http://localhost/php/segundo/Daw2mvc/");
define("default_controller", "productos");
define("default_action", "index");

$_SESSION['aviso'] = null; //Variable que muestra errores en todas las pantallas esta en main principalmente
$_SESSION['usuario'] = null; //variable que controla el login de user
$_SESSION['carrito'] = null; //Variable que controla el carrito

?>