<?php /* Vista institucional de la ruta /tutoriales.
    Presenta recursos de capacitación por etapas para usuarios municipales.
    Dependencias: layouts/main y main.css para reutilizar componentes institucionales. */ ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section id="tutoriales-hero" class="bg-section-alt internal-hero-section bg-decoration-canvas">
    <div class="decoration-dots dots-turquesa" style="top:8%; right:5%;"></div>
    <div class="decoration-dots dots-dark" style="bottom:10%; left:3%;"></div>
    <div class="decoration-circle circle-outline" style="top:5%; left:8%;"></div>
    <div class="container container-narrow text-center section-content-layer">
        <h1 class="section-title">Tutoriales</h1>
        <p class="section-subtitle centered-block">
            Biblioteca práctica para adoptar ALCALD+IA con procesos claros,
            desde el alta inicial hasta la operación diaria.
        </p>
    </div>
</section>

<section id="tutoriales-rutas" class="internal-section-tight-top">
    <div class="container">
        <div class="features-grid">
            <article class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Primeros pasos</h3>
                <p>Configuración inicial del entorno, acceso de usuarios y estructura base de trabajo.</p>
            </article>

            <article class="feature-card">
                <div class="feature-icon">🧾</div>
                <h3>Gestión contable</h3>
                <p>Flujo recomendado para registrar operaciones y mantener consistencia presupuestaria.</p>
            </article>

            <article class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Reportes y control</h3>
                <p>Generación de reportes, análisis de resultados y seguimiento de indicadores clave.</p>
            </article>
        </div>
    </div>
</section>

<section id="tutoriales-itinerario" class="bg-section-alt">
    <div class="container">
        <h2 class="section-title">Itinerario de Capacitación</h2>
        <div class="portal-benefits">
            <article class="benefit-card benefit-contribuyente">
                <div class="benefit-icon">🎯</div>
                <h3>Nivel operativo</h3>
                <ul>
                    <li>Carga de datos y navegación de módulos principales.</li>
                    <li>Resolución de tareas frecuentes del equipo administrativo.</li>
                    <li>Buenas prácticas para reducir errores de operación diaria.</li>
                    <li>Checklist de cierre operativo por jornada.</li>
                </ul>
            </article>

            <article class="benefit-card benefit-municipio">
                <div class="benefit-icon">🧠</div>
                <h3>Nivel estratégico</h3>
                <ul>
                    <li>Lectura de tableros e indicadores para toma de decisiones.</li>
                    <li>Seguimiento de recaudación y comportamiento de deuda.</li>
                    <li>Definición de prioridades con base en evidencia.</li>
                    <li>Preparación de información para autoridades y auditoría.</li>
                </ul>
            </article>
        </div>
    </div>
</section>

<section id="tutoriales-acceso" class="internal-section-standard-top bg-decoration-canvas">
    <div class="decoration-bar bar-horizontal" style="top:20%; left:10%;"></div>
    <div class="decoration-dots dots-turquesa" style="bottom:8%; right:12%;"></div>
    <div class="container container-medium text-center section-content-layer">
        <h2 class="section-title">Acceso a Recursos</h2>
        <p class="portal-description margin-bottom-26">
            Estamos consolidando el repositorio de guías paso a paso, videos y material de soporte.
            Mientras tanto, podés solicitar asistencia personalizada para tu equipo.
        </p>
        <a href="https://wa.me/5493515575700?text=Hola,%20necesito%20capacitaci%C3%B3n%20sobre%20ALCALD+IA"
           class="btn btn-whatsapp"
           target="_blank"
           rel="noopener noreferrer">
            <img src="<?= base_url('assets/whatsapp-icon.svg') ?>" alt="WhatsApp">
            Solicitar capacitación
        </a>
    </div>
</section>
<?= $this->endSection() ?>
