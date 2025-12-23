# ALCALD+IA - Landing Page Oficial

Landing page profesional para **ALCALD+IA**, software de gestión municipal y comunal con arquitectura inteligente que optimiza la gestión financiera del sector público.

## 🌐 Demo

Sitio web: [www.alcaldia.store](https://www.alcaldia.store)

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
│   ├── whatsapp-icon.svg           # Icono de WhatsApp
│   ├── carousel/                   # 12 screenshots del portal de pago
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
4. **Portal Web de Pago** - Carrusel de screenshots + beneficios para contribuyentes y municipios
5. **Clientes** - Comunas que usan el sistema
6. **Sobre Nosotros** - Información institucional + tabla comparativa
7. **Contacto** - Formulario + información de contacto + botón WhatsApp
8. **Footer** - Links y datos de contacto

## ✨ Características Técnicas

- ✅ **100% Responsive** - Optimizado para mobile, tablet y desktop
- ✅ **Navbar moderno** - Glassmorphism con blur, menú hamburguesa accesible
- ✅ **Carrusel interactivo** - Auto-slide, touch/swipe support, indicadores
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

## 📞 Contacto

- **Teléfono:** 0351-155575700
- **Email:** info@alcaldia.com.ar
- **Web:** [www.alcaldia.store](https://www.alcaldia.store)

---

**© 2025 ALCALD+IA** - Sistema de Gestión Municipal Inteligente
