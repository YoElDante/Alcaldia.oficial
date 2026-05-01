# Guía práctica de 10 minutos — ejecutar CI4 en local

Esta práctica te enseña el flujo real para arrancar, probar rutas y entender la diferencia entre modo desarrollo y modo simulación de deploy.

---

## 1. Preparación rápida (2 minutos)

Desde la raíz del proyecto, verificá herramientas:

```bash
php --version
composer --version
```

Si es la primera vez en esa máquina:

```bash
composer install
```

---

## 2. Modo desarrollo (3 minutos)

Iniciá el servidor de desarrollo:

```bash
composer run dev
```

Abrí en navegador:
- http://127.0.0.1:8080/
- http://127.0.0.1:8080/pagos
- http://127.0.0.1:8080/tutoriales
- http://127.0.0.1:8080/descargas

Qué estás usando acá:
- Script del proyecto para desarrollo diario.
- Comando interno: php spark serve.
- Ideal para iterar rápido mientras programás.

---

## 3. Modo start (simulación deploy) (3 minutos)

En otra terminal, cortá el modo dev con Ctrl + C y levantá:

```bash
composer run start
```

Volvé a abrir las mismas rutas.

Qué estás usando acá:
- Servidor embebido de PHP con public/router.php.
- Simula mejor el comportamiento del front controller en entorno real.
- Útil para validar antes de publicar.

---

## 4. Prueba guiada de aprendizaje (2 minutos)

Objetivo: confirmar cómo fluye una request en CI4.

1. Abrí app/Config/Routes.php y localizá la ruta /pagos.
2. Confirmá que apunta a PagosController::index.
3. Abrí app/Controllers/PagosController.php.
4. Verificá que retorna una view.
5. Abrí app/Views/pagos.php.
6. Refrescá /pagos en el navegador.

Con esto ves el recorrido completo:
- URL -> Route -> Controller -> View.

---

## 5. Equivalencias mentales con Node.js

Si en Node pensabas así:
- node archivo.js
- npm run dev
- npm start

En este proyecto pensalo así:
- php archivo.php (solo scripts sueltos)
- composer run dev (modo desarrollo de la app)
- composer run start (simulación local más cercana a deploy)

---

## 6. Buenas prácticas para practicar todos los días

- Usá dev para programar.
- Usá start antes de cerrar una tarea importante.
- No toques public/index.php salvo necesidad real.
- Definí rutas en app/Config/Routes.php.
- Mantené controllers delgados y lógica en Services.
