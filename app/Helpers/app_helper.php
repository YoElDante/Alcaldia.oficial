<?php

/* Funciones globales de apoyo para las vistas.
   Provee utilidades que no pertenecen a ningún controlador específico.
   Funciones: current_year().
   Cargado automáticamente vía Config/Autoload.php. */

if (! function_exists('current_year')) {
    /**
     * Retorna el año actual para uso en vistas.
     * Sin parámetros de entrada.
     * @return int Año de cuatro dígitos (ej. 2026).
     */
    function current_year(): int
    {
        return (int) date('Y');
    }
}
