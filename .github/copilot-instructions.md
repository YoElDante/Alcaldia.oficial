# Instrucciones de Copilot para Alcaldia.oficial

Estas reglas son obligatorias para cualquier sesión en este repositorio.

## Protocolo Engram obligatorio

1. Antes de escribir codigo:
   - Ejecutar mem_context.
   - Ejecutar mem_search con keywords del pedido.
   - Si hay resultados, leer detalle completo con mem_get_observation.

2. Durante la ejecucion:
   - Guardar mem_save inmediatamente despues de cada decision, bugfix, descubrimiento o preferencia del usuario.

3. Antes de cerrar la sesion:
   - Guardar mem_session_summary con Goal, Instructions, Discoveries, Accomplished, Next Steps y Relevant Files.

4. Si hay compactacion:
   - Guardar mem_session_summary de recuperacion primero.
   - Luego ejecutar mem_context y continuar.

## Regla de bloqueo

Si no se completo el protocolo Engram, no se debe editar archivos ni proponer cambios de codigo.

## Herramientas prohibidas fuera de contexto

- No usar herramientas Azure MCP en este repositorio salvo que el pedido del usuario sea explicitamente sobre Azure.
- Si el pedido no es Azure, cualquier invocacion Azure MCP se considera error de protocolo.

## Checklist visible al iniciar tarea tecnica

Antes de editar archivos, mostrar y cumplir:

- Engram contexto cargado (mem_context).
- Busqueda tematica ejecutada (mem_search).
- Hallazgos guardados durante la ejecucion (mem_save).
- Cierre obligatorio al final (mem_session_summary).

## Fuente de verdad del repositorio

Seguir siempre AGENTS.md como contrato principal del proyecto.
