/* Gestiona acciones de navegacion de la vista 404.
   Conecta el boton de retorno con historial del navegador.
   Si no existe historial, redirige al inicio del sitio.
   Dependencia: elemento con id "volverAnterior". */

document.addEventListener('DOMContentLoaded', () => {
  const botonVolver = document.getElementById('volverAnterior');

  if (!botonVolver) {
    return;
  }

  botonVolver.addEventListener('click', () => {
    if (document.referrer) {
      window.history.back();
      return;
    }

    window.location.href = '/';
  });
});
