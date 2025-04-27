<?php

/**
 * Plantilla para mostrar un único item en el componente PostDisplay.
 *
 * Variables disponibles:
 * @var WP_Post $post El objeto post actual en el loop.
 * @var array $options Las opciones finales de display pasadas al componente.
 * @var string $itemClass La clase CSS para el elemento article.
 * @var string $titleTag La etiqueta HTML para el título (ej: 'h2', 'h3').
 */

// Prevenir acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Obtener clases estándar de post y añadir nuestra clase personalizada
$post_classes = get_post_class($itemClass, $post->ID); // Pasar ID explícitamente

?>
<article id="post-<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr(implode(' ', $post_classes)); ?>">

    <<?php echo tag_escape($titleTag); ?> class="post-title">
        <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" rel="bookmark">
            <?php echo esc_html(get_the_title($post->ID)); ?>
        </a>
    </<?php echo tag_escape($titleTag); ?>>

    <?php if ($options['show_excerpt']) : ?>
        <div class="post-excerpt">
            <?php echo wp_kses_post(get_the_excerpt($post->ID)); // Usar get_the_excerpt para obtenerlo como string 
            ?>
        </div>
    <?php endif; ?>

    <?php
    /**
     * Hook para añadir contenido adicional dentro del item de PostDisplay.
     * Pasa el objeto $post y las $options.
     */
    do_action('glory_post_display_item_content', $post, $options);

    // Ejemplo: Mostrar miniatura si existe
    // if (has_post_thumbnail($post->ID)) {
    //     echo '<div class="post-thumbnail">';
    //     echo get_the_post_thumbnail($post->ID, 'medium'); // Obtener como string
    //     echo '</div>';
    // }
    ?>

</article><!-- #post-<?php echo esc_attr($post->ID); ?> -->