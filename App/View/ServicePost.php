<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!isset($post) || !is_a($post, 'WP_Post') || !isset($itemClass) || !isset($position)) {
    return;
}
$post_classes = get_post_class($itemClass, $post->ID);
if (is_numeric($position) && $position > 0) {
    $position_class = 'post-position-' . (int)$position;
    $post_classes[] = sanitize_html_class($position_class);
}
$year = get_post_meta($post->ID, 'year', true);
?>
<article id="post-<?php echo esc_attr($post->ID); ?>" class="<?php echo esc_attr(implode(' ', $post_classes)); ?>">
    <div class="div-title">
        <p class="post-title">
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" rel="bookmark">
                <?php echo esc_html(get_the_title($post->ID)); ?>
            </a>
        </p>
    </div>

    <div class="post-content">
        <?php
        $content = get_the_content(null, false, $post->ID);
        echo apply_filters('the_content', $content);
        ?>
    </div>
    <?php
    if (isset($options)) {
        do_action('glory_post_display_item_content', $post, $options);
    }
    ?>
</article>