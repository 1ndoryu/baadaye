<?php

use Glory\Class\PostTypeManager;

PostTypeManager::define(
    'portfolio_item',
    [
        'public'        => true,
        'has_archive'   => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_position' => 20,
        'menu_icon'     => 'dashicons-portfolio',
        'supports'      => [
            'title',
            'editor',
            'thumbnail',
            'excerpt',
        ],
        'rewrite'       => [
            'slug' => 'portfolio',
        ],
        'show_in_rest'  => true,
        'hierarchical'  => false,
    ],
    'Portfolio Item',
    'Portfolio Items'
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