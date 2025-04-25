<?php
# /App/Glory/Config/ajaxPageSetup.php

/**
 * Configures and enqueues the AJAX page navigation script.
 *
 * @return void
 */
function ajaxPageConfig() {
    $script_handle = 'glory-ajax-nav';
    $script_rel_path = '/App/Glory/js/ajax-page.js'; // Relative to theme root
    $script_path = get_template_directory() . $script_rel_path;
    $script_url = get_template_directory_uri() . $script_rel_path;

    if (file_exists($script_path)) {
        wp_enqueue_script(
            $script_handle,
            $script_url,
            [], // JS dependencies (e.g. ['jquery'])
            filemtime($script_path), // Auto-versioning by modification time
            true // Load in footer
        );

        // Configuration to pass to the JS script
        $config = [
            'enabled'            => true, // Globally enable (true) or disable (false) AJAX navigation
            'contentSelector'    => '#content', // CSS selector for the main content container to replace
            'mainScrollSelector' => '#main', // CSS selector for the container to scroll to 0 (or 'window')
            'loadingBarSelector' => '#loadingBar', // CSS selector for the progress bar (optional, can be null)
            'cacheEnabled'       => true, // Enable (true) or disable (false) page caching
            // URL patterns (JavaScript regex) that *ignore* AJAX navigation
            'ignoreUrlPatterns'  => [
                '/wp-admin',
                '/wp-login\\.php', // Escape dots in regex
                '\\.(pdf|zip|rar|jpg|jpeg|png|gif|webp|mp3|mp4|xml|txt|docx|xlsx)$' // Files
            ],
            // URL parameters that *disable caching* for that page (not AJAX navigation)
            'ignoreUrlParams'    => ['s', 'nocache', 'preview'],
            'noAjaxClass'        => 'no-ajax',
        ];

        wp_localize_script($script_handle, 'gloryAjaxNavConfig', $config);
    } else {
        error_log('Glory AJAX Nav script not found at: ' . $script_path);
    }
}

add_action('wp_enqueue_scripts', 'ajaxPageConfig');
