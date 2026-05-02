<?php /* Layout base para páginas interiores (pagos, tutoriales, descargas).
   Navbar con rutas absolutas, flexbox para sticky footer garantizado.
   Variables: $title, $description (opcionales, con defaults en head.php).
   Dependencia: partials/head, partials/footer, public/js/main.js. */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->include('partials/head') ?>
</head>
<body style="display:flex; flex-direction:column; min-height:100vh;">

<header id="navbar">
    <nav class="nav-container">
        <a href="<?= site_url('/') ?>" class="logo">
            <img src="<?= base_url('assets/alcaldia-logo.svg') ?>" alt="ALCALD+IA Logo">
        </a>
        <button class="hamburger" id="hamburger" aria-label="Menú">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-links" id="navLinks">
            <li><a href="<?= site_url('/') ?>">Inicio</a></li>
            <li><a href="<?= site_url('/pagos') ?>">Pagos</a></li>
            <li><a href="<?= site_url('/tutoriales') ?>">Tutoriales</a></li>
            <li><a href="<?= site_url('/descargas') ?>">Descargas</a></li>
        </ul>
    </nav>
</header>

<main style="flex:1; padding-top:90px;">
    <?= $this->renderSection('content') ?>
</main>

<?= $this->include('partials/footer') ?>
<?= $this->include('partials/whatsapp') ?>

<script src="<?= base_url('js/main.js') ?>"></script>
</body>
</html>
