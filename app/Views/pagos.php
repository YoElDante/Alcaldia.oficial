<?php /* Vista institucional de la ruta /pagos.
   Presenta canales de cobro y beneficios para contribuyentes y municipio.
   Dependencias: layouts/main, clases de main.css, enlaces externos de demo. */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section id="pagos-hero" class="bg-section-alt" style="padding: 70px 0 40px;">
    <div class="container" style="text-align:center; max-width: 900px;">
        <h1 class="section-title">Pagos Municipales</h1>
        <p class="section-subtitle" style="margin: 0 auto;">
            Canal unificado para consulta y pago de obligaciones municipales,
            diseñado para simplificar la experiencia del contribuyente y mejorar la recaudación.
        </p>
    </div>
</section>

<section id="pagos-beneficios" style="padding-top: 30px;">
    <div class="container">
        <div class="portal-benefits">
            <article class="benefit-card benefit-contribuyente">
                <div class="benefit-icon">👤</div>
                <h3>Para el contribuyente</h3>
                <ul>
                    <li>Consulta de deuda actualizada desde cualquier dispositivo.</li>
                    <li>Pago online en cualquier momento, sin traslado ni esperas.</li>
                    <li>Comprobante digital descargable al finalizar cada operación.</li>
                    <li>Seguimiento claro de obligaciones vencidas y próximas.</li>
                </ul>
            </article>

            <article class="benefit-card benefit-municipio">
                <div class="benefit-icon">🏛️</div>
                <h3>Para la administración</h3>
                <ul>
                    <li>Menor carga operativa en atención presencial y telefónica.</li>
                    <li>Mayor trazabilidad del ciclo de cobro y conciliación.</li>
                    <li>Mejora de tiempos administrativos y control financiero.</li>
                    <li>Experiencia digital alineada con la identidad institucional.</li>
                </ul>
            </article>
        </div>
    </div>
</section>

<section id="pagos-canales" class="bg-section-alt">
    <div class="container">
        <h2 class="section-title">Canales de Pago</h2>
        <div class="portal-payment-info">
            <div class="payment-current">
                <img src="<?= base_url('assets/images/SIRO_LOGO.webp') ?>" alt="SIRO" class="payment-logo">
                <div>
                    <div class="payment-badge">
                        <span class="payment-icon">✅</span>
                        <span>Integración activa</span>
                    </div>
                    <p>
                        Actualmente operamos con <strong>SIRO (Banco Roela)</strong>,
                        con acreditación directa en la cuenta designada por el municipio o la comuna.
                    </p>
                </div>
            </div>

            <div class="payment-future">
                <span class="future-badge">Próximamente</span>
                <p>MercadoPago y PagoTic según convenios y estrategia de cobranza local.</p>
            </div>
        </div>

        <div style="text-align:center; margin-top: 30px;">
            <a class="demo-link-btn" href="https://demo.alcaldia.com.ar" target="_blank" rel="noopener noreferrer">
                Ver Portal Demo de Pagos
            </a>
        </div>
    </div>
</section>

<section id="pagos-soporte" style="padding-top: 70px;">
    <div class="container">
        <h2 class="section-title">Soporte de Implementación</h2>
        <div class="features-grid">
            <article class="feature-card">
                <div class="feature-icon">⚙️</div>
                <h3>Puesta en marcha guiada</h3>
                <p>Configuración inicial asistida y validación de parámetros operativos del municipio.</p>
            </article>
            <article class="feature-card">
                <div class="feature-icon">📘</div>
                <h3>Capacitación funcional</h3>
                <p>Entrenamiento práctico para personal administrativo y responsables de recaudación.</p>
            </article>
            <article class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Acompañamiento continuo</h3>
                <p>Seguimiento posterior al lanzamiento para asegurar estabilidad y adopción.</p>
            </article>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
