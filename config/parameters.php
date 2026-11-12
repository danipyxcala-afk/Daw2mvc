<?php
// La URL base se calcula sola: sirve igual en XAMPP, en WSL (localhost:8080) y en el servidor
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$carpeta = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
define("url", $protocolo . "://" . $_SERVER['HTTP_HOST'] . $carpeta);
define("default_controller", "productos");
define("default_action", "index");

$_SESSION['aviso'] = null; //Variable que muestra errores en todas las pantallas esta en main principalmente
$_SESSION['usuario'] = null; //variable que controla el login de user
$_SESSION['carrito'] = []; //Variable que controla el carrito

?>
