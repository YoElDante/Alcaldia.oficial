# Brief para IA - Implementacion de rutas y modulo de descargas en PHP

## Objetivo
Implementar en este proyecto una base PHP mantenible para:
- rutas limpias (/pagos, /tutoriales, /descargas)
- modulo /descargas con autenticacion por password
- descarga de version actual de app de escritorio + assets permitidos
- soporte para claves temporales compartibles con clientes

## Contexto del proyecto
- Hosting: Donweb
- Stack actual: HTML/CSS/JS estatico
- Framework backend: CodeIgniter 4 (CI4)
- Restriccion: runtime PHP (sin Node en servidor)
- PHP requerido: 8.1+ (Donweb ofrece 8.4 - COMPATIBLE)
- Equipo: principal experiencia en Node/Express MVC

## Reglas de arquitectura
- usar CodeIgniter 4 como framework base (instalar via Composer)
- CI4 provee el front controller nativo (public/index.php) - no crear uno custom
- usar app/Config/Routes.php para definir todas las rutas (no PHP custom router)
- usar app/Filters/ para auth guards y rate limiting (Filters de CI4)
- usar .htaccess de CI4 para resolver rutas limpias
- separar responsabilidades en capas tipo MVC (Controllers, Services, Views, Models)
- mantener app/, vendor/, writable/ fuera de public_html cuando sea posible
- solo public/ queda expuesto al navegador

## Estructura objetivo (CodeIgniter 4)
- app/Config/Routes.php (rutas - reemplaza Core/Router custom)
- app/Controllers (controladores CI4)
- app/Filters (auth, rate limit - reemplaza middlewares custom)
- app/Services (logica de negocio - carpeta custom)
- app/Models (modelos CI4 si se usa DB)
- app/Views (vistas PHP)
- public/ (UNICA carpeta expuesta: assets, css, js, index.php, .htaccess)
- storage/ (releases, assets-instalacion - fuera de public)
- writable/ (cache y logs de CI4 - fuera de public)
- vendor/ (Composer - fuera de public)
- .env (variables de entorno)

## Requisitos funcionales
1. Ruta /descargas protegida con password.
2. Si no hay sesion: mostrar login.
3. Si hay sesion: mostrar panel con:
   - boton de descarga de version actual
   - lista de assets permitidos
4. Descarga segura por token temporal firmado.
5. Claves temporales para clientes con vencimiento.

## Requisitos no funcionales
- seguridad minima de sesion y formularios
- validacion de entrada en todas las rutas
- codigo legible, simple y documentado
- logs basicos de intentos de login y descargas
- preparado para crecer sin rehacer estructura

## Politicas de seguridad
- password en hash, nunca en texto plano
- CSRF token en POST
- rate limit de login por IP
- expiracion de sesion
- prevenir path traversal al descargar
- expiracion corta de token de descarga

## Flujo operativo de versiones
- contador sube nueva version (FTP o panel)
- version nueva pasa a activa
- version previa va a backup temporal (recomendado)
- opcion de rollback rapido

## Convenciones de codigo
- nombres claros en ingles para clases/metodos
- rutas en espanol orientadas al negocio
- controladores delgados, logica en servicios
- sin "logica pesada" en vistas

## Checklist de entrega por fase
Fase 1
- Router funcional + rutas base + vistas placeholder

Fase 2
- Login/logout de /descargas + sesion segura

Fase 3
- Catalogo de archivos + descarga firmada

Fase 4
- Claves temporales + bitacora de uso

Fase 5 (opcional)
- Subida web por ZIP + publish controlado

## Criterios de aceptacion
- entrar a /descargas requiere clave
- cliente con clave valida puede descargar sin ver archivos no permitidos
- links de descarga vencen
- /pagos y /tutoriales funcionan con la misma base de rutas

## Prompt sugerido para futuras iteraciones con IA
"Implementa la Fase X del brief de docs/Definicion de proyecto/brief-ia-rutas-y-descargas.md.
Usa CodeIgniter 4 como framework. Respeta arquitectura CI4 propuesta (Controllers, Filters, Routes, Views),
seguridad minima y compatibilidad Donweb. No crear routers o middlewares PHP custom, usar los de CI4.
Entrega cambios por archivo + explicacion breve + riesgos + siguiente paso."