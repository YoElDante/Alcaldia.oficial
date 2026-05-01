<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RateLimitFilter implements FilterInterface
{
    private const WINDOW_SECONDS = 900;
    private const MAX_ATTEMPTS = 5;

    public function before(RequestInterface $request, $arguments = null)
    {
        $ip = $request->getIPAddress();
        $cache = cache();
        $key = 'rate_login_' . sha1($ip);

        $attempts = (int) ($cache->get($key) ?? 0);
        if ($attempts >= self::MAX_ATTEMPTS) {
            return service('response')
                ->setStatusCode(429)
                ->setBody('Demasiados intentos. Intenta nuevamente en 15 minutos.');
        }

        $cache->save($key, $attempts + 1, self::WINDOW_SECONDS);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
