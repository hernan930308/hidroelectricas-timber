# SMTP sin plugin wp-mail-smtp

Con Bedrock puedes manejar el envío de emails directamente desde un **mu-plugin** usando una librería PHP, sin necesidad del plugin wp-mail-smtp.

## Configuración vía filtro en mu-plugin

Crea `web/app/mu-plugins/mail-config.php`:

```php
<?php
add_action('phpmailer_init', function (PHPMailer\PHPMailer\PHPMailer $phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = env('SMTP_HOST');
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Username   = env('SMTP_USER');
    $phpmailer->Password   = env('SMTP_PASS');
    $phpmailer->SMTPSecure = env('SMTP_ENCRYPTION', 'tls');
    $phpmailer->Port       = env('SMTP_PORT', 587);
    $phpmailer->From       = env('SMTP_FROM');
    $phpmailer->FromName   = env('SMTP_FROM_NAME');
});
```

## Variables de entorno en `.env`

```ini
SMTP_HOST=smtp.tuservidor.com
SMTP_USER=tu@email.com
SMTP_PASS=tu_password
SMTP_PORT=587
SMTP_ENCRYPTION=tls
SMTP_FROM=tu@email.com
SMTP_FROM_NAME="Hidroeléctricas"
```

## Ventajas sobre wp-mail-smtp

- Sin UI en el admin (menos superficie de ataque)
- Credenciales en `.env`, no en la base de datos
- Sin dependencia de plugin externo
