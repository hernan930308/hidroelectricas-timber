# Parcel: Error EXDEV cross-device link not permitted

## Error

```
Error: EXDEV: cross-device link not permitted, rename '/tmp/...' -> '/home2/.../hidroelectricas-theme/.parcel-cache/...'
```

## Causa

Parcel intenta mover archivos temporales de `/tmp` (dispositivo A) al directorio del proyecto (dispositivo B). Un `rename` entre dispositivos distintos no está permitido en Linux.

Ocurre frecuentemente en **hostings compartidos** que montan `/tmp` en un dispositivo separado.

## Soluciones

### Opción 1: Deshabilitar caché (recomendada para builds en servidor)

```bash
parcel build --no-cache <entry>
```

O en `package.json`:

```json
"scripts": {
  "build": "parcel build assets/styles/app.css assets/js/app.js --public-url ./ --no-cache"
}
```

### Opción 2: Forzar el cache-dir al mismo dispositivo

```bash
parcel build --cache-dir .parcel-cache <entry>
```

O en `package.json`:

```json
"scripts": {
  "build": "parcel build assets/styles/app.css assets/js/app.js --public-url ./ --cache-dir .parcel-cache"
}
```

## Configuración actual del proyecto

El script `dev` ya incluye `--cache-dir .parcel-cache`. Agregar `--no-cache` al script `build` es suficiente para evitar el error en el servidor.
