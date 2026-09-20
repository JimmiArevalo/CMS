<?php

return [

    // Correo que recibe los avisos del formulario de contacto.
    'admin_email' => env('CMS_ADMIN_EMAIL', 'admin@example.com'),

    // Segundos de espera entre el aviso al administrador y la confirmación.
    // Solo se usa con servicios de prueba que limitan los correos por segundo.
    // En producción debe ser 0.
    'mail_delay_seconds' => (int) env('CMS_MAIL_DELAY_SECONDS', 0),

];