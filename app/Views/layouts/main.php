<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ALCALD+IA') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
</head>
<body>
<header id="navbar" class="bg-navbar">
    <nav class="nav-container">
        <a href="<?= site_url('/') ?>" class="logo">ALCALD+IA</a>
        <ul class="nav-links" id="navLinks">
            <li><a href="<?= site_url('/') ?>">Inicio</a></li>
            <li><a href="<?= site_url('/pagos') ?>">Pagos</a></li>
            <li><a href="<?= site_url('/tutoriales') ?>">Tutoriales</a></li>
            <li><a href="<?= site_url('/descargas') ?>">Descargas</a></li>
        </ul>
    </nav>
</header>
<main style="padding-top: 90px; min-height: calc(100vh - 160px);">
    <?= $this->renderSection('content') ?>
</main>
<footer class="bg-footer" style="padding: 24px; text-align: center;">
    <p>ALCALD+IA - Gestion Municipal Inteligente</p>
</footer>
<script src="<?= base_url('js/main.js') ?>"></script>
</body>
</html>
