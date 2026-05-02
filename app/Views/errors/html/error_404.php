<?php
/* Vista 404 amigable para navegacion publica.
   Variables esperadas: $urlNoEncontrada (procesada por ErrorsController::notFound). */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALCALD+IA | Página no encontrada</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/alcaldia-logo.ico">
    <link rel="stylesheet" href="/css/shared-components.css">
    <link rel="stylesheet" href="/css/error-view.css">
    <script src="/js/error-404.js" defer></script>
</head>
<body class="error-page">
    <div class="dots-pattern dots-top-left"></div>
    <div class="dots-pattern dots-bottom-right"></div>
    <div class="dots-pattern dots-middle-left"></div>

    <div class="hero-circle hero-circle-1"></div>
    <div class="hero-circle hero-circle-2"></div>
    <div class="hero-circle hero-circle-3"></div>

    <div class="section-diagonal-bars bars-left bars-light">
        <div class="diagonal-bar"></div>
        <div class="diagonal-bar"></div>
        <div class="diagonal-bar"></div>
    </div>
    <div class="section-diagonal-bars bars-right bars-light">
        <div class="diagonal-bar"></div>
        <div class="diagonal-bar"></div>
        <div class="diagonal-bar"></div>
    </div>

    <section class="wrap">
        <a class="logo" href="/">
            <img src="/assets/alcaldia-logo.webp" alt="ALCALD+IA">
        </a>

        <h1>404</h1>
        <p>
            No se pudo encontrar la ruta solicitada en <?= esc($urlNoEncontrada) ?>.
        </p>

        <div class="actions">
            <a class="btn btn-primary" href="/">Volver al inicio</a>
            <button class="btn btn-secondary" id="volverAnterior" type="button">Volver a página anterior</button>
        </div>

        <p class="help-text">Si usted considera que esto es un error, por favor póngase en contacto con el área de soporte de ALCALD+IA.</p>
    </section>
</body>
</html>
