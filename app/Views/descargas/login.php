<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="bg-section-alt" style="padding:48px 0;">
    <div class="container" style="max-width:520px;">
        <h1>Descargas</h1>
        <p>Ingresa tu clave temporal para acceder al panel de descargas.</p>

        <?php if (! empty($error)): ?>
            <div style="background:#ffdede; color:#7a1f1f; border:1px solid #e5a4a4; padding:12px; margin:16px 0;">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('/descargas/login') ?>">
            <?= csrf_field() ?>
            <label for="password">Clave temporal</label>
            <input id="password" name="password" type="password" required style="display:block; width:100%; padding:10px; margin:8px 0 16px;">
            <button class="btn-primary" type="submit">Ingresar</button>
        </form>
    </div>
</section>
<?= $this->endSection() ?>
