# Traducir plugins con WP-CLI

Con WP-CLI no se traduce directamente, pero sí puedes **descargar e instalar los archivos de traducción** ya existentes:

```bash
# Descargar traducciones de WooCommerce al español
wp language plugin install woocommerce es_ES

# Activar el idioma del sitio (si no está configurado)
wp option update WPLANG es_ES

# Actualizar traducciones existentes
wp language plugin update woocommerce
```

Si quieres generar un archivo `.pot` para traducir manualmente:

```bash
# Genera el archivo base de traducciones
wp i18n make-pot web/app/plugins/woocommerce web/app/plugins/woocommerce/i18n/languages/woocommerce.pot
```

Y si ya tienes un archivo `.po` editado y necesitas compilarlo a `.mo`:

```bash
wp i18n make-mo web/app/plugins/woocommerce/i18n/languages/
```

**Para este proyecto** recuerda agregar `--path=web/wp` o usar el `wp-cli.yml` que ya tienes configurado. Verifica que `WPLANG=es_ES` esté en tu `.env`.
