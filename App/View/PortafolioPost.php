<?php

// Prevenir acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Asegurarse de que las variables necesarias existen
if (!isset($post) || !is_a($post, 'WP_Post') || !isset($itemClass) || !isset($position)) {
    // Podrías loguear un error aquí si lo necesitas
    return;
}

// Obtener las clases base del post
$post_classes = get_post_class($itemClass, $post->ID);

// Crear y añadir la clase de posición
// Asegurarse de que la posición es un número válido > 0
if (is_numeric($position) && $position > 0) {
    $position_class = 'post-position-' . (int)$position;
    // Añadir la clase de posición al array de clases
    $post_classes[] = sanitize_html_class($position_class); // Sanitize por si acaso
}

// Obtener otros datos como antes
$year = get_post_meta($post->ID, 'year', true);

?>
<article id="post-<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr(implode(' ', $post_classes)); ?>">

    <?php if (has_post_thumbnail($post->ID)) : ?>
        <div class="post-thumbnail">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" aria-hidden="true" tabindex="-1">
                <?php
                echo get_the_post_thumbnail($post->ID, 'large');
                ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="div-title">
        <p class="post-title">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" rel="bookmark">
                <?php echo esc_html(get_the_title($post->ID)); ?>
            </a>
        </p>

        <?php if (!empty($year)) : // Corregido: Mostrar si NO está vacío 
        ?>
            <p class="post-year"><?php echo esc_html($year); ?></p>
        <?php endif; ?>
    </div>

    <div class="post-content" style="display: none;">
        <?php
        $content = get_the_content(null, false, $post->ID);
        echo apply_filters('the_content', $content);
        ?>
    </div>

    <?php
    // Asegúrate de que $options también se pasa si esta acción la necesita
    // (Ya está en $templateData, así que debería estar disponible si se extrajo correctamente)
    if (isset($options)) {
        do_action('glory_post_display_item_content', $post, $options);
    }
    ?>

</article><!-- #post-<?php echo esc_attr($post->ID); ?> -->