# ALCALD+IA - Landing Page Oficial

Landing page profesional para ALCALD+IA, software de gestión municipal con inteligencia artificial.

## 📁 Estructura del Proyecto

```
public_html/
├── index.html          # Página principal
├── styles.css          # Estilos CSS
├── script.js           # JavaScript (carrusel, smooth scroll, etc.)
├── assets/
│   ├── alcaldiaLogo.webp           # Logo principal
│   ├── whatsapp-icon.png           # Icono de WhatsApp
│   ├── carousel/                   # Screenshots del portal de pago
│   │   ├── 01.jpg
│   │   ├── 02.jpg
│   │   ├── ... (hasta 12.jpg)
│   └── clientes/                   # Logos de clientes/comunas
│       ├── tinoco-logo.png
│       ├── el-manzano-logo.png
│       └── san-jose-las-salinas-logo.png
```

## 🖼️ Assets Requeridos

Antes de subir a Don Web, asegúrate de tener los siguientes archivos en la carpeta `assets/`:

### Logo Principal
- `alcaldiaLogo.webp` - Logo de ALCALD+IA (formato webp recomendado)

### Icono WhatsApp
- `whatsapp-icon.png` - Icono de WhatsApp en color blanco (tamaño recomendado: 64x64px)

### Imágenes del Carrusel (carpeta `carousel/`)
- `01.jpg` hasta `12.jpg` - 12 screenshots del portal de pago municipal

### Logos de Clientes (carpeta `clientes/`)
- `tinoco-logo.png`
- `el-manzano-logo.png`
- `san-jose-las-salinas-logo.png`

## 🚀 Subir a Don Web

1. **Accede a tu panel de Don Web** (cPanel o File Manager)

2. **Navega a la carpeta `public_html`** de tu dominio

3. **Sube todos los archivos:**
   - `index.html`
   - `styles.css`
   - `script.js`
   - Carpeta `assets/` con todas las imágenes

4. **Verifica** que la estructura de carpetas sea correcta

## 🎨 Paleta de Colores

| Color | Código | Uso |
|-------|--------|-----|
| Turquesa | `#00A8B5` | Acentos, botones, logo |
| Azul oscuro | `#003E5C` | Textos, headings, footer |
| Azul claro | `#E0F7FA` | Fondos, gradients |
| Blanco | `#FFFFFF` | Fondos principales |
| Gris claro | `#F5F5F5` | Elementos secundarios |
| WhatsApp | `#25D366` | Botón flotante |

## 📱 Características

- ✅ Diseño responsive (mobile-first)
- ✅ Navegación con smooth scroll
- ✅ Carrusel de imágenes con auto-slide y touch support
- ✅ Botón flotante de WhatsApp
- ✅ Animaciones sutiles al scroll
- ✅ Formulario de contacto (envía a WhatsApp)
- ✅ SEO básico optimizado
- ✅ Compatible con PHP/HTML puro (sin frameworks)

## 🔧 Personalización

### Cambiar número de WhatsApp
Busca y reemplaza `+543515575700` en:
- `index.html` (múltiples ubicaciones)
- `script.js` (en la función del formulario)

### Cambiar email
Busca y reemplaza `creduardofereyra@gmail.com` en `index.html`

### Agregar más slides al carrusel
En `index.html`, agrega más `<div class="slide">` dentro del contenedor del carrusel.

## 📞 Contacto

- **Teléfono:** 0351-155575700
- **Email:** creduardofereyra@gmail.com
- **Web:** www.alcaldia.store

---

© 2025 ALCALD+IA - Todos los derechos reservados
