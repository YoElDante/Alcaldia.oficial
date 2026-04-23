# Landing Page para ALCALD+IA: Instrucciones Detalladas para Desarrollo

## 1. Visión General del Proyecto
- **Objetivo**: Crear una landing page single-page (scroll infinito) para ALCALD+IA, un software de gestión municipal con IA. Informar sobre el software, promover demos/citas, redirigir a WhatsApp para consultas. Público: Administradores municipales y contadores de comunas. Debe transmitir profesionalismo para respaldar ventas.
- **Tecnología**: HTML/CSS/JS puro (compatible con Don Web/PHP). No frameworks. Responsive (mobile-first con media queries). Smooth scroll para navegación.
- **Estilo General**: Minimalista, corporativo, moderno. Basado en folletos: gradients diagonales en turquesa-azul, espacio blanco, icons simples (hexágonos o flechas como en PDFs). Paleta de colores:
  - Turquesa principal: #00A8B5 (acentos, botones, logo).
  - Azul oscuro: #003E5C (textos headings, footer).
  - Azul claro: #E0F7FA (fondos gradients, secciones pares).
  - Blanco: #FFFFFF (fondos principales).
  - Gris claro: #F5F5F5 (elementos secundarios).
- **Tipografías** (via Google Fonts):
  - Headings: 'Oswald' (bold, uppercase para títulos como en folletos).
  - Body: 'Open Sans' (regular/light para párrafos, legible).
  - Import: `<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@400;300&display=swap" rel="stylesheet">`
- **Assets Requeridos** (asumir en carpeta /assets/):
  - Logo: alcaldiaLogo.webp (principal).
  - Logos clientes: tinoco-logo.png, el-manzano-logo.png, san-jose-las-salinas-logo.png (grid o carrusel).
  - Imágenes carrusel (12 screenshots del portal de pago): 01.jpg a 12.jpg (usar en carrusel JS).
  - Icono WhatsApp: whatsapp-icon.png (verde #25D366).
  - Opcionales: Stock images de oficinas/municipios (buscar free si no hay).

## 2. Estructura de la Página (Secciones en Orden Lógico)
Single-page con navbar sticky. Links scrollean smooth (usar JS). Orden: Impacto → Explicación → Features → Complementario → Prueba Social → Institucional → Contacto.

- **Navbar (ID: navbar)**: Sticky top. Fondo gradient: linear-gradient(to right, #E0F7FA, #00A8B5). Logo izquierda. Links derecha: Inicio (#hero), Sobre Nosotros (#sobre), Producto (#producto), Clientes (#clientes), Contacto (#contacto). Responsive: Hamburger menu en mobile.
- **Hero Section (ID: hero)**: Full-width, height 80vh. Fondo gradient: linear-gradient(45deg, #003E5C, #00A8B5). Logo grande centrado. Slogan: "SIMPLIFIQUE, CONTROLE Y TRANSFORME SU GESTIÓN" (de folletos). Descripción breve: "ALCALD+IA es un sistema de Gestión Municipal y Comunal con arquitectura inteligente que permite optimizar la gestión financiera al instante, asegurando eficiencia y cumplimientos normativos." CTA: Botón "Agendar Demo" (scrollea a #contacto o abre WhatsApp).
- **Explicación Breve (ID: sobre)**: Fondo blanco. Título: "Qué es ALCALD+IA". Texto ajustado de PDF: "ALCALD+IA es una solución tecnológica desarrollada en Python, diseñada para la contabilidad presupuestaria de municipios y comunas. Esta herramienta moderna e inteligente permite optimizar la gestión financiera del sector público, asegurando eficiencia, transparencia y cumplimiento normativo." Lista bullets: Ventajas como "Especialización en sector público", "IA para análisis predictivo", etc. (de página 4 del folleto).
- **Características Clave / Producto (ID: producto)**: Fondo claro #E0F7FA. Título: "Características Principales". Usar cards o lista con icons (hexágonos como en PDF página 6). Contenido de PDF página 3: Infraestructura en Nube, Seguridad, Subsistemas (Contribuyentes, Automotores, etc.), Manual Multimedia, Exportación de Datos.
- **Producto Complementario: Portal de Pago (ID: portal)**: Título: "Portal Web de Pago Municipal". Descripción: "Sistema seguro integrado con MercadoPago para pagos online de tasas y servicios." Carrusel JS con 12 imágenes (01.jpg-12.jpg). JS puro: Slider con arrows/auto-slide. Texto: "Facilita pagos digitales, reduce colas y mejora recaudación."
- **Clientes (ID: clientes)**: Fondo blanco. Título: "Comunas que Confían en Nosotros". Grid responsive con logos: Tinoco, El Manzano, San José de las Salinas. Frase: "Municipios que ya transformaron su gestión con ALCALD+IA."
- **Institucional / Quiénes Somos (ID: sobre-nosotros)**: Fondo claro. Título: "Sobre Nosotros". Texto de PDF: "Desarrollamos soluciones para optimizar la gestión pública. Contacto: 0351-155575700, www.alcaldia.store, creduardofereyra@gmail.com." Incluir comparativa tabla de PDF página 5 (usar HTML table).
- **Contacto (ID: contacto)**: Fondo azul oscuro #003E5C, texto blanco. Título: "Contáctanos". CTAs: Botón "Agendar Cita via WhatsApp" (wa.me/+54351155575700?text=Hola, quiero agendar una demo de ALCALD+IA). Email y teléfono. Form simple HTML si se quiere (nombre, email, mensaje), pero opcional ya que no hay backend.
- **Footer**: Fondo #003E5C. Logo, links repetidos, copyright "© 2025 ALCALD+IA. Todos los derechos reservados." Contacto breve.

## 3. Funcionalidades Técnicas
- **Smooth Scroll**: JS: 
  ```javascript
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
    });
  });
  ```
- **Carrusel JS (para Portal)**: Simple slider con div overflow: hidden. JS para cambiar transform o display.
  ```javascript
  let slideIndex = 0;
  const slides = document.querySelectorAll('.slide');
  function showSlide(n) {
    slideIndex = (n + slides.length) % slides.length;
    document.querySelector('.carousel').style.transform = `translateX(-${slideIndex * 100}%)`;
  }
  // Agregar arrows y auto-slide si se quiere.
  ```
- **Botón WhatsApp Flotante**: Fixed bottom-right. Fondo #25D366, round. Link: `<a href="https://wa.me/+54351155575700?text=Hola, quiero info sobre ALCALD+IA"><img src="assets/whatsapp-icon.png"></a>`
- **Responsive**: Media queries: @media (max-width: 768px) { navbar to column, cards stack, etc. }
- **Animaciones**: Sutiles fade-in al scroll (usar IntersectionObserver JS para efficiency).

## 4. Código Base Esqueleto (para Copilot expandir)
- **index.html**:
  ```html
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALCALD+IA - Gestión Municipal Inteligente</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Open+Sans:wght@400;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <header id="navbar"> <!-- Navbar code --> </header>
    <section id="hero"> <!-- Hero content --> </section>
    <section id="sobre"> <!-- Explicación --> </section>
    <section id="producto"> <!-- Características --> </section>
    <section id="portal"> <!-- Carrusel --> </section>
    <section id="clientes"> <!-- Logos --> </section>
    <section id="sobre-nosotros"> <!-- Institucional --> </section>
    <section id="contacto"> <!-- Contacto --> </section>
    <footer> <!-- Footer --> </footer>
    <a href="https://wa.me/+54351155575700?text=Hola, quiero info sobre ALCALD+IA" class="whatsapp-btn"><img src="assets/whatsapp-icon.png" alt="WhatsApp"></a>
    <script src="script.js"></script>
  </body>
  </html>
  ```
- **styles.css**: Define paleta, tipografías, layouts (flex/grid), gradients.
- **script.js**: Smooth scroll, carrusel.

## 5. Notas para Generación
- Asegura accesibilidad: Alt texts, contrastes.
- Optimiza imágenes: Comprime para load rápido.
- Testea en mobile/desktop.
- Contenido en español, SEO: Meta tags con keywords "gestión municipal, software contable IA".