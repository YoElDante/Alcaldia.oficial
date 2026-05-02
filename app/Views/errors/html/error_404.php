<?php /* Vista 404 amigable para navegacion publica.
   Mantiene identidad visual y ofrece retorno directo al inicio.
   Variables clave: $message para entorno no productivo. */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALCALD+IA | Página no encontrada</title>
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
                radial-gradient(circle at top left, rgba(0, 168, 181, 0.2), transparent 30%),
                linear-gradient(160deg, var(--color-dark) 0%, var(--color-primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .wrap {
            width: min(100%, 760px);
            background: rgba(255, 255, 255, 0.97);
            border-radius: 24px;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.18);
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            color: var(--color-dark);
            text-decoration: none;
            font-weight: 600;
        }

        .logo img {
            width: 44px;
            height: 44px;
        }

        h1 {
            margin: 0 0 12px;
            font-family: 'Oswald', sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            text-transform: uppercase;
            font-weight: 700;
            color: var(--color-dark);
        }

        p {
            margin: 0 auto;
            max-width: 54ch;
            line-height: 1.7;
        }

        .actions {
            display: flex;
            justify-content: center;
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
        }

        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
            cursor: pointer;
        }

        .btn-secondary {
            background: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
            cursor: pointer;
        }

        code {
            display: inline-block;
            margin-top: 14px;
            padding: 10px 14px;
            border-radius: 12px;
            background: var(--color-light-bg);
            color: var(--color-dark);
        }

        @media (max-width: 768px) {
            .wrap {
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
    <section class="wrap">
        <a class="logo" href="/">
            <img src="/assets/alcaldia-logo.svg" alt="ALCALD+IA">
            <span>ALCALD+IA</span>
        </a>

        <h1>404</h1>
        <?php /* Mostrar mensaje técnico solo fuera de producción para no exponer detalles internos al usuario final. */ ?>
        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                <?= esc(lang('Errors.sorryCannotFind')) ?>
            <?php endif; ?>
        </p>

        <div class="actions">
            <a class="btn btn-primary" href="/">Volver al inicio</a>
            <a class="btn btn-secondary" href="/descargas">Ir a descargas</a>
        </div>

        <?php /* En desarrollo se imprime el mensaje crudo para acelerar diagnóstico durante pruebas. */ ?>
        <?php if (ENVIRONMENT !== 'production') : ?>
            <code><?= esc($message) ?></code>
        <?php endif; ?>
    </section>
</body>
</html>
