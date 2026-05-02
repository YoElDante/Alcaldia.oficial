<?php /* Layout exclusivo de la landing home con navbar de anclas internas.
   Incluye partials/head, partials/footer y el botón flotante de WhatsApp.
   Variables: $title, $description (opcionales, con defaults en head.php).
   Dependencia: layouts no hereda de otro layout. */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->include('partials/head') ?>
    <link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
</head>
<body>

  <header id="navbar">
    <nav class="nav-container">
      <a href="#hero" class="logo">
        <img src="<?= base_url('assets/alcaldia-logo.svg') ?>" alt="ALCALD+IA Logo">
      </a>
      <button class="hamburger" id="hamburger" aria-label="Menú">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul class="nav-links" id="navLinks">
        <li><a href="#hero">Inicio</a></li>
        <li><a href="#sobre">Qué es</a></li>
        <li><a href="#producto">Características</a></li>
        <li><a href="#portal">Portal de Pago</a></li>
        <li><a href="#portal-demo">Portal Demo</a></li>
        <li><a href="#sobre-nosotros">Nosotros</a></li>
        <li><a href="#contacto">Contacto</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <?= $this->renderSection('content') ?>
  </main>

  <?= $this->include('partials/footer') ?>
  <?= $this->include('partials/whatsapp') ?>

  <script src="<?= base_url('js/main.js') ?>"></script>
</body>
</html>
