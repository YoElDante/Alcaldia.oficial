# Guia operativa: Ferozo GIT + carpeta distribucion

## Objetivo

Dejar el proyecto listo para publicar codigo desde GitHub hacia Ferozo sin borrar ni versionar los binarios de `distribucion`.

## Regla clave de este proyecto

- El codigo se versiona en GitHub.
- Los binarios de instalacion en `public_html/distribucion` se gestionan por FTP manual.
- `distribucion` no forma parte del repositorio para evitar pushes pesados y borrados no deseados.

## Estructura recomendada en servidor

Si Ferozo permite instalar el repositorio fuera de `public_html`, usar:

- `/<directorio_privado_repo>/` para codigo (`app`, `vendor`, `writable`, `storage`, etc.).
- `/public_html/` solo para contenido publico.
- `/public_html/distribucion/` para binarios descargables.

Si Ferozo NO permite salir de `public_html` desde el panel GIT:

- Mantener el repositorio en `/public_html/` (limitacion de plataforma).
- Excluir y preservar `public_html/distribucion/` con gestion manual por FTP.
- No ejecutar tareas de limpieza que borren archivos no versionados.

## Configuracion del panel GIT de Ferozo

- Repositorio: `git@github.com:YoElDante/Alcaldia.oficial.git`
- Rama: `main`
- Directorio: dejar `public_html/` cuando la plataforma no acepte otra ruta.

## Flujo operativo de deploy

1. Hacer push a `main` en GitHub.
2. En Ferozo GIT, ejecutar sincronizacion del repositorio.
3. Verificar que `public_html/distribucion` siga presente.
4. Si falta algun binario, subirlo por FTP con usuario restringido a esa carpeta.
5. Probar acceso en `/descargas`, login y descarga de archivos permitidos.

## Hardening recomendado

- Crear usuario FTP exclusivo para `public_html/distribucion`.
- Rotar credenciales FTP periodicamente.
- No usar cuenta FTP principal para operaciones diarias.
- Mantener permisos: carpeta `755`, archivos `644`.

## Nota sobre CodeIgniter 4

La solucion ideal de seguridad es ubicar `app`, `vendor`, `storage`, `writable` y `.env` fuera de `public_html`. Si la limitacion de Ferozo GIT lo impide, se recomienda publicar por FTP/SFTP controlado o cambiar a un flujo que permita esa separacion.
