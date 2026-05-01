<?php
/**
 * Controlador de descargas protegidas del portal.
 * Gestiona login por clave temporal, visualizacion de catalogo y descarga autenticada.
 * Variables clave: sesion descargas_auth y nombre de archivo solicitado.
 */

namespace App\Controllers;

class DescargasController extends BaseController
{
    /**
     * Muestra formulario de acceso por clave temporal.
     * @return string Vista de login.
     */
    public function index(): string
    {
        return view('descargas/login', [
            'error' => session()->getFlashdata('error'),
        ]);
    }

    /**
     * Valida clave temporal y habilita sesion de descargas.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function login(): \CodeIgniter\HTTP\RedirectResponse
    {
        $password = (string) $this->request->getPost('password');
        $service  = new \App\Services\ClaveTemporalService();

        if (! $service->validate($password)) {
            session()->setFlashdata('error', 'Clave invalida.');
            return redirect()->to('/descargas');
        }

        session()->regenerate();
        session()->set('descargas_auth', true);

        return redirect()->to('/descargas/panel');
    }

    /**
     * Muestra el panel con el catalogo de archivos disponibles.
     * Pre-formatea tamano y fecha, y genera URL firmada con token HMAC para cada archivo.
     * @return string Vista del panel.
     */
    public function panel(): string
    {
        $catalogService = new \App\Services\FileCatalogService();
        $tokenService   = new \App\Services\TokenService();
        $rawFiles       = $catalogService->listAvailableFiles();

        $files = $catalogService->enrichFilesForPanel($rawFiles, $tokenService);

        return view('descargas/panel', ['files' => $files]);
    }

    /**
     * Entrega archivo permitido como descarga con token HMAC firmado.
     * Valida firma y vigencia del token antes de servir el archivo.
     * @param string $fileName Nombre del archivo solicitado.
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function download(string $fileName): \CodeIgniter\HTTP\ResponseInterface
    {
        $token = (string) $this->request->getGet('token');
        $exp   = (int)    $this->request->getGet('exp');

        // Validar token HMAC antes de cualquier operacion de archivo
        $tokenService = new \App\Services\TokenService();
        if (! $tokenService->validateDownloadToken($fileName, $exp, $token)) {
            return $this->response->setStatusCode(403)->setBody('Enlace de descarga invalido o expirado.');
        }

        $catalogService = new \App\Services\FileCatalogService();
        $safePath       = $catalogService->resolveAllowedFile($fileName);

        if ($safePath === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Archivo no disponible.');
        }

        return $this->response
            ->download($safePath, null)
            ->setFileName($fileName);
    }

    /**
     * Cierra la sesion de descargas.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->remove('descargas_auth');
        session()->regenerate();

        return redirect()->to('/descargas');
    }
}
