<?php
function prettier($array)
{

    echo '<pre>';
    print_r($array);
    echo "</pre>";
}


function prettierExit($array)
{

    echo '<pre>';
    print_r($array);
    echo "</pre>";
    exit;

}
function verSesion($clave = null)
{
    if ($clave === null) {
        prettier($_SESSION);
    } else {
        prettier($_SESSION[$clave] ?? 'No existe la clave ' . $clave);
    }
}
