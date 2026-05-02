<?php
/**
 * Utilidades de normalización de URIs públicas del sitio.
 * Elimina el prefijo index.php/ que puede aparecer en servidores mal configurados
 * o en enlaces generados antes de limpiar el indexPage en App.php.
 * Dependencias: ninguna; lógica pura de string.
 */

namespace App\Services;

class UriService
{
    /**
     * Normaliza una ruta pública eliminando el prefijo index.php si está presente.
     *
     * @param string $path Ruta sin slash inicial ni final.
     * @return string Ruta limpia sin el prefijo index.php.
     */
    public static function normalizePublicPath(string $path): string
    {
        if (str_starts_with($path, 'index.php/')) {
            return substr($path, strlen('index.php/'));
        }

        if ($path === 'index.php') {
            return '';
        }

        return $path;
    }
}
