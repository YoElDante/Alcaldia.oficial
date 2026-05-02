# Guía: Estructura de carpetas en Ferozo Web Hosting

## Objetivo

Documentar la estructura real del servidor Ferozo, entender para qué sirve cada
carpeta de `/root`, y explicar por qué el proyecto CI4 vive DENTRO de `public_html`
en lugar de la estructura ideal donde `public/` sería solo una subcarpeta de
un directorio privado.

---

## 1. La estructura real de `/root` en Ferozo

Esto es lo que muestra el administrador de archivos (o FileZilla) cuando entrás
con las credenciales FTP principales:

```
/root/                           ← raíz de tu cuenta de hosting
├── .cache/                      ← caché temporal del sistema (sistema)
├── .config/                     ← configuraciones de aplicaciones del sistema
├── .local/                      ← datos de usuario del sistema Linux (no tocar)
├── .ssh/                        ← clave pública SSH autorizada (acceso seguro)
├── .trash/                      ← papelera de la cuenta
├── /etc/                        ← configuraciones del servidor compartido (solo lectura)
├── /logos/                      ← logos y assets del panel de Ferozo (del proveedor, no tuyo)
├── /public_html/                ← TODO lo accesible por el navegador web
├── /storagedir/                 ← almacenamiento complementario del servidor
├── /tmp/                        ← archivos temporales del sistema
├── /tmpsite/                    ← sitio temporal usado por Ferozo (staging/preview)
├── .htaccess                    ← reglas Apache para la raíz de la cuenta
├── .htpasswd                    ← contraseñas de acceso básico HTTP (HTTP Basic Auth)
├── .imunify_patch_id            ← identificador de parches de Imunify360 (seguridad)
├── .myimunify_id                ← ID de instancia de Imunify360
├── .spamkey                     ← clave del sistema anti-spam del servidor
└── lastgit-raiz.log             ← log del último pull de Git ejecutado por el panel
```

**Regla de oro**: lo que el navegador puede ver está SOLAMENTE dentro de `/public_html/`.
Todo lo que esté fuera de `/public_html/` es privado y no tiene URL.

---

## 2. Para qué sirve cada carpeta relevante

### `/public_html/` — tu sitio web
Es el equivalente al directorio `wwwroot` de IIS o `htdocs` de Apache en otros
entornos. Cuando alguien accede a `https://alcaldia.com.ar/`, el servidor sirve
lo que hay en `/public_html/`.

En un proyecto CI4 ideal, SOLO iría el contenido de la subcarpeta `public/` (el
front controller `index.php` y los assets). Pero en este caso, como verás en la
sección 3, hay una restricción que obliga a poner todo el proyecto acá.

### `/storagedir/` — almacenamiento complementario
Carpeta de almacenamiento adicional que Ferozo provee para guardar datos que no
necesitan ser accesibles públicamente. En teoría es un buen candidato para guardar
`storage/` (bitácora, claves temporales, binarios de descarga). **Requiere prueba
real para confirmar si CI4 puede escribir ahí** — los permisos y el path absoluto
deben verificarse antes de usarla.

### `/logos/` — assets internos de Ferozo
Esta carpeta es del **proveedor**, no tuya. Contiene imágenes del panel de
administración de Ferozo. No la uses, no la modifiques. Aparece en el FTP porque
estás viendo la raíz de tu cuenta, no solo tu sitio.

### `/.ssh/` — acceso SSH seguro
Si Ferozo te habilitó acceso SSH, tu clave pública está acá. Permite conectarte
sin contraseña FTP usando `ssh usuario@alcaldia.com.ar`.

### `/tmpsite/` — staging interno de Ferozo
Ferozo lo usa para previews o ambientes temporales. No es para uso manual del
desarrollador.

### `lastgit-raiz.log` — log del panel Git
Ferozo escribe acá el resultado de cada sincronización Git que ejecutás desde el
panel. Útil para debuggear si un push no se refleja en el sitio.

---

## 3. Por qué el proyecto CI4 termina DENTRO de `public_html`

### El problema: la integración Git de Ferozo

Ferozo tiene un panel de integración Git que automatiza el deploy (pull desde GitHub al servidor). La restricción es que **solo permite apuntar el repositorio a `public_html/`** — no acepta otro directorio destino.

Esto genera el siguiente escenario:

```
/root/
└── public_html/              ← Git hace pull acá
    ├── app/                  ← lógica de negocio (debería ser privada)
    ├── vendor/               ← dependencias Composer (debería ser privada)
    ├── storage/              ← datos sensibles (debería ser privada)
    ├── writable/             ← caché y logs (debería ser privada)
    ├── .env                  ← secrets (debería ser privada — más sobre esto abajo)
    ├── public/               ← assets, index.php (el front controller)
    └── index.php             ← front controller a nivel raíz (necesario por esto)
```

### El diseño IDEAL de CI4 (para referencia)

En un servidor con control total (VPS, Cloud Server), la arquitectura correcta sería:

```
/root/
├── alcaldia-web-oficial/     ← código del proyecto (privado, fuera del web root)
│   ├── app/
│   ├── vendor/
│   ├── storage/
│   ├── writable/
│   └── .env
└── public_html/              ← SOLO el contenido de public/ llega acá
    ├── index.php             ← front controller de CI4
    ├── .htaccess
    └── assets/
```

Esto garantiza que `app/`, `vendor/`, `storage/` y `.env` **nunca sean accesibles
por URL**, aunque alguien adivine la ruta.

### Por qué la limitación no es tan grave (mitigación)

CI4 tiene un `public/.htaccess` que bloquea el acceso directo a `app/`, `vendor/`,
`storage/` y `.env` usando reglas Apache. Es la segunda línea de defensa y funciona bien en Apache (que es lo que Ferozo usa).

Lo que hace ese `.htaccess` en esencia:
- Redirige todo el tráfico a `public/index.php` (front controller único)
- Bloquea acceso directo a `app/`, `vendor/`, etc.
- Bloquea acceso a archivos `.env`

**El riesgo que queda**: si Apache falla, se mal-configura o hay una vulnerabilidad en el servidor compartido, esas carpetas quedan expuestas. En un VPS, ese riesgo no existe porque las carpetas directamente no tienen URL posible.

---

## 4. Flujo de deploy que usamos

### Cómo se publica código nuevo

1. Hacer cambios en el proyecto localmente.
2. Commit con mensaje descriptivo en español (`git commit -m "feat(descargas): ..."`).
3. Push a `main` en GitHub: `git push origin main`.
4. En el panel de Ferozo, ejecutar la sincronización Git.
5. Ferozo hace `git pull` en `/root/public_html/` desde `github.com:YoElDante/Alcaldia.oficial`.
6. Verificar que `public_html/distribucion/` siga presente (los binarios son FTP-only).

### Cómo se sube el `.env` al servidor

El archivo `.env` contiene los secrets reales (claves de firma, contraseñas). Por
seguridad **nunca se sube por Git** — existe en `.gitignore`. Se sube manualmente:

1. Copiar el archivo `env` (plantilla del repo, sin punto) localmente.
2. Renombrarlo a `.env`.
3. Reemplazar todos los valores placeholder por los reales.
4. Generar la clave de firma: `php spark key:generate --show` (ejecutar localmente).
5. Subir `.env` por FTP a `/root/public_html/.env` (misma raíz que `composer.json`).

> Este archivo vive SOLO en el servidor. Nunca en el repositorio.

### Cómo se gestionan los binarios de descarga

Los archivos `.zip` del instalador no se versionan en Git (son binarios pesados y
no hay razón para tenerlos en el historial). Se gestionan por FTP:

- Ruta en el servidor: `/root/public_html/distribucion/`
- Se sube un usuario FTP restringido a esa carpeta (hardening recomendado).
- Cuando hay nueva versión: subir nuevo `.zip`, actualizar `version.json`,
  mover el anterior a `backup/`.

---

## 5. Lo que esto implica para el desarrollo

| Decisión | Valor |
|----------|-------|
| Repositorio Git | `github.com:YoElDante/Alcaldia.oficial` rama `main` |
| Directorio en servidor | `/root/public_html/` |
| Front controller expuesto | `/root/public_html/public/index.php` |
| `.env` (secrets reales) | `/root/public_html/.env` — FTP manual, nunca Git |
| Binarios de descarga | `/root/public_html/distribucion/` — FTP manual |
| `distribucion/` en Git | Excluida — solo se gestiona por FTP |
| Log de sincronización Git | `/root/lastgit-raiz.log` |

---

## 6. Referencias

- Guía operativa deploy + Git: `docs/guia-ferozo-git-y-distribucion.md`
- Arquitectura CI4 del proyecto: `docs/Definicion de proyecto/arquitectura-web-php-rutas-descargas.md`
- Fuentes oficiales Donweb: `docs/Definicion de proyecto/donweb-centro-ayuda-fuentes.md`
- Artículo Donweb — Integración Git: https://soporte.donweb.com/hc/es/articles/18963699495956
