<?php /* Partial de pie de página compartido por todos los layouts.
   Contiene logo, enlaces de sección, contacto y enlace al portal demo.
   Variables: ninguna (usa current_year() del helper app).
   Dependencia: assets/alcaldia-logo.webp, helper app. */ ?>
<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <img src="<?= base_url('assets/alcaldia-logo.webp') ?>" alt="ALCALD+IA" class="footer-logo">
                <p>Gestión Municipal Inteligente</p>
            </div>

            <div class="footer-links">
                <h4>Enlaces</h4>
                <ul>
                    <li><a href="<?= site_url('/') ?>#hero">Inicio</a></li>
                    <li><a href="<?= site_url('/') ?>#sobre">Qué es ALCALD+IA</a></li>
                    <li><a href="<?= site_url('/') ?>#producto">Características</a></li>
                    <li><a href="<?= site_url('/') ?>#contacto">Contacto</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contacto</h4>
                <p>📞 0351-155575700</p>
                <p>✉️ info@alcaldia.com.ar</p>
                <p>🌐 <a href="https://www.alcaldia.com.ar" target="_blank">www.alcaldia.com.ar</a></p>
            </div>

            <div class="footer-demo">
                <h4>Portal Demo</h4>
                <ul>
                    <li>
                        <a href="https://demo.alcaldia.com.ar" target="_blank" rel="noopener noreferrer">
                            🧪 demo.alcaldia.com.ar
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= current_year() ?> ALCALD+IA. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
