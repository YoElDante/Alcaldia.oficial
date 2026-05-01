<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section id="hero" class="bg-hero">
    <div class="container" style="text-align:center; color:#fff;">
        <h1>SIMPLIFIQUE, CONTROLE Y TRANSFORME SU GESTION</h1>
        <p style="max-width:760px; margin:16px auto 0;">
            Portal institucional de ALCALD+IA en CodeIgniter 4.
            Esta base queda preparada para continuar con rutas protegidas, pagos y tutoriales.
        </p>
        <div style="margin-top:24px;">
            <a class="btn-primary" href="<?= site_url('/descargas') ?>">Ir a Descargas</a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
