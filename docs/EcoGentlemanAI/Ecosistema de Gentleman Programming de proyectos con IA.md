# Ecosistema de **Gentleman Programming**
## Iniciar el ecosistema en tu proyecto
Debemos correr
gga init
gga install

## Sistema de Carpetas y Archivos

Para organizar tu proyecto siguiendo el ecosistema de **Gentleman Programming** y el flujo de **Spec-Driven Development (SDD)**, debes estructurar tus archivos de forma que la IA tenga contexto claro de qué hacer, cómo hacerlo y bajo qué reglas.

A continuación, te presento un diagrama de la estructura de carpetas y archivos en formato Markdown que debes tener en tu repositorio para trabajar de manera profesional con agentes de IA:

### Estructura de Archivos del Proyecto (.md)

```text
mi-proyecto/
├── PRD.md                       # Documento de Requisitos del Producto (El "Qué" y "Por qué")
├── AGENTS.md                    # Reglas globales y estándares de código para la IA
├── skills/                      # Biblioteca de "habilidades" o patrones de código
│   ├── mi-tecnologia/
│   │   └── SKILL.md             # Instrucciones específicas, ejemplos y anti-patrones
│   └── arquitectura/
│       └── SKILL.md             # Reglas de estructura (ej. Hexagonal, Clean)
└── openspec/                    # Capa de planificación y especificaciones (SDD)
    ├── specs/                   # Definición de funcionalidades existentes
    │   └── auth-login/
    │       └── spec.md          # Requisitos funcionales y escenarios GHERKIN
    └── changes/                 # Carpeta para nuevas implementaciones o cambios
        └── feature-nueva/
            ├── proposal.md      # Propuesta de cambio para revisión humana
            ├── design.md        # Decisiones técnicas y arquitectura del cambio
            └── tasks.md         # Lista de tareas desglosadas para la IA
```

---

### Descripción de los archivos clave

1.  **`PRD.md` (Product Requirements Document):** Es el punto de partida. Define el problema, los objetivos, el alcance y las historias de usuario antes de tocar una sola línea de código. Sirve para que la IA entienda el contexto de negocio.
2.  **`AGENTS.md`:** Funciona como un manual de instrucciones para tu "Senior Developer" virtual. Aquí defines los estándares que el equipo (y la IA) deben seguir, permitiendo que herramientas como **GGA (Gentleman Guardian Angel)** validen tu código antes de cada commit.
3.  **`skills/[nombre]/SKILL.md`:** Son bibliotecas de patrones. Cada archivo contiene condiciones de activación, reglas de codificación, ejemplos de referencia y "anti-patrones" (lo que se debe evitar). Esto permite cargar contexto bajo demanda solo cuando es necesario.
4.  **`openspec/specs/spec.md`:** Aquí es donde vive la documentación funcional que no desaparece al cerrar el chat. Se organiza por capacidades y utiliza un lenguaje legible tanto por humanos como por IAs (estilo GIVEN/WHEN/THEN).
5.  **`openspec/changes/`:** Cuando inicias una tarea nueva, el orquestador de SDD genera aquí la **propuesta**, el **diseño** técnico y las **tareas** específicas. Esto permite al desarrollador validar el plan antes de que la IA empiece a escribir código, reduciendo alucinaciones y ciclos de corrección.

**Nota adicional:** Si utilizas el comando `gentle-ai`, gran parte de esta configuración se inyecta automáticamente en tus agentes, pero mantener estos archivos en tu repositorio permite que el contexto sea **persistente, versionable y compartible** con todo tu equipo a través de Git.

**NoteBookLM:** https://notebooklm.google.com/notebook/f92f029c-a2bf-45bd-a7c7-ec5f29a7481c
Aqui se explica todo todas las especificaciones del gentle-ai
