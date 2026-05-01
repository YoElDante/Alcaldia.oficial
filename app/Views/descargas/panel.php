<?php
/**
 * Vista del panel de descargas protegidas.
 * Renderiza el catalogo autorizado y enlaces de descarga autenticada con token HMAC firmado.
 * Variables esperadas: $files con name, size_formatted, modified_formatted, download_url.
 * Dependencias: layouts/main, site_url.
 */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section style="padding:48px 0;">
    <div class="container">
        <h1>Panel de Descargas</h1>
        <p>Selecciona un archivo para iniciar la descarga protegida.</p>

        <?php if (empty($files)): ?>
            <div style="background:var(--color-warning-bg); color:var(--color-warning-text); border:1px solid var(--color-warning-border); padding:12px; margin:16px 0;">
                No hay archivos disponibles en la carpeta de distribucion.
            </div>
        <?php else: ?>
            <div style="overflow-x:auto; margin:20px 0;">
                <table style="width:100%; border-collapse:collapse; background:var(--color-white);">
                    <thead>
                        <tr style="background:var(--color-table-header);">
                            <th style="text-align:left; padding:10px; border:1px solid var(--color-table-border);">Archivo</th>
                            <th style="text-align:left; padding:10px; border:1px solid var(--color-table-border);">Tamano (MB)</th>
                            <th style="text-align:left; padding:10px; border:1px solid var(--color-table-border);">Actualizado</th>
                            <th style="text-align:left; padding:10px; border:1px solid var(--color-table-border);">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <tr>
                                <td style="padding:10px; border:1px solid var(--color-table-border);"><?= esc($file['name']) ?></td>
                                <td style="padding:10px; border:1px solid var(--color-table-border);"><?= esc($file['size_formatted']) ?></td>
                                <td style="padding:10px; border:1px solid var(--color-table-border);"><?= esc($file['modified_formatted']) ?></td>
                                <td style="padding:10px; border:1px solid var(--color-table-border);">
                                    <a class="btn btn-primary" href="<?= esc($file['download_url']) ?>">Descargar</a>
                                </td>
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
