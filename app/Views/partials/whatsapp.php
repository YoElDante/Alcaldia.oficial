<?php /* Boton flotante de WhatsApp reutilizable para todas las vistas.
   Centraliza URL de contacto y fallback de icono para mantener consistencia.
   Variables: ninguna (usa assets públicos del proyecto). */ ?>
<a href="https://wa.me/5493515575700?text=Hola,%20quiero%20info%20sobre%20ALCALD+IA"
   class="whatsapp-float"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Contactar por WhatsApp">
   <img src="<?= base_url('assets/whatsapp-icon.svg') ?>" alt="WhatsApp">
</a>