<?php

return [
    // Features
    'feat_title' => '¿Por qué elegir RemoveBG?',
    'feat_sub'   => 'Una forma rápida, privada y totalmente gratuita de recortar el fondo de cualquier foto.',
    'feat1_t' => 'Funciona en tu navegador',
    'feat1_d' => 'El modelo de IA se ejecuta localmente con WebAssembly, sin colas de servidor y sin depender de un servicio de procesamiento remoto.',
    'feat2_t' => 'Privado por diseño',
    'feat2_d' => 'Tus fotos nunca se suben. Todo ocurre en tu propio dispositivo, lo que hace la herramienta segura para retratos personales, trabajos de clientes y fotos confidenciales de productos.',
    'feat3_t' => 'Gratis y sin límites',
    'feat3_d' => 'Procesa tantas imágenes como quieras. No hay cuenta, sistema de créditos, cuota diaria ni marca de agua en el archivo exportado.',
    'feat4_t' => 'Bordes limpios',
    'feat4_d' => 'El modelo de segmentación está entrenado para seguir detalles finos como cabello, pelo, telas y tirantes delgados, logrando recortes de aspecto natural.',
    'feat5_t' => 'Salida en PNG transparente',
    'feat5_d' => 'Cada resultado se exporta como PNG transparente, listo para usar en software de diseño, presentaciones, sitios web o fichas de tiendas en línea.',
    'feat6_t' => 'Funciona en cualquier dispositivo',
    'feat6_d' => 'Úsalo en portátil, tableta o teléfono. Cualquier navegador moderno con soporte de WebAssembly ejecuta la herramienta sin instalar nada.',

    // Tips
    'tips_title' => 'Consejos para obtener los mejores resultados',
    'tips_sub'   => 'Pequeñas decisiones al tomar o elegir una foto marcan una gran diferencia en el recorte final.',
    'tip1_t' => 'Usa buena iluminación',
    'tip1_d' => 'Una luz suave y uniforme revela el contorno real de tu sujeto. Las sombras duras y el contraluz fuerte pueden difuminar el límite entre sujeto y fondo.',
    'tip2_t' => 'Busca contraste',
    'tip2_d' => 'Un sujeto cuyo color se diferencia claramente del entorno es más fácil de separar. Un producto oscuro sobre una superficie clara es un ejemplo clásico.',
    'tip3_t' => 'Mantén el sujeto nítido',
    'tip3_d' => 'Asegúrate de que el sujeto principal esté enfocado. El desenfoque por movimiento o el foco suave en los bordes producen recortes menos precisos.',
    'tip4_t' => 'Empieza con alta resolución',
    'tip4_d' => 'Las imágenes grandes contienen más detalle en los bordes. Siempre que sea posible, sube el archivo original en lugar de una copia muy comprimida o una captura de pantalla.',
    'tip5_t' => 'Evita el desorden',
    'tip5_d' => 'Un fondo sencillo con pocos objetos superpuestos ayuda al modelo a decidir qué pertenece al sujeto y qué no.',
    'tip6_t' => 'Prueba sobre distintos colores',
    'tip6_d' => 'Tras exportar, coloca el PNG sobre un fondo claro y otro oscuro para confirmar que los bordes se ven limpios en ambos casos.',

    // Guide
    'guide_title' => 'Guía práctica para eliminar fondos de imágenes',
    'guide_intro' => 'Ya sea que vendas productos en línea, diseñes material de marketing o quieras una foto de perfil impecable, estas notas explican las ideas clave de una buena eliminación de fondo y cómo lograr resultados profesionales.',
    'guide1_t' => '¿Qué es un PNG transparente?',
    'guide1_d' => 'Un archivo PNG puede almacenar un canal alfa, que registra cuán transparente es cada píxel. Al eliminar el fondo, esos píxeles quedan totalmente transparentes y el sujeto puede colocarse sobre cualquier color, degradado o foto. Los archivos JPG no guardan transparencia, por eso el resultado exportado es siempre PNG.',
    'guide2_t' => 'Preparar fotos de producto para marketplaces',
    'guide2_d' => 'Marketplaces como Amazon, eBay y Etsy suelen pedir una imagen principal limpia y sin elementos extra. Elimina el fondo, coloca el PNG sobre un lienzo blanco en tu editor y expórtalo en el tamaño que recomienda la plataforma. Lee siempre las directrices de imagen antes de subirla.',
    'guide3_t' => 'Crear una marca coherente',
    'guide3_d' => 'Los recortes facilitan reutilizar la misma foto en un sitio web, una publicación social y un folleto impreso. Las imágenes transparentes permiten ajustar los colores de la marca, añadir sombras suaves y mantener el mismo aspecto en todos los canales sin tomar nuevas fotos.',
    'guide4_t' => 'Solución de problemas comunes',
    'guide4_d' => 'Si desaparece parte del sujeto o queda fondo, prueba con una imagen más nítida y con más contraste entre sujeto y entorno. Los sujetos muy pequeños, el vidrio, el humo y los objetos del mismo color que el fondo son casos difíciles; otro ángulo de foto suele resolverlos.',

    // More FAQ
    'faq_q6'  => '¿Puedo usar las imágenes con fines comerciales?',
    'faq_a6'  => 'La herramienta no añade ninguna restricción a tus archivos. Sigues siendo responsable de tener derecho a usar la foto original, pero el resultado procesado puede usarse en proyectos personales y comerciales.',
    'faq_q7'  => '¿Funciona en teléfonos móviles?',
    'faq_a7'  => 'Sí. Cualquier navegador móvil moderno con soporte de WebAssembly puede ejecutar la herramienta. En teléfonos antiguos el proceso puede tardar un poco más y recomendamos Wi-Fi para la primera descarga del modelo.',
    'faq_q8'  => '¿Cuál es el tamaño máximo de imagen?',
    'faq_a8'  => 'Puedes subir imágenes JPG, PNG o WebP de hasta 20MB. Las fotos muy grandes requieren más memoria, así que en dispositivos modestos puede ser más rápido redimensionarlas antes.',
    'faq_q9'  => '¿Por qué falta una parte de mi sujeto?',
    'faq_a9'  => 'Suele ocurrir cuando el sujeto tiene un color similar al fondo o está parcialmente desenfocado. Prueba con una foto con mejor iluminación y más contraste y vuelve a ejecutar la herramienta.',
    'faq_q10' => '¿Necesito instalar algo?',
    'faq_a10' => 'No. No hay nada que descargar ni instalar. Abre la página, elige una imagen y descarga el PNG transparente. El modelo de IA se guarda en la caché del navegador tras el primer uso.',

    // About
    'about_title' => 'Acerca de RemoveBG',
    'about_p1' => 'RemoveBG se creó para que la eliminación de fondos con calidad profesional esté al alcance de todos, sin suscripciones, límites ocultos ni sacrificios de privacidad. Creemos que una tarea que usan a diario vendedores, estudiantes, diseñadores y creadores debe ser sencilla, rápida y gratuita.',
    'about_p2' => 'En lugar de enviar tus imágenes a un servidor remoto, el sitio entrega un modelo de IA compacto a tu navegador y deja que tu propio dispositivo haga el trabajo. Este enfoque mantiene tus archivos privados, elimina la espera de subida y nos permite mantener el servicio gratuito para todos.',
    'about_p3' => 'Seguimos mejorando la interfaz, la documentación y los idiomas disponibles. Si tienes una sugerencia o encuentras un problema, tus comentarios nos ayudan a mejorar la herramienta para toda la comunidad.',
];
