<?php
/**
 * Servicio de firma y validacion de tokens de descarga.
 * Genera tokens HMAC-SHA256 con expiracion de 5 minutos para URLs de descarga.
 * Variable de entorno requerida: encryption.key (clave de firma del servidor).
 * Dependencias: extension hash de PHP (nativa).
 */

namespace App\Services;

class TokenService
{
    /** Tiempo de vida del token de descarga en segundos (5 minutos). */
    private const TOKEN_TTL = 300;

    /**
     * Firma un payload arbitrario con HMAC-SHA256.
     * @param string $payload Contenido a firmar.
     * @param string $secret  Clave secreta de firma.
     * @return string Firma hexadecimal.
     */
    public function sign(string $payload, string $secret): string
    {
        return hash_hmac('sha256', $payload, $secret);
    }

    /**
     * Genera un token de descarga firmado con expiracion de 5 minutos.
     * Devuelve un array con 'exp' (timestamp de expiracion) y 'token' (firma HMAC).
     * El receptor debe incluir ambos valores en la URL de descarga.
     * @param string $fileName Nombre exacto del archivo a descargar.
     * @return array{exp: int, token: string} Datos del token.
     */
    public function generateDownloadToken(string $fileName): array
    {
        $exp    = time() + self::TOKEN_TTL;
        $secret = $this->resolveSecret();
        $sig    = hash_hmac('sha256', $fileName . '|' . $exp, $secret);

        return ['exp' => $exp, 'token' => $sig];
    }

    /**
     * Valida la firma y vigencia de un token de descarga.
     * Rechaza tokens expirados y firmas invalidas.
     * @param string $fileName Nombre del archivo solicitado.
     * @param int    $exp      Timestamp de expiracion del token.
     * @param string $token    Firma HMAC recibida en la URL.
     * @return bool true si el token es valido y no expiro.
     */
    public function validateDownloadToken(string $fileName, int $exp, string $token): bool
    {
        // Rechazar si el token ya expiro
        if (time() > $exp) {
            return false;
        }

        $secret   = $this->resolveSecret();
        $expected = hash_hmac('sha256', $fileName . '|' . $exp, $secret);

        // Comparacion en tiempo constante para evitar ataques de timing
        return hash_equals($expected, $token);
    }

    /**
     * Resuelve la clave secreta de firma desde la variable de entorno.
     * Lanza excepcion si la clave no esta configurada (nunca debe usarse el default en produccion).
     * @return string Clave secreta de firma.
     */
    private function resolveSecret(): string
    {
        $key = env('encryption.key', '');
        if (! is_string($key) || trim($key) === '') {
            throw new \RuntimeException('Clave de firma no configurada. Definir encryption.key en .env');
        }

        return $key;
    }
}
