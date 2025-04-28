<?php



// Prevenir acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

if (!isset($post) || !is_a($post, 'WP_Post')) {
    return;
}

$post_classes = get_post_class($itemClass, $post->ID);
$year = get_post_meta($post->ID, 'year', true);

?>
<article id="post-<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr(implode(' ', $post_classes)); ?>">

    <?php if (has_post_thumbnail($post->ID)) : ?>
        <div class="post-thumbnail">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" aria-hidden="true" tabindex="-1">
                <?php
                // (thumbnail, large, full, o uno personalizado)
                echo get_the_post_thumbnail($post->ID, 'large');
                ?>
            </a>
        </div>
    <?php endif;

    ?>
    <div class="div-title">
        <p class="post-title">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" rel="bookmark">
                <?php echo esc_html(get_the_title($post->ID)); ?>
            </a>
        </p>

        <?php

        if (empty($year)) : ?>
            <p class="post-year">Test<?php echo esc_html($year); ?></p>
        <?php endif; ?>
    </div>

    <div class="post-content" style="display: none;">
        <?php
        $content = get_the_content(null, false, $post->ID);
        echo apply_filters('the_content', $content);
        ?>
    </div>

    <?php
    do_action('glory_post_display_item_content', $post, $options);

    ?>

</article><!-- #post-<?php echo esc_attr($post->ID); ?> -->