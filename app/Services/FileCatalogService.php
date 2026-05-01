<?php
/**
 * Servicio de catalogo de instaladores para la seccion de descargas.
 * Expone listado permitido y resolucion segura de rutas dentro de distribucion.
 * Variables clave: lista ALLOWED_FILES y ruta base configurada por entorno.
 */

namespace App\Services;

class FileCatalogService
{
    /** Lista de archivos autorizados para descarga y validacion estricta de solicitudes. */
    private const ALLOWED_FILES = [
        'ALCALDIA.rar',
        'GM_MenuBotones.exe',
        'RestauraExeEstable.exe',
        'Sistema_Alcaldia.exe',
    ];

    /**
     * Obtiene la version activa para compatibilidad con fases posteriores.
     * @return array{version:string,archivo:string}
     */
    public function getCurrentVersionInfo(): array
    {
        return [
            'version' => 'pendiente',
            'archivo' => 'pendiente',
        ];
    }

    /**
     * Devuelve el listado de archivos permitidos disponibles en disco.
     * @return array<int, array{name:string,size:int,modified:int}>
     */
    public function listAvailableFiles(): array
    {
        $basePath = $this->getDistributionPath();
        $files = [];

        foreach (self::ALLOWED_FILES as $fileName) {
            $fullPath = $basePath . DIRECTORY_SEPARATOR . $fileName;
            if (! is_file($fullPath)) {
                continue;
            }

            $files[] = [
                'name' => $fileName,
                'size' => (int) filesize($fullPath),
                'modified' => (int) filemtime($fullPath),
            ];
        }

        return $files;
    }

    /**
     * Enriquecer archivos para render del panel de descargas.
     * Agrega tamano/fecha formateados y URL firmada con token HMAC.
     * @param array<int, array{name:string,size:int,modified:int}> $files Listado crudo de archivos.
     * @param TokenService $tokenService Servicio de firma de tokens.
     * @return array<int, array{name:string,size:int,modified:int,size_formatted:string,modified_formatted:string,download_url:string}>
     */
    public function enrichFilesForPanel(array $files, TokenService $tokenService): array
    {
        return array_map(function (array $file) use ($tokenService): array {
            $tokenData = $tokenService->generateDownloadToken($file['name']);

            return array_merge($file, [
                'size_formatted'     => number_format($file['size'] / 1048576, 2, ',', '.') . ' MB',
                'modified_formatted' => date('d/m/Y H:i', $file['modified']),
                'download_url'       => site_url(
                    '/descargas/archivo/' . rawurlencode($file['name'])
                    . '?token=' . $tokenData['token']
                    . '&exp='   . $tokenData['exp']
                ),
            ]);
        }, $files);
    }

    /**
     * Resuelve la ruta absoluta de un archivo permitido.
     * @param string $fileName Nombre del archivo solicitado.
     * @return string|null Ruta absoluta o null si no es valido/existente.
     */
    public function resolveAllowedFile(string $fileName): ?string
    {
        if (! in_array($fileName, self::ALLOWED_FILES, true)) {
            return null;
        }

        $basePath = realpath($this->getDistributionPath());
        if ($basePath === false) {
            return null;
        }

        $resolvedPath = realpath($basePath . DIRECTORY_SEPARATOR . $fileName);
        if ($resolvedPath === false || ! is_file($resolvedPath)) {
            return null;
        }

        if (strncmp($resolvedPath, $basePath . DIRECTORY_SEPARATOR, strlen($basePath . DIRECTORY_SEPARATOR)) !== 0) {
            return null;
        }

        return $resolvedPath;
    }

    /**
     * Obtiene el directorio base de distribucion via env o valor por defecto.
     * @return string Ruta absoluta del directorio distribucion.
     */
    private function getDistributionPath(): string
    {
        $fromEnv = env('downloads.path');
        if (is_string($fromEnv) && trim($fromEnv) !== '') {
            return rtrim($fromEnv, "\\/");
        }

        return ROOTPATH . 'distribucion';
    }
}
