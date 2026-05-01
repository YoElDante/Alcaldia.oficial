# PRD.md — Product Requirements Document
## Alcaldía Web Oficial — Portal ALCALD+IA

> Define el QUÉ y el POR QUÉ. No el cómo.
> Ningún agente de IA debe tocar código sin haber leído este documento y el AGENTS.md.

---

## 1. Problema

Los municipios y comunas que adoptan ALCALD+IA necesitan dos cosas:

1. **Antes de comprar**: un sitio web profesional que les transmita confianza, explique el producto y facilite el contacto comercial.
2. **Después de comprar**: un canal seguro y simple para descargar la versión actualizada del software de escritorio sin depender de envíos por WhatsApp, email o links públicos.

Hoy existe una landing page estática que cubre el punto 1 de forma básica. El punto 2 no existe — las distribuciones del software se hacen de forma manual e insegura.

---

## 2. Objetivos del Producto

| # | Objetivo | Cómo se mide |
|---|---------|-------------|
| 1 | Transmitir profesionalismo y confianza a municipios interesados | El equipo comercial reporta que el sitio respalda las presentaciones de venta |
| 2 | Generar contacto comercial (demos, consultas) | Clicks en botones de WhatsApp y formulario de contacto |
| 3 | Distribuir el software de escritorio de forma segura y controlada | /descargas requiere clave, links de descarga vencen, bitácora activa |
| 4 | Preparar infraestructura para crecer sin rehacer todo | Rutas /pagos y /tutoriales funcionan aunque no tengan contenido aún |

---

## 3. Usuarios

### 3.1 Visitante / Prospecto
Administrador municipal o contador de una comuna que encontró ALCALD+IA por referido o búsqueda.

**Necesita**: entender qué hace el software, ver que hay clientes reales usándolo y poder contactar al equipo fácilmente.

**No necesita**: crear cuenta, registrarse, ni navegar más de una página.

### 3.2 Cliente Municipal (usuario de /descargas)
Responsable de IT o de administración en un municipio que ya contrató ALCALD+IA.

**Necesita**: entrar con una clave, descargar la versión actualizada del software de escritorio y acceder a los assets de instalación permitidos.

**No necesita**: ver archivos de otros clientes, gestionar su cuenta ni hacer pagos en este sitio.

**Volumen de uso**: bajo y predecible. Estimado: 2-3 sesiones por día, 3 días por semana como máximo.

### 3.3 Administrador Interno (equipo ALCALD+IA)
Miembro del equipo que sube nuevas versiones del software y gestiona las claves de acceso para clientes.

**Necesita**: subir una nueva versión via FTP, crear o invalidar claves temporales para clientes, consultar la bitácora de descargas.

**No necesita** (por ahora): panel web de administración. FileZilla + acceso directo a los archivos JSON es suficiente para el volumen actual.

---

## 4. Funcionalidades

### 4.1 Landing Page (existente — mantener y evolucionar)

| Funcionalidad | Descripción | Prioridad |
|--------------|-------------|-----------|
| Navbar sticky | Logo + links smooth scroll + hamburger en mobile | Existente |
| Hero section | Gradient 45deg, logo, slogan, CTA a WhatsApp | Existente |
| Sección producto | Cards con características clave del software | Existente |
| Portal de pago | Carrusel JS con 12 screenshots del portal | Existente |
| Clientes | Grid de logos de comunas clientes | Existente |
| Sección institucional | Quiénes somos + tabla comparativa | Existente |
| Contacto | CTA WhatsApp + email + teléfono | Existente |
| Botón WhatsApp flotante | Fixed bottom-right, siempre visible | Existente |

Toda nueva vista del sitio debe respetar el sistema de diseño definido en `AGENTS.md § 5`.

### 4.2 Módulo /descargas (a construir — Fases 1-4)

**Flujo de acceso:**

```
Usuario llega a /descargas
    │
    ├─ Sin sesión activa → muestra formulario de login
    │       │
    │       ├─ Clave inválida → error + rate limit por IP
    │       └─ Clave válida → inicia sesión → redirige a panel
    │
    └─ Con sesión activa → muestra panel de descargas
            │
            ├─ Botón "Descargar versión actual" → genera token firmado (5 min) → descarga
            └─ Lista de assets permitidos → descarga con token firmado
```

**Criterios de aceptación por funcionalidad:**

| Funcionalidad | Criterio de aceptación |
|--------------|----------------------|
| Login por password | Clave válida inicia sesión. Clave inválida muestra error genérico (no dice si la clave existe o no). |
| Rate limit | Después de 5 intentos fallidos desde la misma IP en 15 minutos, nuevos intentos son rechazados sin verificar la clave. |
| Panel de descargas | Solo visible con sesión activa. Muestra versión actual y lista de assets permitidos según el alcance de la clave. |
| Token de descarga | El link de descarga vence en 5 minutos. Pasado ese tiempo, devuelve 403. El token no puede ser reutilizado fuera de su ventana. |
| Path traversal | El parámetro del archivo a descargar nunca permite acceder a rutas fuera de `storage/releases/` o `storage/assets-instalacion/`. |
| Cierre de sesión | Logout invalida la sesión server-side y redirige a login. |

### 4.3 Claves Temporales (Fase 3)

| Funcionalidad | Criterio de aceptación |
|--------------|----------------------|
| Clave con vencimiento | Una clave expirada no permite login, aunque el hash sea correcto. |
| Límite de usos | Si la clave alcanzó su límite, el login es rechazado aunque no haya vencido. |
| Alcance | Una clave con alcance `version_actual` no puede generar tokens para assets de instalación. |
| Bitácora | Todo login exitoso, login fallido y descarga queda registrado con timestamp, IP hasheada y clave usada. |

### 4.4 Rutas Base (Fase 1 — placeholder)

| Ruta | Comportamiento esperado |
|------|------------------------|
| `/` | Landing page existente |
| `/pagos` | Vista placeholder con diseño coherente a la landing |
| `/tutoriales` | Vista placeholder con diseño coherente a la landing |
| `/descargas` | Módulo de descargas (Fases 2-3) |

---

## 5. Fuera de Alcance

Estas funcionalidades quedan explícitamente fuera del proyecto actual:

- Panel web de administración para gestionar claves (el equipo usa FTP + JSON directo)
- Pagos online en este sitio (el portal de pagos es un producto separado de ALCALD+IA)
- Registro / creación de cuentas por parte de clientes
- Notificaciones por email al descargar
- Multi-idioma
- Sistema de tickets o soporte integrado

---

## 6. Restricciones Técnicas

| Restricción | Impacto |
|------------|---------|
| Hosting Donweb shared (PHP 8.1+, sin Node) | Todo el backend debe ser PHP. CI4 como framework. |
| Solo `public/` expuesto como web root | `app/`, `storage/`, `vendor/` deben vivir fuera de `public_html` o protegidos con `.htaccess`. |
| Deploy por FTP (FileZilla) | No hay CI/CD automático. El flujo de publicación es manual. |
| Sin servicio de base de datos externo por ahora | Persistencia en JSON flat files. SQLite es opción futura sin costo adicional (es un archivo PHP, no un servicio). |
| Equipo con experiencia en Node/Express | La arquitectura CI4 debe estar mapeada explícitamente a conceptos Node. Ver `AGENTS.md § 3.2`. |

---

## 7. Plan de Fases

| Fase | Entregable | Dependencias |
|------|-----------|-------------|
| 0 | Credenciales FTP rotadas. Estructura de carpetas definida en servidor. | — |
| 1 | CI4 instalado. Rutas base funcionando. Vistas placeholder. `.htaccess` operativo. | Fase 0 |
| 2 | `/descargas` con login, sesión y descarga firmada. | Fase 1 |
| 3 | Claves temporales con vencimiento + bitácora. | Fase 2 |
| 4 | Protocolo de versiones: subida FTP, backup, rollback. | Fase 2 |
| 5 | Panel web de subida por ZIP (opcional). | Fase 4 |

---

## 8. Referencias

| Documento | Propósito |
|-----------|-----------|
| `AGENTS.md` | Estándares técnicos, arquitectura y reglas para agentes IA |
| `docs/Definicion de proyecto/arquitectura-web-php-rutas-descargas.md` | Arquitectura CI4 detallada, estructura de carpetas |
| `docs/Definicion de proyecto/brief-ia-rutas-y-descargas.md` | Brief de implementación por fases |
| `docs/Definicion de proyecto/donweb-centro-ayuda-fuentes.md` | Fuentes oficiales Donweb, compatibilidad CI4 |
| `docs/Definicion de proyecto/proyecto.md` | Visión de la landing, paleta, secciones, copy |
