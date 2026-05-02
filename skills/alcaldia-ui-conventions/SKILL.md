---
name: alcaldia-ui-conventions
description: >
  Sistema CSS y convenciones UI del proyecto Alcaldia Web Oficial.
  Documenta la arquitectura de tres archivos CSS, el sistema de decoraciones,
  botones, layout de vistas internas y las reglas de uso para nuevas vistas.
  Trigger: usar cuando se creen o modifiquen vistas, estilos CSS, fondos decorativos
  o cualquier componente frontend.
license: Apache-2.0
metadata:
  author: gentleman-programming
  version: "2.0"
---

## When to Use

- Cuando se crea cualquier vista nueva (pagos, tutoriales, descargas, error, etc.)
- Cuando se agregan o refactorizan estilos CSS
- Cuando se incorporan botones, navbar, fondos decorativos o secciones
- Cuando se evalúa dónde poner un estilo nuevo (shared vs. módulo vs. landing)

---

## Arquitectura CSS — Tres archivos, responsabilidades estrictas

| Archivo | Se carga en | Responsabilidad |
|---------|-------------|-----------------|
| `public/css/shared-components.css` | TODAS las vistas | Variables (`:root`), navbar, botones, layout interno, fondos institucionales, sistema completo de decoraciones |
| `public/css/main.css` | Solo landing (home) | Hero, carrusel, secciones específicas de home, footer |
| `public/css/error-view.css` | Solo páginas de error | Layout de pantalla de error: `.error-page`, `.wrap`, `.actions`, `.help-text` |

**Regla crítica**: Nunca redefinir `:root`, botones ni clases de decoración fuera de `shared-components.css`.

---

## Cómo cargar estilos según el tipo de vista

### Vista interna (pagos, tutoriales, descargas, panel)
Extender `layouts/main.php` — ya incluye `partials/head.php` que carga shared + main:
```php
<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
  <!-- HTML de la vista -->
<?= $this->endSection() ?>
```
No agregar `<link>` CSS adicionales, salvo para un CSS específico del módulo.

### Vista de error standalone (404, 500)
Cargar manualmente shared ANTES de error-view:
```html
<link rel="stylesheet" href="/css/shared-components.css">
<link rel="stylesheet" href="/css/error-view.css">
```

### Vista con CSS de módulo propio
Si la vista tiene estilos únicos que no se repiten en otras vistas:
```html
<!-- En partials/head.php o en el layout específico -->
<link rel="stylesheet" href="<?= base_url('css/descargas.css') ?>">
```
Ese archivo usa las variables de shared (`var(--color-primary)`) pero NO redefine `:root`.

---

## Clases de uso inmediato (shared-components.css)

### Fondos institucionales
```html
<!-- Fondo turquesa claro — secciones alternas en vistas internas -->
<section class="bg-section-alt"> ... </section>

<!-- Gradiente oscuro institucional (dark → turquesa) — fondo de pantalla completa -->
<section class="bg-institutional-gradient bg-decoration-canvas"> ... </section>
```

### Layout de vista interna
```html
<body class="layout-internal-shell">
  <main class="layout-internal-main">

    <!-- Hero de vista interna -->
    <section class="internal-hero-section bg-section-alt">
      <div class="container container-narrow text-center">
        <h1 class="section-title">Título de Sección</h1>
        <p class="section-subtitle centered-block">Descripción breve.</p>
      </div>
    </section>

    <!-- Sección estándar -->
    <section class="internal-section-tight-top">
      <div class="container">
        <!-- contenido -->
      </div>
    </section>

    <!-- Sección con separación superior estándar -->
    <section class="internal-section-standard-top">
      <div class="container container-medium text-center">
        <!-- contenido -->
      </div>
    </section>

  </main>
</body>
```

### Botones
```html
<!-- Primario: fondo turquesa -->
<a class="btn btn-primary" href="/ruta">Acción principal</a>

<!-- Secundario: outline turquesa -->
<button class="btn btn-secondary" type="button">Volver</button>

<!-- WhatsApp -->
<a class="btn btn-whatsapp" href="https://wa.me/5493515575700?text=..."
   target="_blank" rel="noopener noreferrer">
  <img src="<?= base_url('assets/whatsapp-icon.png') ?>" alt="WhatsApp">
  Texto del botón
</a>
```

---

## Sistema de Decoraciones

Todas las clases viven en `shared-components.css`. Usar directamente en HTML sin CSS adicional.

### Puntitos sobre fondo oscuro (`.dots-pattern`)
```html
<div class="dots-pattern dots-top-left"></div>
<div class="dots-pattern dots-bottom-right"></div>
<div class="dots-pattern dots-middle-left"></div>
```
Posiciones disponibles: `dots-top-left`, `dots-bottom-right`, `dots-middle-left`.

### Círculos decorativos sobre fondo oscuro (`.hero-circle`)
```html
<div class="hero-circle hero-circle-1"></div>  <!-- derecha, grande -->
<div class="hero-circle hero-circle-2"></div>  <!-- izquierda, mediano -->
<div class="hero-circle hero-circle-3"></div>  <!-- derecha baja, más grande -->
```

> **Nota de sobreescritura hero**: En la landing, `main.css` sobreescribe estos tamaños bajo `#hero .hero-circle-*` con círculos más grandes y animación `pulse`. En el resto de las vistas aplican los valores base de `shared-components.css` (pequeños, sin animación). No requiere acción del desarrollador — el sistema lo resuelve por contexto CSS.

### Decoraciones semánticas para secciones claras

Para secciones con `background-color` claro (blanco, turquesa claro), usar el sistema `decoration-*`:

```html
<!-- Puntos de color -->
<div class="decoration-dots dots-turquesa section-decoration" style="top:5%;right:3%"></div>
<div class="decoration-dots dots-dark section-decoration" style="bottom:8%;left:4%"></div>
<div class="decoration-dots dots-light section-decoration" style="top:20%;left:5%"></div>

<!-- Círculos outline -->
<div class="decoration-circle circle-outline section-decoration" style="top:10%;right:2%"></div>
<div class="decoration-circle circle-filled section-decoration" style="bottom:5%;left:3%"></div>
<div class="decoration-circle circle-light section-decoration" style="top:30%;right:8%"></div>

<!-- Barras diagonales (izquierda o derecha) -->
<div class="section-diagonal-bars bars-left bars-light">
  <div class="diagonal-bar"></div>
  <div class="diagonal-bar"></div>
  <div class="diagonal-bar"></div>
</div>
<div class="section-diagonal-bars bars-right bars-dark">
  <div class="diagonal-bar"></div>
  <div class="diagonal-bar"></div>
  <div class="diagonal-bar"></div>
</div>
```

Variantes disponibles:
- Puntos: `dots-turquesa` (0.2 opac), `dots-dark` (0.12), `dots-light` (0.4)
- Círculos: `circle-outline` (borde primary), `circle-filled` (relleno primary), `circle-outline-dark` (borde dark), `circle-light` (borde blanco)
- Barras diagonales: `bars-left` / `bars-right` + `bars-light` / `bars-dark`

---

## Reglas críticas

1. **No duplicar CSS**: si un patrón visual aparece en más de una vista, va a `shared-components.css`.
2. **No inline styles**: prohibido `style=""` en vistas excepto para posicionar decoraciones absolutas.
3. **No inline scripts**: prohibido `<script>` y handlers como `onclick` en vistas.
4. **No redefinir `:root`**: las variables CSS tienen una única definición en `shared-components.css`.
5. **Archivos en kebab-case**: `mi-componente.css`, `error-404.js`.
6. **Textos e interfaz en español**.

---

## Code Examples

```php
<?php /* Vista interna correcta — sin estilos inline, sin lógica, usa clases compartidas */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section id="mi-hero" class="bg-section-alt internal-hero-section">
    <div class="container container-narrow text-center">
        <h1 class="section-title">Mi Sección</h1>
        <p class="section-subtitle centered-block">Descripción.</p>
    </div>
</section>

<section class="internal-section-tight-top">
    <div class="container">
        <div class="features-grid">
            <article class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>Feature</h3>
                <p>Descripción.</p>
            </article>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
```

```php
<?php /* Vista de error correcta — carga shared antes que el CSS de error */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- fuentes, favicon... -->
    <link rel="stylesheet" href="/css/shared-components.css">
    <link rel="stylesheet" href="/css/error-view.css">
</head>
<body class="error-page">
    <div class="dots-pattern dots-top-left"></div>
    <div class="dots-pattern dots-bottom-right"></div>
    <div class="hero-circle hero-circle-1"></div>
    <div class="hero-circle hero-circle-2"></div>

    <section class="wrap">
        <h1>404</h1>
        <p>Página no encontrada.</p>
        <div class="actions">
            <a class="btn btn-primary" href="/">Volver al inicio</a>
        </div>
    </section>
</body>
</html>
```

---

## Commands

```bash
# Buscar inline styles/scripts que violan la convencion
rg "style=|onclick=|<style>|<script" app/Views

# Verificar archivos CSS disponibles
eza public/css public/js

# Buscar usos de bg-section-alt en vistas
rg "bg-section-alt" app/Views

# Verificar sintaxis de vistas PHP
php -l app/Views/layouts/main.php

# Verificar que :root no está redefinido fuera de shared-components.css
rg "^:root" public/css/main.css public/css/error-view.css
```

---

## Resources

- Sistema CSS: `public/css/shared-components.css` (fuente de verdad)
- Contrato del repositorio: `AGENTS.md` (sección 5 — Sistema de Diseño)
- Layout base para vistas internas: `app/Views/layouts/main.php`
- Partial de cabecera: `app/Views/partials/head.php`
