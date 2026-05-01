# Guía de Rutas, Controllers, Models, Views y Filters en CI4

Esta guía explica cómo funciona cada pieza del framework y cómo encajan entre sí, usando ejemplos reales de este proyecto.

---

## 1. Rutas — `app/Config/Routes.php`

Las rutas son el mapa de tu aplicación. Definen qué URL llama a qué controller.

```php
// Sintaxis básica
$routes->get('/ruta', 'NombreController::metodo');
$routes->post('/ruta', 'NombreController::metodo');
```

### Ejemplo real del proyecto

```php
// app/Config/Routes.php

$routes->get('/', 'HomeController::index');
$routes->get('descargas', 'DescargasController::index');
$routes->post('descargas/login', 'DescargasController::login', ['filter' => 'ratelimit']);
$routes->get('descargas/panel', 'DescargasController::panel', ['filter' => 'auth']);
$routes->get('descargas/logout', 'DescargasController::logout', ['filter' => 'auth']);
```

### Cosas importantes

- Solo hay UN archivo de rutas. No hay routers separados por módulo.
- El tercer parámetro `['filter' => 'nombre']` aplica un filtro a esa ruta específica.
- Los filtros deben estar registrados en `app/Config/Filters.php` antes de usarlos.
- Las rutas van en español, orientadas al dominio del negocio.

### Parámetros en la URL

```php
// Captura el ID del usuario
$routes->get('usuarios/(:num)', 'UsuarioController::detalle/$1');

// Captura un segmento de texto
$routes->get('blog/(:segment)', 'BlogController::post/$1');
```

El `(:num)` acepta solo números. El `(:segment)` acepta cualquier texto sin barras. El `$1` pasa ese valor como primer argumento al método del controller.

---

## 2. Controllers — `app/Controllers/`

El controller es el coordinador. Recibe la request, llama a quien tiene que llamar (service o model), y devuelve una respuesta (view o JSON).

### Regla clave: controladores DELGADOS

Un controller **no** tiene lógica de negocio. No calcula, no valida reglas de negocio, no accede a archivos directamente. Solo orquesta.

```php
// app/Controllers/DescargasController.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\ClaveTemporalService;

class DescargasController extends Controller
{
    public function index(): string
    {
        // Muestra el formulario de login
        return view('descargas/login');
    }

    public function login(): \CodeIgniter\HTTP\RedirectResponse
    {
        // Valida la clave — la lógica real está en el Service
        $clave = $this->request->getPost('clave');
        $service = new ClaveTemporalService();

        if (!$service->validar($clave)) {
            // Redirecciona con un mensaje de error
            return redirect()->back()->with('error', 'Clave inválida o vencida');
        }

        session()->set('autenticado', true);
        return redirect()->to('/descargas/panel');
    }

    public function panel(): string
    {
        // El filtro auth ya verificó que hay sesión activa
        $service = new \App\Services\FileCatalogService();
        $data['archivos'] = $service->listar();
        return view('descargas/panel', $data);
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/descargas');
    }
}
```

### Recibir datos de la request

```php
// Datos de un formulario POST
$nombre = $this->request->getPost('nombre');

// Parámetro de la URL (?id=5)
$id = $this->request->getGet('id');

// Parámetro de ruta (definido en Routes.php con (:num))
public function detalle(int $id): string { ... }
```

### Devolver respuestas

```php
// Renderizar una view
return view('nombre/de/vista', $data);

// Redirigir
return redirect()->to('/otra-ruta');
return redirect()->back();  // a la página anterior

// JSON (para APIs)
return $this->response->setJSON(['ok' => true]);
```

---

## 3. Views — `app/Views/`

Las views son HTML con PHP mínimo. **No hacen cálculos, no llaman servicios, no acceden a archivos.** Solo presentan lo que el controller les pasó.

### Layout compartido

```php
<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= $titulo ?? 'ALCALD+IA' ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <!-- Contenido de la página específica -->
    <?= $this->renderSection('contenido') ?>
</body>
</html>
```

### View que usa el layout

```php
<!-- app/Views/descargas/login.php -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="login-container">
    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif ?>

    <form method="POST" action="/descargas/login">
        <?= csrf_field() ?>
        <input type="password" name="clave" placeholder="Clave de acceso">
        <button type="submit">Ingresar</button>
    </form>
</div>
<?= $this->endSection() ?>
```

### Cosas importantes

- `<?= csrf_field() ?>` es OBLIGATORIO en todo formulario POST. CI4 valida el token automáticamente.
- Los datos que pasaste desde el controller (`$data`) se convierten en variables disponibles en la view.
- `session()->getFlashdata('clave')` lee datos que viven solo para una request (perfectos para mensajes de error).

---

## 4. Models — `app/Models/`

Los models acceden a datos. En CI4, el Model base te da métodos para operar con bases de datos.

> En este proyecto usamos archivos JSON en lugar de base de datos (por simplicity del hosting). Cuando migremos a DB, los models reemplazarán a los Services de archivos.

### Model básico con base de datos

```php
// app/Models/ClaveTemporalModel.php

namespace App\Models;

use CodeIgniter\Model;

class ClaveTemporalModel extends Model
{
    protected $table      = 'claves_temporales';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nombre', 'hash', 'vencimiento', 'limite_usos', 'usos', 'activa'];

    // Tipos de datos automáticos
    protected $casts = [
        'activa'       => 'boolean',
        'limite_usos'  => 'integer',
        'usos'         => 'integer',
    ];
}
```

### Operaciones comunes

```php
$model = new ClaveTemporalModel();

// Buscar por ID
$clave = $model->find(1);

// Buscar con condición
$activas = $model->where('activa', true)->findAll();

// Insertar
$model->insert(['nombre' => 'Municipio X', 'hash' => $hash, 'activa' => true]);

// Actualizar
$model->update($id, ['usos' => $claveActual['usos'] + 1]);

// Eliminar (soft delete si está configurado)
$model->delete($id);
```

---

## 5. Services — `app/Services/` (carpeta custom)

Los Services tienen la lógica de negocio. Esta carpeta **no** existe en CI4 por defecto — es una convención de este proyecto, inspirada en arquitectura hexagonal.

Un Service es una clase PHP simple, sin herencia especial. Solo recibe parámetros y retorna resultados.

```php
// app/Services/ClaveTemporalService.php

namespace App\Services;

class ClaveTemporalService
{
    private string $archivo;

    public function __construct()
    {
        $this->archivo = ROOTPATH . 'storage/claves-temporales.json';
    }

    public function validar(string $claveIngresada): bool
    {
        $datos = $this->leerJson();

        foreach ($datos['claves'] as &$clave) {
            if (!$clave['activa']) continue;
            if (new \DateTime() > new \DateTime($clave['vencimiento'])) continue;
            if ($clave['usos'] >= $clave['limite_usos']) continue;

            if (password_verify($claveIngresada, $clave['hash'])) {
                $clave['usos']++;
                $this->escribirJson($datos);
                return true;
            }
        }

        return false;
    }

    private function leerJson(): array
    {
        $fp = fopen($this->archivo, 'c+');
        flock($fp, LOCK_SH);
        $contenido = json_decode(stream_get_contents($fp), true) ?? ['claves' => []];
        flock($fp, LOCK_UN);
        fclose($fp);
        return $contenido;
    }

    private function escribirJson(array $datos): void
    {
        $fp = fopen($this->archivo, 'c+');
        flock($fp, LOCK_EX);
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($datos, JSON_PRETTY_PRINT));
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
```

**¿Por qué separar en Services y no poner esto en el Controller?**

Porque si mañana agregás un comando CLI que también valida claves, o una API que hace lo mismo, no querés duplicar esa lógica. El Controller se vuelve un consumidor del Service, no el dueño de la lógica.

---

## 6. Filters — `app/Filters/`

Los Filters son el equivalente a middlewares en otros frameworks. Se ejecutan antes o después del controller.

### Registrar un filtro en `app/Config/Filters.php`

```php
public array $aliases = [
    'auth'      => \App\Filters\AuthFilter::class,
    'ratelimit' => \App\Filters\RateLimitFilter::class,
];
```

### Implementar un filtro

```php
// app/Filters/AuthFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si no hay sesión activa, redirigir al login
        if (!session()->get('autenticado')) {
            return redirect()->to('/descargas');
        }
        // Si retorna null, la request continúa al controller
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Opcional: lógica post-controller (ej: agregar headers)
    }
}
```

### Aplicar filtros

**A una ruta específica** (en `Routes.php`):
```php
$routes->get('descargas/panel', 'DescargasController::panel', ['filter' => 'auth']);
```

**A un grupo de rutas** (en `Routes.php`):
```php
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('usuarios', 'AdminController::usuarios');
});
```

**A todas las rutas** (en `app/Config/Filters.php`):
```php
public array $globals = [
    'before' => ['csrf'],
    'after'  => ['toolbar'],
];
```

---

## 7. Resumen: quién hace qué

| Componente | Responsabilidad | Ejemplo |
|-----------|----------------|---------|
| `Routes.php` | Mapear URLs a controllers | `GET /descargas → DescargasController::index` |
| Controller | Coordinar: recibe request, llama services, devuelve view | `DescargasController::login()` |
| Service | Lógica de negocio | `ClaveTemporalService::validar()` |
| Model | Acceso a datos (DB) | `ClaveTemporalModel::find()` |
| View | Presentación HTML | `descargas/login.php` |
| Filter | Guardia de ruta (before/after) | `AuthFilter::before()` |

---

## 8. Errores comunes y cómo evitarlos

### "Class not found" al instanciar un controller o service

**Causa**: El nombre del archivo no coincide exactamente con el nombre de la clase (PSR-4 es sensible a mayúsculas).
**Solución**: Si la clase es `DescargasController`, el archivo DEBE llamarse `DescargasController.php`.

### La ruta no funciona, devuelve 404

**Causa**: La ruta no está definida en `Routes.php`, o el método HTTP no coincide (GET vs POST).
**Verificación**: `php spark routes` — si la ruta no aparece ahí, no existe para CI4.

### El filtro no se ejecuta

**Causa**: El filtro no está registrado en `app/Config/Filters.php`, o el alias no coincide con el nombre usado en Routes.php.

### El token CSRF falla (error 403 en POST)

**Causa**: El formulario no tiene `<?= csrf_field() ?>`, o se envía la request directamente sin el token.
**Solución**: Todo formulario POST debe incluir `<?= csrf_field() ?>` dentro del `<form>`.

### Los cambios en vistas no se reflejan

**Causa**: CI4 cachea las vistas en `writable/cache/`.
**Solución**: `php spark cache:clear`
