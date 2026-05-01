# Arquitectura web en Donweb (PHP) para rutas y descargas

## Framework base: CodeIgniter 4

Este proyecto usa **CodeIgniter 4 (CI4)** como framework backend PHP.

- Version minima de PHP: 8.1 (Donweb ofrece hasta 8.4 - COMPATIBLE)
- Instalacion via Composer: `composer create-project codeigniter4/appstarter nombre-proyecto`
- Documentacion oficial: https://codeigniter.com/user_guide/
- Compatibilidad Donweb verificada en: docs/Definicion de proyecto/donweb-centro-ayuda-fuentes.md (seccion 6)

### Por que CI4 y no PHP custom
La arquitectura MVC que se proponia implementar desde cero (Router.php, Request.php, Response.php)
ya viene resuelta en CI4. Beneficios directos:
- Router integrado (reemplaza app/Core/Router.php)
- Filters integrados (reemplaza middlewares custom de auth y rate limit)
- Seguridad CSRF incluida
- Compatible con estructura de carpetas similar a la propuesta original

## 1) Contexto y objetivo
Este sitio hoy es una landing estatica y se quiere evolucionar a una web con rutas limpias:
- /pagos
- /tutoriales
- /descargas

El requerimiento mas urgente es /descargas:
- acceso con password
- permitir compartir clave temporal a clientes
- descargar version actual de la app de escritorio
- exponer tambien assets/imagenes de instalacion

## 2) ¿Es viable usar una estructura tipo MVC en PHP en Donweb?
Si, totalmente viable.
Donweb no te impide ordenar carpetas tipo MVC. Lo importante es que:
- exista un front controller (index.php)
- .htaccess redirija rutas al front controller
- el codigo de app quede fuera de publico cuando sea posible

## 3) Mapeo mental: Node/Express MVC -> CI4 (CodeIgniter 4)
Equivalencia sugerida:
- app.get('/ruta') -> app/Config/Routes.php de CI4
- controllers/ -> app/Controllers/ (igual que en CI4)
- services/ -> app/Services/ (carpeta custom dentro de app/)
- middlewares auth -> app/Filters/ (Filters de CI4)
- views (ejs/pug) -> app/Views/ (igual que en CI4)
- public/ -> public/ (css, js, imagenes - entry point de CI4)

## 4) Estructura de carpetas (CodeIgniter 4)
CI4 tiene estructura fija. Las carpetas del proyecto se alinean a ella:

proyecto-ci4/                  (raiz del proyecto, fuera de public_html si es posible)
- app/
  - Config/
    - Routes.php               (definicion de todas las rutas)
    - App.php                  (configuracion base)
  - Controllers/
    - Home.php
    - Descargas.php
    - Auth.php
    - Tutoriales.php
    - Pagos.php
  - Filters/
    - AuthFilter.php           (reemplaza middleware de auth custom)
    - RateLimitFilter.php      (reemplaza rate limit custom)
  - Models/
    - ClaveTemporalModel.php   (si se usa DB)
  - Services/                  (carpeta custom para logica de negocio)
    - FileCatalogService.php
    - TokenService.php
  - Views/
    - layouts/
    - home.php
    - descargas/
      - login.php
      - panel.php
    - tutoriales.php
    - pagos.php
- public/                      (UNICA carpeta expuesta al navegador)
  - assets/
  - css/
  - js/
  - index.php                  (front controller de CI4)
  - .htaccess
- storage/
  - releases/                  (version activa para descargar)
  - assets-instalacion/        (imagenes, extras)
  - logs/
- writable/                    (cache, logs propios de CI4 - NO exponer)
- vendor/                      (dependencias Composer - NO exponer)
- .env                         (variables de entorno - NO exponer)
- composer.json

Nota: si Donweb obliga todo dentro de public_html, solo `public/` va ahi.
El resto del proyecto vive un nivel arriba de public_html.

## 5) Routing base (CI4 Routes.php)
Rutas definidas en `app/Config/Routes.php`:

```php
$routes->get('/', 'Home::index');
$routes->get('/pagos', 'Pagos::index');
$routes->get('/tutoriales', 'Tutoriales::index');
$routes->get('/descargas', 'Descargas::index');
$routes->post('/descargas/login', 'Auth::login');
$routes->post('/descargas/logout', 'Auth::logout');
$routes->get('/descargas/files', 'Descargas::files');
$routes->get('/descargas/download', 'Descargas::download');  // ?f=...&t=...
```

Filtros de autenticacion aplicados en Routes.php:
```php
$routes->group('/descargas', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Descargas::index');
    $routes->get('files', 'Descargas::files');
    $routes->get('download', 'Descargas::download');
});
```

## 6) Seguridad minima (obligatoria)
Para el escenario "solo password":
- guardar hash (password_hash) en config, nunca texto plano
- usar session_regenerate_id luego de login
- CSRF token en formularios POST
- rate limit por IP en login (ej: 5 intentos / 15 min)
- timeout de sesion (ej: 30 min)
- token de descarga firmado con expiracion corta (ej: 5 min)
- validacion estricta de rutas para evitar path traversal

## 7) Modelo de "clave temporal para clientes"
Sin TOTP, pero con control:
- clave base interna (admins)
- claves temporales de acceso compartible
- cada clave temporal con:
  - nombre (cliente o campania)
  - fecha de vencimiento
  - opcional limite de usos
  - opcional alcance (solo version actual / incluye assets)

Implementacion simple en archivo JSON o SQLite (si disponible).

## 8) Manejo de versiones (contador)
Regla operativa recomendada:
- siempre una version activa
- cuando sube nueva version:
  - mover actual a backup/YYYYMMDD-HHMM/
  - activar nueva
  - purga automatica de backups viejos (ej: 7 dias)

Si se desea "borrar la anterior" estrictamente, tecnicamente se puede, pero se recomienda conservar backup corto para rollback.

## 9) Subida de archivos: FileZilla vs panel web
Estado actual:
- contador usa FileZilla por FTP y ya funciona

Recomendacion:
- Fase 1: mantener FileZilla para no romper flujo actual
- Fase 2: sumar panel web de subida

Para panel web:
- subir ZIP (no carpeta suelta)
- validar extension y tamano
- descomprimir en staging
- validar estructura esperada
- publicar como version activa

## 10) Plan de accion por fases
Fase 0 - Preparacion
- rotar credenciales FTP expuestas
- definir carpeta real de releases y assets

Fase 1 - Base tecnica
- crear index.php + Router + .htaccess
- crear controladores de rutas publicas

Fase 2 - Descargas protegidas
- login password
- sesion + logout
- listado de archivos
- descarga con token firmado

Fase 3 - Claves temporales
- modulo de claves con vencimiento y alcance
- bitacora minima de descargas

Fase 4 - Operacion de versiones
- protocolo de subida del contador
- backup y rollback
- documentacion operativa

Fase 5 - Panel de subida web (opcional)
- upload ZIP
- validacion
- publish atomico

## 11) Criterios de exito
- /descargas solo visible con autenticacion
- descarga de version actual en un clic
- posibilidad de compartir clave temporal a cliente
- rutas /pagos y /tutoriales listas para evolucion
- estructura mantenible para trabajo continuo con IA
