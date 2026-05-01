<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section style="padding:48px 0;">
    <div class="container">
        <h1>Panel de Descargas</h1>
        <p>Placeholder de Fase 1. En Fase 2 se conecta catalogo real y descarga firmada.</p>
        <p><a class="btn-secondary" href="<?= site_url('/descargas/logout') ?>">Cerrar sesion</a></p>
    </div>
</section>
<?= $this->endSection() ?>
