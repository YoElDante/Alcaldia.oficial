# AGENTS.md — Alcaldía Web Oficial

> Manual de instrucciones para agentes de IA y desarrolladores.
> Todo agente que trabaje en este proyecto debe leer este archivo antes de escribir cualquier línea de código.

---

## 0. Protocolo Obligatorio para Agentes de IA

> Esta sección es la PRIMERA que debe ejecutarse. Sin excepción. Sin importar el agente (Claude, GitHub Copilot, Codex, u otro).

### 0.1 Engram — Memoria Persistente (OBLIGATORIO)

Engram es el sistema de memoria persistente del proyecto. Sobrevive compactaciones y cambios de sesión. **No operar sin él.**

**Al iniciar cualquier sesión:**
1. Llamar `mem_context` — recupera historial reciente de la sesión anterior
2. Llamar `mem_search` con keywords del tema actual — busca decisiones y convenciones previas
3. Si se encontró contexto relevante: usar `mem_get_observation(id)` para leer el contenido completo (los resultados de búsqueda están truncados)

**Durante el trabajo — guardar INMEDIATAMENTE y SIN QUE SE PIDA después de:**
- Cualquier decisión de arquitectura o diseño
- Un bug resuelto (incluir causa raíz)
- Una convención establecida
- Un descubrimiento no obvio del codebase
- Una preferencia o restricción del usuario aprendida
- Cualquier configuración de entorno completada

Formato `mem_save` obligatorio:
```
title:     Verbo + qué — corto y buscable
type:      bugfix | decision | architecture | discovery | pattern | config | preference
scope:     project
topic_key: clave estable si el tema puede evolucionar (ej. "architecture/descargas")
content:
  Qué:      Una oración — qué se hizo
  Por qué:  Motivación (bug, requerimiento, seguridad, etc.)
  Dónde:    Archivos afectados
  Aprendido: Gotchas o edge cases (omitir si no aplica)
```

**Al cerrar sesión o antes de decir "listo":**
Llamar `mem_session_summary` con: Goal, Instructions, Discoveries, Accomplished, Next Steps, Relevant Files.
Esto NO es opcional. Sin este llamado, la siguiente sesión arranca ciega.

**Después de una compactación:**
1. Llamar `mem_session_summary` con el contenido compactado — para no perder lo anterior
2. Llamar `mem_context` — recuperar contexto de sesiones previas
3. Recién entonces continuar

### 0.2 SDD — Spec-Driven Development (para cambios sustanciales)

Para cualquier cambio que involucre más de un archivo o lógica nueva, aplicar el ciclo SDD:

```
/sdd-explore → /sdd-propose → /sdd-spec → /sdd-tasks → /sdd-apply → /sdd-verify
```

El flujo correcto es:
```
AGENTS.md + contexto Engram → planificar con SDD → código correcto → GGA confirma
```

**El flujo INCORRECTO (prohibido):**
```
código escrito a ciegas → GGA falla → sesión de correcciones reactivas
```

GGA (Guardian Angel) es una confirmación, no un detector primario de errores.

### 0.3 Checklist pre-código (ejecutar antes de escribir cualquier archivo)

- [ ] `mem_context` ejecutado — contexto de sesión anterior recuperado
- [ ] `mem_search` ejecutado con keywords del área de trabajo
- [ ] AGENTS.md leído en su totalidad (o confirmado desde Engram que está cacheado)
- [ ] Convenciones de la sección relevante verificadas (arquitectura, seguridad, nomenclatura, diseño)
- [ ] Plan SDD activo si el cambio toca más de un archivo
- [ ] Skill registry consultado si el contexto lo requiere

**Si algún item no está marcado, no se escribe código.**

---

## 1. Contexto del Proyecto

**Producto**: Portal web oficial de ALCALD+IA — software de gestión municipal con IA.
**Propósito del sitio**: Landing page institucional que promueve demos, redirige consultas a WhatsApp y expone un módulo de descargas protegido para distribución del software de escritorio a municipios clientes.

| Campo | Valor |
|-------|-------|
| Público objetivo | Administradores municipales y contadores de comunas |
| Hosting | Donweb (shared hosting, PHP 8.1+) |
| Dominio | alcaldia.store |
| Framework backend | CodeIgniter 4 (CI4) |
| Deploy | FTP via FileZilla (flujo actual) |
| Contacto comercial | WhatsApp +54 351 155575700 |
| Email | creduardofereyra@gmail.com |

---

## 2. Stack Tecnológico

| Capa | Tecnología | Notas |
|------|-----------|-------|
| Backend | CodeIgniter 4 (PHP 8.1+) | Instalado via Composer |
| Frontend | HTML / CSS / JS puro | Sin frameworks JS |
| Persistencia temporal | JSON (flat file) | SQLite cuando el volumen lo justifique |
| Hosting | Donweb shared hosting | Solo `public/` expuesto al navegador |
| Control de versiones | Git + FTP | Git para desarrollo, FTP para publicar |

---

## 3. Arquitectura

Este proyecto usa **CodeIgniter 4 (MVC)** como framework base.
La referencia técnica completa está en `docs/Definicion de proyecto/arquitectura-web-php-rutas-descargas.md`.

### 3.1 Reglas de arquitectura — NO NEGOCIABLES

1. CI4 ya provee front controller nativo (`public/index.php`). **Nunca crear un front controller PHP custom.**
2. Todas las rutas se definen en `app/Config/Routes.php`. **Nunca crear un router PHP custom.**
3. Auth guards y rate limiting se implementan como **CI4 Filters** en `app/Filters/`. Nunca como middlewares custom.
4. **Controladores delgados**: un controller solo recibe la request, llama al service correspondiente y devuelve la respuesta. La lógica de negocio va en `app/Services/`.
5. **Vistas sin lógica**: las vistas no hacen cálculos, no acceden a archivos, no validan datos. Solo presentan lo que el controller les pasa.
6. Solo `public/` queda expuesto al navegador. `app/`, `vendor/`, `writable/`, `storage/` y `.env` deben vivir fuera de `public_html`.
7. Nunca escribir lógica de negocio directamente en `Routes.php`.

### 3.2 Equivalencias Node/Express → CodeIgniter 4

Para el equipo con experiencia en Node:

| Node / Express | CodeIgniter 4 |
|---------------|---------------|
| `app.get('/ruta', handler)` | `app/Config/Routes.php` |
| `controllers/` | `app/Controllers/` |
| `services/` | `app/Services/` (carpeta custom) |
| `middleware auth` | `app/Filters/AuthFilter.php` |
| `views/` (EJS/Pug) | `app/Views/` |
| `public/` | `public/` |

### 3.3 Estructura de carpetas objetivo

```
alcaldia-web-oficial/
├── app/
│   ├── Config/
│   │   ├── Routes.php              ← ÚNICA definición de rutas del proyecto
│   │   └── App.php
│   ├── Controllers/                ← Orquestadores delgados
│   │   ├── HomeController.php
│   │   ├── DescargasController.php
│   │   ├── AuthController.php
│   │   ├── PagosController.php
│   │   └── TutorialesController.php
│   ├── Filters/                    ← Auth guard, rate limiting
│   │   ├── AuthFilter.php
│   │   └── RateLimitFilter.php
│   ├── Services/                   ← Lógica de negocio (carpeta custom)
│   │   ├── TokenService.php
│   │   ├── FileCatalogService.php
│   │   └── ClaveTemporalService.php
│   ├── Models/                     ← Modelos CI4 (cuando se migre a DB)
│   └── Views/
│       ├── layouts/
│       │   └── main.php
│       ├── home.php
│       ├── pagos.php
│       ├── tutoriales.php
│       └── descargas/
│           ├── login.php
│           └── panel.php
├── public/                         ← ÚNICA carpeta expuesta al navegador
│   ├── assets/
│   │   └── img/
│   ├── css/
│   │   ├── shared-components.css   ← Variables, navbar, botones, decoraciones (TODAS las vistas)
│   │   ├── main.css                ← Estilos exclusivos de la landing (home)
│   │   └── error-view.css          ← Layout de páginas de error (404, etc.)
│   ├── js/
│   │   ├── main.js
│   │   ├── smooth-scroll.js
│   │   └── carousel.js
│   ├── index.php                   ← Front controller de CI4 (no modificar)
│   └── .htaccess                   ← Routing limpio de CI4 (no modificar)
├── storage/                        ← Archivos privados — nunca exponer
│   ├── releases/
│   │   ├── version.json            ← Versión activa actual
│   │   ├── AppAlcaldia-vX.Y.Z.zip  ← Binario de escritorio
│   │   └── backup/
│   │       └── YYYYMMDD-HHMM/
│   ├── assets-instalacion/         ← Imágenes y extras de instalación
│   ├── claves-temporales.json      ← Claves de acceso con vencimiento
│   └── bitacora.json               ← Log de intentos y descargas
├── writable/                       ← Cache y logs de CI4 — NO exponer
├── vendor/                         ← Dependencias Composer — NO exponer
├── .env                            ← Variables de entorno — NO exponer, NO commitear
└── composer.json
```

---

## 4. Convenciones de Nomenclatura

Este proyecto sigue **CI4 / PSR-4**. El autoloader de Composer mapea el nombre de la clase al nombre del archivo. Esto es obligatorio — no es una preferencia de estilo.

### 4.1 Clases PHP (PSR-4)

| Tipo | Convención | Ejemplo |
|------|-----------|---------|
| Controller | `PascalCase` + sufijo `Controller` | `DescargasController.php` |
| Filter | `PascalCase` + sufijo `Filter` | `AuthFilter.php` |
| Service | `PascalCase` + sufijo `Service` | `TokenService.php` |
| Model | `PascalCase` + sufijo `Model` | `ClaveTemporalModel.php` |

> **Regla crítica PSR-4**: el nombre del archivo DEBE ser idéntico al nombre de la clase. Si la clase es `DescargasController`, el archivo es `DescargasController.php`. Nunca `descargas_controller.php` ni ninguna otra variante. Composer no la va a encontrar y el resultado es un error en runtime.

### 4.2 Archivos sin clase

| Tipo | Convención | Ejemplo |
|------|-----------|---------|
| Views PHP | `snake_case` | `login.php`, `panel_descargas.php` |
| CSS | `kebab-case` | `main.css`, `descargas.css` |
| JS | `kebab-case` | `carousel.js`, `smooth-scroll.js` |
| JSON de datos | `kebab-case` | `claves-temporales.json`, `bitacora.json` |
| Imágenes | `kebab-case` | `alcaldia-logo.webp`, `whatsapp-icon.png` |

### 4.3 Rutas URL

- Las rutas van en **español**, orientadas al dominio de negocio: `/descargas`, `/pagos`, `/tutoriales`
- Verbos HTTP correctos: `GET` para leer/mostrar, `POST` para formularios y acciones con efecto

### 4.4 Métodos y variables PHP

| Elemento | Convención | Ejemplo |
|---------|-----------|---------|
| Métodos | `camelCase` | `getVersionActual()`, `validarClave()` |
| Variables | `camelCase` | `$clavesTemporal`, `$tokenDescarga` |
| Constantes | `UPPER_SNAKE_CASE` | `TOKEN_EXPIRY_MINUTES`, `MAX_LOGIN_ATTEMPTS` |

---

## 5. Sistema de Diseño

Todas las vistas del proyecto — actuales y futuras — deben mantener coherencia visual con la landing existente. Esta paleta, tipografía y gradientes son la identidad visual de ALCALD+IA.

### 5.1 Arquitectura CSS — Obligatoria

El sistema CSS tiene **tres archivos con responsabilidades estrictas**. No mezclar.

| Archivo | Carga en | Responsabilidad |
|---------|----------|-----------------|
| `public/css/shared-components.css` | **Todas las vistas** (via `partials/head.php` y manual en vistas de error) | Fuente única de verdad: `:root` con variables, navbar, botones, layout interno, fondos institucionales y **sistema completo de decoraciones** |
| `public/css/main.css` | Landing (home) solamente | Estilos exclusivos del home: hero, carrusel, secciones, footer |
| `public/css/error-view.css` | Páginas de error (404, etc.) | Solo layout de pantalla de error: `.error-page`, `.wrap`, `.actions`, `.help-text` |

**Regla de carga en vistas de error**: cargar `shared-components.css` ANTES de `error-view.css`:
```html
<link rel="stylesheet" href="/css/shared-components.css">
<link rel="stylesheet" href="/css/error-view.css">
```

**Nunca** redefinir `:root`, botones ni clases de decoración fuera de `shared-components.css`.

### 5.2 Paleta de colores

Las variables están definidas **una sola vez** en el `:root` de `public/css/shared-components.css`. No redefinir en ningún otro archivo.

```css
--color-primary:    #00A8B5;  /* Turquesa — acentos, botones, logo */
--color-dark:       #003E5C;  /* Azul oscuro — headings, footer, textos */
--color-light-bg:   #E0F7FA;  /* Azul claro — fondos de secciones pares (.bg-section-alt) */
--color-white:      #FFFFFF;  /* Fondo principal */
--color-secondary:  #F5F5F5;  /* Gris claro — elementos secundarios */
--color-whatsapp:   #25D366;  /* Verde WhatsApp */
--sombra:           0 4px 20px rgba(0,0,0,0.1);
--sombra-hover:     0 8px 30px rgba(0,0,0,0.15);
--transicion:       all 0.3s ease;
```

### 5.3 Tipografía

```css
/* Headings: Oswald bold uppercase */
h1, h2, h3 { font-family: 'Oswald', sans-serif; font-weight: 700; text-transform: uppercase; }

/* Body: Open Sans */
body, p, li { font-family: 'Open Sans', sans-serif; font-weight: 400; }
```

Import obligatorio (ya incluido en `partials/head.php`):
```html
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
```

### 5.4 Clases de uso inmediato (ya en shared-components.css)

#### Fondos institucionales
```html
<!-- Fondo turquesa claro — secciones alternas en vistas internas -->
<section class="bg-section-alt"> ... </section>

<!-- Gradiente institucional oscuro (dark → turquesa) -->
<section class="bg-institutional-gradient"> ... </section>
```

#### Botones
```html
<a class="btn btn-primary" href="/ruta">Acción principal</a>
<button class="btn btn-secondary">Acción secundaria</button>
<a class="btn btn-whatsapp" href="https://wa.me/...">
  <img src="whatsapp-icon.png" alt="WhatsApp"> Contactar
</a>
```

#### Layout de vistas internas (pagos, tutoriales, descargas)
```html
<body class="layout-internal-shell">
  <main class="layout-internal-main">
    <section class="internal-hero-section bg-section-alt">
      <div class="container container-narrow text-center">
        <h1 class="section-title">Título</h1>
        <p class="section-subtitle centered-block">Subtítulo</p>
      </div>
    </section>
  </main>
</body>
```

### 5.5 Sistema de decoraciones

Las clases decorativas están en `shared-components.css`. Usarlas directamente en cualquier vista sin necesidad de definir CSS adicional.

#### Patrón de puntitos (fondo oscuro con gradiente)
```html
<div class="dots-pattern dots-top-left"></div>
<div class="dots-pattern dots-bottom-right"></div>
<div class="dots-pattern dots-middle-left"></div>
```

#### Círculos decorativos (fondo oscuro)
```html
<div class="hero-circle hero-circle-1"></div>
<div class="hero-circle hero-circle-2"></div>
<div class="hero-circle hero-circle-3"></div>
```

#### Decoraciones semánticas para secciones con fondo claro
```html
<!-- Puntos coloreados -->
<div class="decoration-dots dots-turquesa section-decoration" style="top:5%;right:3%"></div>
<div class="decoration-dots dots-dark section-decoration" style="bottom:8%;left:4%"></div>

<!-- Círculos outline -->
<div class="decoration-circle circle-outline section-decoration" style="top:10%;right:2%"></div>
<div class="decoration-circle circle-filled section-decoration" style="bottom:5%;left:3%"></div>

<!-- Barras diagonales -->
<div class="section-diagonal-bars bars-left bars-light">
  <div class="diagonal-bar"></div>
  <div class="diagonal-bar"></div>
  <div class="diagonal-bar"></div>
</div>
```

**Regla de sobreescritura del hero de la landing**: las decoraciones del `#hero` son más grandes y tienen animaciones. Están definidas en `main.css` bajo selector `#hero .dots-pattern` / `#hero .hero-circle-*`. Las vistas internas y de error reciben automáticamente la versión base (más pequeña, sin animación) de `shared-components.css`.

### 5.6 Reglas de estilo para nuevas vistas

- Toda vista nueva carga `layouts/main.php` (que ya incluye `partials/head.php` → shared + main). No agregar links CSS extra salvo que la vista sea standalone (como páginas de error).
- Usar únicamente las variables CSS de `shared-components.css`. Ningún color ad-hoc.
- Headings: Oswald bold uppercase. Body text: Open Sans regular o light.
- Responsive obligatorio: `@media (max-width: 768px)` como breakpoint principal.
- Animaciones: sutiles fade-in al scroll con `IntersectionObserver`. Sin efectos pesados.
- Prohibido usar `<style>` inline en vistas, `<script>` inline, o handlers inline (`onclick`, `onchange`).
- Si un patrón visual nuevo se repite en más de una vista: va a `shared-components.css`, no se duplica.
- CSS específico de un módulo (ej. descargas) puede ir en un archivo dedicado (`public/css/descargas.css`) cargado solo en esa vista, pero las variables y decoraciones siguen viniendo de shared.

---

## 6. Seguridad — Obligatoria y No Negociable

Si un agente de IA propone saltear cualquiera de estas reglas, rechazar la propuesta.

| Regla | Implementación |
|-------|---------------|
| Passwords | `password_hash()` / `password_verify()`. Nunca texto plano. Nunca en código fuente ni en Git. |
| CSRF | Token CSRF de CI4 en todo formulario POST. |
| Rate limit | Máximo 5 intentos de login por IP cada 15 minutos. Implementar con `AuthFilter.php`. |
| Sesión | `session_regenerate_id()` inmediatamente después del login. Timeout de 30 minutos. |
| Tokens de descarga | Firmados con HMAC-SHA256, expiración de 5 minutos. Validar firma antes de servir cualquier archivo. |
| Path traversal | Sanitizar y validar siempre el parámetro `?f=` antes de resolver rutas. Nunca usar input del usuario directamente en `realpath()` o rutas de archivo sin validación estricta. |
| Variables de entorno | Credenciales en `.env`. `.env` en `.gitignore`. Nunca hardcodear credenciales. |
| Errores en producción | `CI_ENVIRONMENT=production` en producción. Nunca exponer stack traces al usuario. |

---

## 7. Modelo de Datos — Claves Temporales (JSON)

Persistencia actual: JSON flat files en `storage/`. Migrar a SQLite cuando el volumen o la complejidad lo justifiquen (sin costo adicional en Donweb — SQLite es un archivo, no un servicio externo).

### 7.1 Estructura de `storage/claves-temporales.json`

```json
{
  "claves": [
    {
      "id": "uuid-v4",
      "nombre": "Municipio Tinoco — demo mayo 2026",
      "hash": "$2y$10$...",
      "vencimiento": "2026-05-31T23:59:59",
      "limite_usos": 5,
      "usos": 0,
      "alcance": "version_actual",
      "activa": true
    }
  ]
}
```

### 7.2 Estructura de `storage/bitacora.json`

```json
{
  "eventos": [
    {
      "timestamp": "2026-04-30T10:00:00Z",
      "evento": "descarga",
      "clave_id": "uuid-v4",
      "archivo": "AppAlcaldia-v1.2.3.zip",
      "ip_hash": "sha256-de-la-ip"
    },
    {
      "timestamp": "2026-04-30T09:55:00Z",
      "evento": "login_fallido",
      "ip_hash": "sha256-de-la-ip"
    }
  ]
}
```

### 7.3 Regla de escritura de JSON

Toda operación de lectura/escritura sobre archivos JSON debe usar file lock para evitar corrupción:

```php
$fp = fopen($path, 'c+');
flock($fp, LOCK_EX);
// leer / modificar / escribir
flock($fp, LOCK_UN);
fclose($fp);
```

---

## 8. Gestión de Versiones de la App de Escritorio

- Siempre hay **una única versión activa** en `storage/releases/`.
- Formato de nombre de archivo: `AppAlcaldia-vX.Y.Z.zip` (semver estricto).
- La versión activa actual se registra en `storage/releases/version.json`.

```json
{
  "version": "1.2.3",
  "archivo": "AppAlcaldia-v1.2.3.zip",
  "publicado": "2026-04-30T10:00:00Z"
}
```

Protocolo al subir una nueva versión:
1. Mover la versión actual a `storage/releases/backup/YYYYMMDD-HHMM/`
2. Colocar el nuevo archivo en `storage/releases/`
3. Actualizar `version.json`
4. Purgar backups con más de 7 días

---

## 9. Fases de Desarrollo

Referencia completa: `docs/Definicion de proyecto/brief-ia-rutas-y-descargas.md`

| Fase | Descripción | Estado |
|------|-------------|--------|
| 0 | Preparación: credenciales FTP, estructura de carpetas | Pendiente |
| 1 | Base técnica: CI4 instalado, rutas base, vistas placeholder | Pendiente |
| 2 | Descargas protegidas: login, sesión, descarga firmada | Pendiente |
| 3 | Claves temporales + bitácora de uso | Pendiente |
| 4 | Operación de versiones: backup y rollback | Pendiente |
| 5 | Panel web de subida por ZIP (opcional) | Backlog |

Prompt estándar para implementar una fase:

```
Implementa la Fase X del brief en docs/Definicion de proyecto/brief-ia-rutas-y-descargas.md.
Usa CodeIgniter 4. Respeta la arquitectura CI4 del AGENTS.md (Controllers, Filters, Routes, Views, Services),
aplica todas las reglas de seguridad de la sección 6 y verifica compatibilidad con Donweb.
No crear routers ni middlewares custom — usar los de CI4.
Entregá cambios por archivo + explicación breve + riesgos + siguiente paso.
```

---

## 10. Reglas para Agentes de IA

Estas reglas definen el comportamiento esperado de cualquier agente que trabaje en este proyecto.

### Antes de codear

- Leer `AGENTS.md` completo antes de proponer cualquier cambio.
- Verificar en qué fase del proyecto se está trabajando (sección 9).
- Si hay dudas de compatibilidad con Donweb, consultar `docs/Definicion de proyecto/donweb-centro-ayuda-fuentes.md`.

### Durante la implementación

- **Nunca** proponer un router PHP custom — CI4 tiene `Routes.php`.
- **Nunca** crear middlewares custom — usar Filters de CI4.
- **Nunca** escribir lógica de negocio en controllers ni en vistas.
- **Nunca** omitir las reglas de seguridad de la sección 6.
- **Nunca** instalar librerías externas sin justificar la necesidad y verificar compatibilidad con Donweb.
- **Nunca** usar colores, tipografías o gradientes fuera de los definidos en la sección 5.
- **Nunca** hardcodear credenciales, passwords o rutas absolutas de servidor.
- **Siempre** respetar separación frontend: HTML en vistas, CSS en `public/css`, JS en `public/js`, sin inline CSS/JS.
- **Siempre** extraer componentes visuales repetidos (fondos decorativos, navbar, bloques UI comunes) a estilos reutilizables en lugar de duplicarlos por vista.
- Comentarios en código y documentación técnica redactados en **español**.
- Excepción de idioma: archivos generados o instalados por librerías/frameworks de terceros (por ejemplo, archivos base de CI4). Esos contenidos pueden permanecer en su idioma original.

### Documentación técnica mínima obligatoria

- Todo archivo nuevo o modificado debe iniciar con un bloque breve de documentación en español que explique:
  - objetivo del archivo,
  - qué componentes incluye (clases, funciones, vistas o estilos),
  - variables o constantes relevantes,
  - dependencias críticas si aplica.
- Toda función o método debe tener encima un comentario breve en español con:
  - propósito,
  - parámetros esperados,
  - retorno esperado,
  - efectos colaterales importantes (si existen).
- Todo bloque de lógica no trivial debe tener un comentario breve en español que indique la intención del bloque.
- La documentación debe ser formal, profesional y mínima: sin texto redundante, sin explicación obvia línea por línea y orientada a lectura humana + interpretación por IA con bajo costo de tokens.
- Mantener coherencia con el lenguaje del archivo:
  - PHP: PHPDoc o comentario de bloque corto.
  - JS/CSS/HTML: comentario de bloque o de línea breve.

#### Plantilla operativa recomendada (copiar y adaptar)

- Encabezado de archivo (4 líneas máximo):
  - Qué resuelve este archivo.
  - Qué contiene internamente (clases, funciones, vistas, reglas CSS, etc.).
  - Variables/constantes clave.
  - Dependencias críticas si aplica.
- Encabezado de función/método (3 líneas máximo):
  - Propósito de la función.
  - Parámetros de entrada y formato esperado.
  - Retorno y efecto colateral relevante.
- Encabezado de bloque no trivial (1-2 líneas):
  - Intención del bloque y criterio de decisión principal.

#### Ejemplo mínimo PHP

```php
/**
 * Gestiona la validación de claves temporales para descargas.
 * Contiene reglas de vencimiento, usos y activación de clave.
 * Variables clave: $clave, $ahora, $maxUsos.
 */
```

```php
/**
 * Verifica si una clave puede usarse en esta request.
 * @param array $clave Estructura de clave temporal validada.
 * @return bool true si cumple vigencia y límite de usos.
 */
```

#### Ejemplo mínimo JS/CSS/HTML

```js
// Inicializa el carrusel principal y sincroniza indicadores activos.
```

```css
/* Define variables de color base para mantener identidad visual institucional. */
```

### Al entregar cambios

- Entregar **archivo por archivo** con una explicación breve de qué hace y por qué.
- Incluir siempre: **riesgos identificados** y **siguiente paso recomendado**.
- No subir a producción sin validación explícita del desarrollador.
- Si una propuesta difiere del AGENTS.md, señalarlo explícitamente antes de implementar.
- Mensajes de commit: en **español**, formales y descriptivos, manteniendo formato de conventional commits cuando aplique.

---

## 11. Documentación del Proyecto

| Archivo | Contenido |
|---------|-----------|
| `docs/Definicion de proyecto/proyecto.md` | Visión general, secciones de la landing, paleta, tipografía |
| `docs/Definicion de proyecto/arquitectura-web-php-rutas-descargas.md` | Arquitectura CI4 completa, mapeo Node→CI4, plan de fases |
| `docs/Definicion de proyecto/brief-ia-rutas-y-descargas.md` | Brief de implementación por fases para agentes IA |
| `docs/Definicion de proyecto/donweb-centro-ayuda-fuentes.md` | Fuentes oficiales Donweb, compatibilidad CI4 verificada |
| `docs/EcoGentlemanAI/` | Ecosistema Gentleman Programming (Engram, SDD, Skills) |
| `docs/diseño/` | Assets de diseño: logos, favicon, folletos originales |

---

## 12. Skills Locales del Repositorio

Cuando el contexto del cambio aplique, los agentes deben cargar y respetar las skills locales del proyecto.

| Skill | Propósito | Archivo |
|------|-----------|---------|
| `alcaldia-ui-conventions` | Convenciones UI/CSS/JS para vistas, navbar, fondos decorativos y reutilización de componentes | [skills/alcaldia-ui-conventions/SKILL.md](skills/alcaldia-ui-conventions/SKILL.md) |
