# Cómo iniciar un proyecto PHP full stack con CodeIgniter 4

Esta guía es para vos como humano. Explica el proceso real, con el razonamiento detrás de cada decisión.

---

## 1. ¿Qué es CodeIgniter 4?

CI4 es un framework PHP MVC (Model-View-Controller). Esto significa que separa tu aplicación en tres capas:

- **Model**: accede a los datos (base de datos, archivos JSON, etc.)
- **View**: presenta los datos al usuario (HTML + CSS)
- **Controller**: recibe la request, llama al model/service, y le pasa datos a la view

El framework te da enrutamiento, seguridad, helpers, y una estructura predecible. Vos escribís tu lógica, CI4 se encarga de la fontanería.

---

## 2. Herramientas que necesitás tener instaladas

| Herramienta | Para qué sirve | Versión mínima |
|-------------|---------------|----------------|
| PHP | Ejecutar código PHP | 8.1+ |
| Composer | Gestor de dependencias de PHP (como npm para Node) | 2.x |
| Git | Control de versiones | Cualquiera |

Verificá que estén disponibles desde la terminal:

```bash
php --version
composer --version
git --version
```

---

## 3. Crear un proyecto nuevo desde cero

### Paso 1 — Crear la carpeta del proyecto vía Composer

```bash
composer create-project codeigniter4/appstarter nombre-del-proyecto
cd nombre-del-proyecto
```

Esto crea la estructura completa, descarga CI4 en `vendor/`, y deja todo listo para trabajar.

> **¿Por qué `appstarter` y no clonar el repo de CI4?**
> El repo del framework es el código fuente del framework mismo. El `appstarter` es la plantilla de proyecto que vos usás como punto de partida. Son cosas distintas. Siempre usás `appstarter`.

### Paso 2 — Configurar el archivo `.env`

Copiá el archivo de ejemplo:

```bash
cp env .env
```

Abrí `.env` y editá como mínimo:

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
```

En producción cambiás `development` por `production`.

> **¿Por qué `.env` y no hardcodear los valores?**
> Porque `.env` está en `.gitignore` — nunca se sube a git. Si hardcodeás credenciales en código, cualquiera con acceso al repo las ve. Separar configuración del código es una práctica fundamental.

### Paso 3 — Levantar el servidor local

```bash
php spark serve
```

Abrí `http://localhost:8080` en el navegador. Si ves la página de bienvenida de CI4, todo funciona.

`spark` es la herramienta de línea de comandos de CI4. La vas a usar mucho.

### Equivalencia directa con Node.js (lo que ya conocés)

Si en Node hacías esto:

```bash
node archivo.js
npm run dev
npm start
```

En este proyecto CI4 el paralelo es:

```bash
php spark serve            # similar a npm run dev
composer run dev           # alias estable del proyecto para modo desarrollo
composer run start         # alias para inicio local tipo entorno deploy
```

Si en Windows `cmd` te aparece "composer no se reconoce" o "php no se reconoce", no es un error de la guía: es un problema de PATH del sistema.

Comandos alternativos inmediatos (validados en este entorno):

```bat
C:\tools\php84\composer.bat run dev
C:\tools\php84\composer.bat run start
```

Verificación rápida de PATH en `cmd`:

```bat
where composer
where php
```

Si esos comandos no devuelven rutas, usá la ruta absoluta anterior o agregá `C:\tools\php84` a la variable de entorno `PATH`.

Configuración global recomendada en Windows (una sola vez):

```powershell
$target = 'C:\tools\php84'
$userPath = [Environment]::GetEnvironmentVariable('Path', 'User')
$parts = if ([string]::IsNullOrWhiteSpace($userPath)) { @() } else { $userPath -split ';' }
if ($parts -notcontains $target) {
    $newPath = (($parts + $target) | Where-Object { $_ -and $_.Trim() -ne '' } | Select-Object -Unique) -join ';'
    [Environment]::SetEnvironmentVariable('Path', $newPath, 'User')
}
```

Luego cerrá y abrí terminal nueva y verificá:

```bat
where php
where composer
```

Si usás Git Bash y `composer` sigue sin resolver, agregá este wrapper en `~/.bashrc`:

```bash
export PATH="/c/tools/php84:$PATH"
alias php="/c/tools/php84/php.exe"
unalias composer 2>/dev/null
composer() { cmd.exe //c C:/tools/php84/composer.bat "$@"; }
```

Aplicá cambios sin cerrar terminal:

```bash
source ~/.bashrc
```

Resumen rápido:
- `php archivo.php` sería el equivalente crudo de `node archivo.js`.
- En aplicaciones web con framework (CI4), el entrypoint real no es un archivo suelto: se levanta servidor y se enruta vía `public/index.php`.
- Por eso, en la práctica vas a usar `spark` o scripts de Composer, no ejecución de archivo aislado.

### Modos de inicio definidos en este proyecto

En `composer.json` quedaron definidos dos inicios:

- `composer run dev`
    - Comando interno: `php spark serve --host 127.0.0.1 --port 8080`
    - Uso: desarrollo diario, feedback rápido y flujo estándar CI4.

- `composer run start`
    - Comando interno: `php -S 127.0.0.1:8080 -t public public/router.php`
    - Uso: simulación local más cercana al front controller expuesto en deploy.

> Recomendación práctica: usá `dev` para trabajar y `start` para una verificación final de comportamiento antes de publicar.

---

## 4. Estructura de carpetas que importa

```
mi-proyecto/
├── app/                    ← TU código va acá
│   ├── Config/             ← Configuración del framework
│   │   ├── Routes.php      ← TODAS las rutas de la app
│   │   ├── App.php         ← Config general (baseURL, timezone, etc.)
│   │   ├── Filters.php     ← Registro de filtros (auth, ratelimit)
│   │   └── Paths.php       ← Dónde está el framework (no tocar)
│   ├── Controllers/        ← Reciben requests, coordinan la respuesta
│   ├── Models/             ← Acceden a datos (DB, archivos)
│   ├── Views/              ← HTML que se muestra al usuario
│   └── Filters/            ← Middleware: auth guard, rate limiting, etc.
├── public/                 ← Lo único expuesto al navegador
│   ├── index.php           ← Front controller (no tocar)
│   └── .htaccess           ← Routing limpio (no tocar)
├── vendor/                 ← Dependencias de Composer (no tocar, no commitear)
├── writable/               ← Cache y logs (no commitear)
├── .env                    ← Variables de entorno (no commitear)
└── composer.json           ← Defines las dependencias del proyecto
```

> **Regla de oro**: solo `public/` queda expuesto al navegador. En el servidor web, el `DocumentRoot` apunta a `public/`, no a la raíz del proyecto. Esto protege `app/`, `vendor/`, `.env` y todo lo demás de acceso directo por HTTP.

---

## 5. El archivo `composer.json`

Este archivo define qué dependencias usa tu proyecto. Un `composer.json` mínimo para un proyecto CI4 se ve así:

```json
{
    "name": "miempresa/mi-proyecto",
    "type": "project",
    "require": {
        "php": "^8.1",
        "codeigniter4/framework": "^4.6"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
    "minimum-stability": "stable"
}
```

Cuando alguien clona el repositorio, corre `composer install` y Composer descarga todo lo que está en `require`. Por eso `vendor/` no se commitea — se puede regenerar siempre.

---

## 6. Deploy en hosting compartido (Donweb u otros)

La diferencia principal entre local y hosting es que en hosting compartido **no podés apuntar el `DocumentRoot` a `public/`** directamente si el hosting te da `public_html/`.

La solución estándar:

1. Subís todo el proyecto a un nivel sobre `public_html/` (via FTP)
2. Copiás el contenido de `public/` dentro de `public_html/`
3. Editás `public_html/index.php` para que apunte al `app/` real

```
servidor/
├── app/           ← un nivel arriba de public_html
├── vendor/
├── .env
└── public_html/   ← esto es lo que ve el browser
    ├── index.php  ← ajustado para apuntar a ../app/Config/Paths.php
    └── .htaccess
```

En el `index.php` de `public_html/` editás las rutas relativas al `app/`:

```php
$pathsConfig = FCPATH . '/../app/Config/Paths.php';
```

---

## 7. Variables de entorno importantes

| Variable | Para qué sirve | Ejemplo |
|----------|---------------|---------|
| `CI_ENVIRONMENT` | Modo de la app | `development` / `production` |
| `app.baseURL` | URL base de la app | `https://tudominio.com/` |
| `database.default.hostname` | Host de la BD | `localhost` |
| `database.default.database` | Nombre de la BD | `mi_base` |
| `database.default.username` | Usuario de BD | `mi_usuario` |
| `database.default.password` | Password de BD | `secreto123` |

En producción, el modo `production` desactiva el debugger y oculta errores detallados al usuario (los loguea en `writable/logs/` pero no los muestra en pantalla). **Nunca dejes `development` en producción.**

---

## 8. Comandos spark que vas a usar seguido

```bash
# Ver todas las rutas registradas
php spark routes

# Levantar servidor local
php spark serve

# Crear un controller
php spark make:controller NombreController

# Crear un model
php spark make:model NombreModel

# Limpiar cache
php spark cache:clear

# Ver todos los comandos disponibles
php spark list
```

---

## 9. El flujo completo de una request

Cuando alguien visita `https://tudominio.com/descargas`:

1. El servidor recibe la request y la pasa a `public/index.php` (el front controller)
2. `index.php` bootea CI4 cargando el framework desde `vendor/`
3. CI4 lee `app/Config/Routes.php` y busca la ruta `/descargas`
4. Si hay filtros registrados para esa ruta, los ejecuta antes del controller
5. Llama al método del controller correspondiente (`DescargasController::index()`)
6. El controller puede llamar a un service o model para obtener datos
7. El controller llama a una view pasándole los datos (`return view('descargas/login', $data)`)
8. CI4 renderiza la view y devuelve el HTML al browser

Entender este flujo es fundamental. Cualquier cosa que no funcione se puede rastrear siguiendo estos 8 pasos.

---

## 10. Por qué `app/Config` es tan grande (y qué sí te importa)

La carpeta `app/Config/` parece enorme porque **CI4 te entrega una base completa de fábrica** para cubrir muchos escenarios (email, cache, CORS, migraciones, seguridad, sesiones, toolbar, etc.).

Eso no significa que tu proyecto use todo hoy. Significa que el framework ya deja los puntos de extensión listos para cuando los necesites.

### Cómo leerla sin abrumarte

Pensala como una consola de avión: hay muchos controles, pero para despegar solo usás los necesarios.

En este proyecto, los más importantes ahora son:

- `Routes.php`: define las rutas reales de negocio.
- `Filters.php`: registra y conecta filtros como auth y ratelimit.
- `App.php`: configuración general de aplicación (base URL, locale, timezone).
- `Paths.php`: indica dónde está el core del framework en `vendor/`.
- `Security.php`: política general de seguridad (tokens, headers, etc.).
- `Session.php`: parámetros de sesión de usuario.

Archivos como `Email.php`, `Migrations.php`, `Pager.php`, `Toolbar.php` o `Images.php` son módulos de capacidad del framework:
- Si no estás enviando correos, `Email.php` puede quedar con defaults.
- Si no estás migrando DB todavía, `Migrations.php` no te afecta en lo diario.
- Si no usás paginación, `Pager.php` queda de soporte.

### Regla práctica

No edites `app/Config` “por curiosidad”. Editalo cuando haya un requerimiento funcional concreto.

Orden recomendado para aprender:
1. `Routes.php`
2. `Filters.php`
3. `App.php`
4. `Session.php`
5. `Security.php`

Con eso ya entendés el 80% de la operación real del proyecto.
