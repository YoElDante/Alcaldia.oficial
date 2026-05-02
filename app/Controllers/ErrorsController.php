<?php
/**
 * Controlador de errores HTTP del sitio público.
 * Maneja la página 404 personalizada con la URL solicitada como contexto.
 * Dependencias: UriService (normalización de ruta), helper base_url() de CI4,
 * vista errors/html/error_404.
 */

namespace App\Controllers;

use App\Services\UriService;

class ErrorsController extends BaseController
{
    /**
     * Renderiza la vista 404 con la URL pública que no fue encontrada.
     *
     * @return string HTML renderizado de la vista de error.
     */
    public function notFound(): string
    {
        $path = trim($this->request->getUri()->getPath(), '/');
        $path = UriService::normalizePublicPath($path);

        return view('errors/html/error_404', [
            'urlNoEncontrada' => base_url($path),
        ]);
    }
}
