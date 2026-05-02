<?php /* Partial de cabecera HTML compartido por todos los layouts.
   Centraliza favicon, fuentes y shared-components.css.
   main.css se carga exclusivamente en layouts/home.php (landing).
   Variables: $title (string), $description (string, opcional). */ ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= esc($description ?? 'ALCALD+IA - Sistema de Gestión Municipal y Comunal con arquitectura inteligente') ?>">
<title><?= esc($title ?? 'ALCALD+IA') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/shared-components.css') ?>">
<link rel="icon" type="image/x-icon" href="<?= base_url('assets/alcaldia-logo.ico') ?>">
