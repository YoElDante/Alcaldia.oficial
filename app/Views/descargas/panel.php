<?php
/**
 * Vista del panel de descargas protegidas.
 * Renderiza el catalogo autorizado y enlaces de descarga autenticada con token HMAC firmado.
 * Variables esperadas: $files con name, size_formatted, modified_formatted, download_url.
 * Dependencias: layouts/main, site_url.
 */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/descargas.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="descargas-section">

    <!-- Decoraciones: círculos outline turquesa y puntos a la derecha -->
    <div class="decoration-circle circle-outline" style="top:-30px; right:6%; width:160px; height:160px;"></div>
    <div class="decoration-circle circle-outline" style="bottom:40px; right:3%; width:100px; height:100px;"></div>
    <div class="decoration-dots dots-turquesa" style="top:60px; right:4%; width:90px; height:90px;"></div>
    <div class="decoration-dots dots-turquesa" style="bottom:80px; right:10%; width:70px; height:70px;"></div>
    <div class="decoration-bar bar-horizontal" style="top:80px; right:15%;"></div>

    <div class="container" style="position:relative; z-index:1;">
        <h1 class="section-title">Panel de Descargas</h1>
        <p class="section-subtitle">Selecciona un archivo para iniciar la descarga protegida.</p>

        <?php if (empty($files)): ?>
            <div class="alert alert-warning">
                No hay archivos disponibles en la carpeta de distribucion.
            </div>
        <?php else: ?>
            <div class="descargas-table-wrapper">
                <table class="descargas-table">
                    <thead>
                        <tr>
                            <th>Archivo</th>
                            <th>Tamano (MB)</th>
                            <th>Actualizado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <tr>
                                <td><?= esc($file['name']) ?></td>
                                <td><?= esc($file['size_formatted']) ?></td>
                                <td><?= esc($file['modified_formatted']) ?></td>
                                <td><a class="btn btn-primary" href="<?= esc($file['download_url']) ?>">Descargar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <p><a class="btn btn-secondary" href="<?= site_url('/descargas/logout') ?>">Cerrar sesion</a></p>
    </div>
</section>
<?= $this->endSection() ?>
