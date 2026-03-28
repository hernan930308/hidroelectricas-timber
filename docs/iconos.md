# Iconos — Recomendaciones

## Lucide Icons — opción principal

- Sitio: `lucide.dev`
- Licencia: MIT (fork mejorado de Feather Icons)
- Estilo: moderno, líneas limpias, consistente
- +1500 iconos

Usan `stroke="currentColor"` — heredan el color del CSS automáticamente.

```twig
{# SVG copiado directo desde lucide.dev #}
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
  <line x1="3" y1="6" x2="21" y2="6"/>
</svg>
```

## Otras opciones

| Nombre | Sitio | Estilo | Licencia |
|---|---|---|---|
| Heroicons | `heroicons.com` | Minimalista, Tailwind-first | MIT |
| Phosphor Icons | `phosphoricons.com` | Varios pesos (thin/bold/fill) | MIT |
| Tabler Icons | `tabler.io/icons` | Muy completo, 5000+ iconos | MIT |

## Integración en Timber + Twig

Guardar los SVGs descargados en `assets/icons/` y crear un partial reutilizable:

```
assets/icons/
  cart.svg
  search.svg
  phone.svg
```

```twig
{# views/partial/icon.twig #}
{{ source(theme.path ~ '/assets/icons/' ~ name ~ '.svg') }}
```

```twig
{# Uso en cualquier template #}
{% include 'partial/icon.twig' with { name: 'cart' } %}
```

Los SVGs inline se controlan con CSS (`width`, `color`, etc.) sin dependencias externas.
