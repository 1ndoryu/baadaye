<?php

use Glory\Class\PostTypeManager;

# aca agrega metas por defecto, (descripcion corta), año, tiempo, cliente, pais, presupuesto (en ingles todo), con valores por defecto 
PostTypeManager::define(
    'portfolio_item', // Slug del CPT
    [ // Argumentos para register_post_type
        'public'        => true,
        'has_archive'   => true, // Habilita un archivo para /portfolio/
        'show_ui'       => true, // Muestra la UI en el admin
        'show_in_menu'  => true, // Muestra en el menú de admin
        'menu_position' => 20,   // Posición en el menú (debajo de Páginas)
        'menu_icon'     => 'dashicons-portfolio', // Icono del menú
        'supports'      => [
            'title',        // Campo de título
            'editor',       // Editor principal (Gutenberg/Clásico)
            'thumbnail',    // Imagen destacada
            'excerpt',      // Extracto (puede usarse para la descripción corta si se prefiere)
            // 'custom-fields' será añadido automáticamente por la clase si no está ya
        ],
        'rewrite'       => [
            'slug' => 'portfolio', // URL base para las entradas individuales (tusitio.com/portfolio/mi-proyecto/)
        ],
        'show_in_rest'  => true, // Necesario para el editor de bloques y API REST
        'hierarchical'  => false, // No es jerárquico (como las páginas)
    ],
    'Portfolio Item', // Nombre singular
    'Portfolio Items', // Nombre plural
    [ // <-- Array de Metas por Defecto
        'short_description' => '',       // Descripción corta (string vacío)
        'year'              => '',       // Año (string vacío, o podrías poner date('Y') para el año actual)
        'duration'          => '',       // Tiempo/Duración (string vacío, ej: "3 months", "Ongoing")
        'client'            => '',       // Cliente (string vacío)
        'country'           => '',       // País (string vacío)
        'budget'            => 0.00      // Presupuesto (numérico, 0.00 por defecto)
    ]
);


PostTypeManager::define(
    'service',
    [
        'public'        => true,
        'has_archive'   => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_position' => 25,
        'menu_icon'     => 'dashicons-yes-alt',
        'supports'      => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'page-attributes',
        ],
        'rewrite'       => [
            'slug' => 'services',
        ],
        'show_in_rest'  => true,
        'hierarchical'  => false,
    ],
    'Service',
    'Services'
);

PostTypeManager::register();