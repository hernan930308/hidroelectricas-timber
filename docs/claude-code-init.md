# Claude Code: Comando /init

El comando `/init` analiza el codebase y genera o mejora el archivo `CLAUDE.md` con convenciones, comandos de build, instrucciones de tests y estándares del proyecto.

## Comportamiento

- **Primera ejecución:** Crea un `CLAUDE.md` desde cero.
- **Ejecuciones siguientes:** Sugiere mejoras al `CLAUDE.md` existente sin sobreescribirlo.

## Variantes

Solo existe una versión del comando. No hay variantes.

## Flag opcional: modo interactivo

```bash
CLAUDE_CODE_NEW_INIT=1 claude
```

Activa un flujo interactivo multi-fase que:

1. Pregunta qué artefactos configurar (CLAUDE.md, skills, hooks)
2. Explora el codebase con un subagente
3. Hace preguntas de seguimiento para llenar vacíos
4. Presenta una propuesta revisable antes de escribir archivos
