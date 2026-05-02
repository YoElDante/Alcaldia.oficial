<?php /* Vista institucional de la ruta /pagos.
    Presenta canales de cobro y beneficios para contribuyentes y municipio.
    Dependencias: layouts/main, main.css y enlaces externos de demo. */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section id="pagos-hero" class="bg-section-alt internal-hero-section bg-decoration-canvas">
    <div class="decoration-dots dots-turquesa" style="top:8%; right:5%;"></div>
    <div class="decoration-dots dots-dark" style="bottom:10%; left:3%;"></div>
    <div class="decoration-circle circle-outline" style="top:6%; left:8%;"></div>
    <div class="container container-narrow text-center section-content-layer">
        <h1 class="section-title">Pagos Municipales</h1>
        <p class="section-subtitle centered-block">
            Canal unificado para consulta y pago de obligaciones municipales,
            diseñado para simplificar la experiencia del contribuyente y mejorar la recaudación.
        </p>
    </div>
</section>

<section id="pagos-beneficios" class="internal-section-tight-top bg-decoration-canvas">
    <div class="decoration-bar bar-horizontal" style="top:12%; left:0;"></div>
    <div class="decoration-circle circle-filled" style="bottom:8%; right:4%;"></div>
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

<section id="pagos-canales" class="bg-section-alt bg-decoration-canvas">
    <div class="decoration-dots dots-turquesa" style="top:14%; left:4%;"></div>
    <div class="decoration-bar bar-horizontal-dark" style="bottom:14%; right:0;"></div>
    <div class="container section-content-layer">
        <h2 class="section-title">Canales de Pago</h2>
        <div class="portal-payment-info">
            <div class="payment-current">
                <img src="<?= base_url('assets/images/siro-logo.webp') ?>" alt="SIRO" class="payment-logo">
                <div class="payment-current-copy">
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

        <div class="text-center margin-top-30 payment-demo-cta">
            <p class="payment-demo-note">
                Al hacer clic en el botón, será redirigido al portal de pago de demostración,
                donde podrá visualizar cómo sus contribuyentes consultarían su deuda vigente y completarían el pago online desde un único punto de acceso.
            </p>
            <a class="demo-link-btn" href="https://demo.alcaldia.com.ar" target="_blank" rel="noopener noreferrer">
                <span class="demo-link-icon" aria-hidden="true">↗</span>
                <span>Ir a pagar</span>
            </a>
        </div>
    </div>
</section>

<section id="pagos-soporte" class="internal-section-standard-top bg-decoration-canvas">
    <div class="section-diagonal-bars bars-right bars-dark">
        <div class="diagonal-bar"></div>
        <div class="diagonal-bar"></div>
        <div class="diagonal-bar"></div>
    </div>
    <div class="decoration-dots dots-dark" style="top:10%; right:6%;"></div>
    <div class="container section-content-layer">
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
