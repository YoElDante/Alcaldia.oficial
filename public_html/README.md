# ALCALD+IA - Landing Page Oficial

Landing page profesional para **ALCALD+IA**, software de gestión municipal y comunal con arquitectura inteligente que optimiza la gestión financiera del sector público.

## 🌐 Demo

Sitio web: [www.alcaldia.com.ar](https://www.alcaldia.com.ar)
Portal de pagos demo: [demo.alcaldia.com.ar](https://demo.alcaldia.com.ar)

## 📁 Estructura del Proyecto

```
public_html/
├── index.html                      # Página principal
├── styles.css                      # Estilos CSS (~1900 líneas)
├── script.js                       # JavaScript (carrusel, smooth scroll, animaciones)
├── README.md                       # Este archivo
├── assets/
│   ├── alcaldiaLogo.webp           # Logo principal
│   ├── alcaldiaLogo.svg            # Logo en vector
│   ├── alcaldiaLogo.ico            # Favicon
│   ├── whatsapp-icon.svg           # Icono de WhatsApp
│   ├── images/                     # Logos de pasarelas de pago
│   │   ├── SIRO_LOGO.webp          # Logo SIRO (integración activa)
│   │   ├── MERCADOPAGO_LOGO.webp   # Logo MercadoPago (integración futura)
│   │   └── PAGO_TIC_LOGO.webp      # Logo PagoTic (integración futura)
│   ├── carousel/                   # Screenshots del portal de pago
│   │   ├── 01- Portal Vista Principal.jpg
│   │   ├── 02 - Portal Vista Principal - contribuyente no encontrado.jpg
│   │   ├── 03 - Portal Vista Principal - contribuyente.jpg
│   │   ├── 04 - Portal Vista Principal - contribuyente - Detalle de Boletas.jpg
│   │   ├── 05 - Portal Vista Principal - contribuyente - Filtro por Concepto.jpg
│   │   ├── 06 - Portal Vista Principal - Botonera.jpg
│   │   ├── 07 - Portal - Previsualizacion de Ticket.jpg
│   │   ├── 08 - Portal Vista Principal - Opcion de Pago - MP.jpg
│   │   ├── 09 - Ticket PDF.jpg
│   │   ├── 10 - pago exitoso.jpg
│   │   ├── 11 - pago fallido.jpg
│   │   └── 12 - pago pendiente.jpg
│   └── clientes/                   # Logos de comunas cliente
│       ├── TINOCO.webp
│       ├── EL_MANZANO.webp
│       └── sanjosedelassalinas.webp
```

## 💳 Integración de Pagos

### Activa

| Pasarela | Estado | Descripción |
|----------|--------|-------------|
| **SIRO** (Banco Roela) | ✅ Integrado | Sistema bancario de recaudación utilizado por municipios argentinos. El dinero acreditado llega directamente a la cuenta designada por el Municipio o la Comuna. |

### A futuro

| Pasarela | Estado | Descripción |
|----------|--------|-------------|
| **PagoTic** | 🔜 Próximamente | Incorporación según convenios municipales. |
| **MercadoPago** | 🔜 Próximamente | Incorporación según convenios municipales. |

Cada municipio podrá operar con la pasarela que mejor se adapte a sus convenios y necesidades.

## 🎨 Diseño

### Paleta de Colores

| Color | Código | Uso |
|-------|--------|-----|
| Turquesa | `#00A8B5` | Acentos, botones, CTAs |
| Azul oscuro | `#003E5C` | Headings, footer, textos importantes |
| Azul claro | `#E0F7FA` | Fondos claros, gradientes |
| Blanco | `#FFFFFF` | Fondos principales |
| Gris claro | `#F5F5F5` | Secciones alternadas |
| WhatsApp | `#25D366` | Botón flotante |

### Tipografías (Google Fonts)

- **Oswald** (700) - Títulos y headings
- **Open Sans** (300, 400, 600) - Textos y cuerpo

### Elementos Decorativos

La landing incluye elementos decorativos modernos en todas las secciones:
- Barras diagonales
- Patrones de puntos
- Círculos outline y rellenos
- Colores adaptados según el fondo de cada sección

## 📱 Secciones

1. **Hero** - Presentación principal con logo, título y CTAs
2. **Qué es ALCALD+IA** - Descripción del producto y beneficios
3. **Características** - 6 tarjetas con features principales
4. **Portal Web de Pago** - Carrusel de screenshots + integración SIRO + invitación al portal demo
5. **Clientes** - Comunas que usan el sistema
6. **Sobre Nosotros** - Información institucional + tabla comparativa
7. **Contacto** - Formulario + información de contacto + botón WhatsApp
8. **Footer** - Links, datos de contacto y acceso al portal demo

### Navbar

| Ítem | Ancla |
|------|-------|
| Inicio | `#hero` |
| Qué es | `#sobre` |
| Características | `#producto` |
| Portal de Pago | `#portal` |
| Portal Demo | `#portal-demo` → scroll directo al bloque de acceso a `demo.alcaldia.com.ar` |
| Clientes | `#clientes` |
| Nosotros | `#sobre-nosotros` |
| Contacto | `#contacto` |

## ✨ Características Técnicas

- ✅ **100% Responsive** - Optimizado para mobile, tablet y desktop
- ✅ **Navbar moderno** - Glassmorphism con blur, menú hamburguesa accesible
- ✅ **Carrusel interactivo** - Auto-slide, touch/swipe support, indicadores
- ✅ **Smooth scroll preciso** - `getBoundingClientRect()` para anclas dentro de secciones
- ✅ **Tabla responsive** - Se convierte en cards en mobile
- ✅ **Animaciones al scroll** - Elementos aparecen con fadeIn
- ✅ **Botón flotante WhatsApp** - Siempre visible
- ✅ **SEO básico** - Meta tags optimizados
- ✅ **Sin frameworks** - HTML/CSS/JS puro, compatible con hosting básico

## 🚀 Despliegue en DonWeb

1. Acceder al **File Manager** de cPanel
2. Navegar a `public_html/`
3. Subir todos los archivos manteniendo la estructura
4. Verificar que los assets estén correctamente enlazados

## 🔧 Personalización

### Cambiar número de WhatsApp
Buscar y reemplazar `+543515575700` en `index.html`

### Cambiar email de contacto
Buscar y reemplazar `info@alcaldia.com.ar` en `index.html`

### Agregar más clientes
En `index.html`, agregar más `<div class="cliente-card">` en la sección clientes.

### Agregar más slides al carrusel
Agregar más `<div class="slide">` dentro de `#carousel` en `index.html`.

### Agregar una nueva pasarela de pago
1. Colocar el logo en `assets/images/`
2. Duplicar un bloque `payment-current` o `payment-future` en `index.html`
3. Actualizar la tabla comparativa en la sección **Sobre Nosotros**

## 📞 Contacto

- **Teléfono:** 0351-155575700
- **Email:** info@alcaldia.com.ar
- **Web:** [www.alcaldia.com.ar](https://www.alcaldia.com.ar)

---

**© 2026 ALCALD+IA** - Sistema de Gestión Municipal Inteligente
