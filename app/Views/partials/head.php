<?php /* Partial de cabecera HTML compartido por todos los layouts.
   Centraliza favicon, fuentes y hoja de estilos en un solo lugar.
   Variables: $title (string), $description (string, opcional).
   Dependencia: public/css/main.css, assets/alcaldia-logo.ico. */ ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= esc($description ?? 'ALCALD+IA - Sistema de Gestión Municipal y Comunal con arquitectura inteligente') ?>">
<title><?= esc($title ?? 'ALCALD+IA') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/main.css') ?>">
<link rel="icon" type="image/x-icon" href="<?= base_url('assets/alcaldia-logo.ico') ?>">
