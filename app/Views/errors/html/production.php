<?php /* Vista de error generica para produccion.
   Mantiene branding, favicon y acceso claro de retorno al inicio.
   Variables clave: textos de lang() para encabezado y descripcion. */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>ALCALD+IA | Error del sitio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/alcaldia-logo.ico">
    <style>
        :root {
            --color-primary: #00A8B5;
            --color-dark: #003E5C;
            --color-light-bg: #E0F7FA;
            --color-white: #FFFFFF;
            --color-secondary: #F5F5F5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            color: var(--color-dark);
            background:
                radial-gradient(circle at top right, rgba(0, 168, 181, 0.18), transparent 25%),
                linear-gradient(135deg, var(--color-dark) 0%, var(--color-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .error-card {
            width: min(100%, 760px);
            background: rgba(255, 255, 255, 0.96);
            border-radius: 24px;
            padding: 40px 32px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: var(--color-dark);
            text-decoration: none;
            font-weight: 600;
        }

        .brand img {
            width: 42px;
            height: 42px;
        }

        h1 {
            margin: 0 0 12px;
            font-family: 'Oswald', sans-serif;
            font-size: clamp(2rem, 5vw, 3.4rem);
            line-height: 1;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--color-dark);
        }

        p {
            margin: 0;
            font-size: 1rem;
            line-height: 1.7;
        }

        .lead {
            margin-bottom: 12px;
            font-size: 1.05rem;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 20px;
            border-radius: 4px;
            text-decoration: none;
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
            cursor: pointer;
        }

        .btn-secondary {
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            background: transparent;
            cursor: pointer;
        }

        .note {
            margin-top: 20px;
            padding: 16px 18px;
            border-radius: 16px;
            background: var(--color-light-bg);
        }

        @media (max-width: 768px) {
            .error-card {
                padding: 28px 20px;
                border-radius: 16px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <section class="error-card" aria-labelledby="error-title">
        <a class="brand" href="/">
            <img src="/assets/alcaldia-logo.svg" alt="ALCALD+IA">
            <span>ALCALD+IA</span>
        </a>

        <h1 id="error-title"><?= esc(lang('Errors.whoops')) ?></h1>
        <p class="lead">Estamos teniendo un inconveniente temporal para mostrar esta sección.</p>
        <p><?= esc(lang('Errors.weHitASnag')) ?> Podés volver al inicio e intentarlo nuevamente en unos minutos.</p>

        <div class="actions">
            <a class="btn btn-primary" href="/">Volver al inicio</a>
            <a class="btn btn-secondary" href="/descargas">Reintentar</a>
        </div>

        <div class="note">
            Si el problema persiste, escribinos por WhatsApp o volvé a cargar la página más tarde.
        </div>
    </section>
</body>
</html>
