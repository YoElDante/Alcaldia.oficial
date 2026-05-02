<?php
/**
 * Vista del formulario de login para la seccion de descargas.
 * Muestra error de clave invalida si aplica.
 * Variables esperadas: $error string o null.
 * Dependencias: layouts/main, CSRF, site_url.
 */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/descargas.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="bg-section-alt descargas-section">

    <!-- Decoraciones: mismos colores que sección Características de la landing -->
    <div class="decoration-circle circle-outline-dark" style="top:-5%; right:8%;"></div>
    <div class="decoration-circle circle-outline-dark" style="bottom:-5%; left:5%;"></div>
    <div class="decoration-dots dots-dark" style="top:3%; left:6%;"></div>
    <div class="decoration-dots dots-dark" style="bottom:5%; right:5%;"></div>
    <div class="decoration-bar bar-horizontal-dark" style="top:6%; right:12%;"></div>
    <div class="decoration-bar bar-horizontal-dark" style="bottom:6%; left:0;"></div>

    <div class="container descargas-container">
        <h1 class="section-title">Descargas</h1>
        <p class="section-subtitle">Ingresa tu clave temporal para acceder al panel de descargas.</p>

        <?php if (! empty($error)): ?>
            <div class="alert alert-error"><?= esc($error) ?></div>
        <?php endif; ?>

        <form class="descargas-form" method="post" action="<?= site_url('/descargas/login') ?>">
            <?= csrf_field() ?>
            <label for="password">Clave temporal</label>
            <input id="password" name="password" type="password" required>
            <button class="btn btn-primary" type="submit">Ingresar</button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
