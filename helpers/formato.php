<?php

// Da formato de precio: 12.5 -> 12,50€
function precio($valor)
{
    return number_format((float) $valor, 2, ',', '.') . '€';
}

// Escapa un texto para mostrarlo en HTML (evita que se cuele HTML o JavaScript)
function texto($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

// Igual que texto(), pero si está vacío (NULL en la BBDD) muestra una raya
function dato($valor)
{
    return ($valor === null || $valor === '') ? '—' : texto($valor);
}

// Da formato de fecha: '2026-11-14 18:30:00' -> 14/11/2026. Si está vacía muestra una raya
function fecha($fecha, $formato = 'd/m/Y')
{
    $marca = strtotime((string) $fecha);
    return $marca ? date($formato, $marca) : '—';
}

// Mes y año en español: '2026-09-03' -> septiembre de 2026 (PHP da el mes en inglés)
function mesAnio($fecha)
{
    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
              'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
    $marca = strtotime((string) $fecha);
    return $marca ? $meses[date('n', $marca) - 1] . ' de ' . date('Y', $marca) : '';
}
