<?php
# App/Setup/ThemeSetup.php

# Theme setup: Registers menu locations, adds theme support
function themeSetup() {
    # Register navigation menus
    register_nav_menus(array(
        'primary_menu' => 'Primary Menu' # location_slug => Location Name
    ));

    # Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'themeSetup');


# Checks if the default menu exists and is assigned, creates/assigns if not.
function checkAndSetupDefaultMenu() {
    $location = 'primary_menu';
    $menuName = 'Primary Menu';

    # Check if the location has a menu assigned
    $locations = get_nav_menu_locations();
    $menuAssigned = isset($locations[$location]) && $locations[$location] !== 0;

    if ($menuAssigned) {
        return; # Menu already assigned, do nothing
    }

    # Location is empty, check if menu exists
    $menuObject = wp_get_nav_menu_object($menuName);
    $menuId = ($menuObject) ? $menuObject->term_id : null;

    # If menu doesn't exist, create it
    if (!$menuId) {
        $menuId = wp_create_nav_menu($menuName);

        # Check if menu creation was successful
        if (is_wp_error($menuId)) {
            error_log('Failed to create default menu: ' . $menuId->get_error_message());
            return;
        }

        # Define default menu items
        $menuItems = array(
            '/'             => 'Home',
            '/about/'       => 'About',
            '/services/'    => 'Services',
            '/portfolio/'   => 'Portfolio',
            '/blog/'        => 'Blogs',
            '/smme-packages/' => 'SMME Packages',
            '/merch/'       => 'Merch'
        );

        # Add items to the menu
        foreach ($menuItems as $url => $title) {
            wp_update_nav_menu_item($menuId, 0, array(
                'menu-item-title'  => $title,
                'menu-item-url'    => home_url($url),
                'menu-item-status' => 'publish'
            ));
        }
    }

    # Assign the menu (existing or newly created) to the location
    if ($menuId && !isset($locations[$location]) || $locations[$location] == 0) {
        $locations[$location] = $menuId;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

# Run setup on theme activation (best practice for initial setup)
add_action('after_switch_theme', 'checkAndSetupDefaultMenu');

# Run check on admin load (safeguard if not set or gets unassigned)
add_action('admin_init', 'checkAndSetupDefaultMenu');


# Enqueue the main stylesheet
function themeEnqueueStyles() {
	wp_enqueue_style( 'themeStyle', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'themeEnqueueStyles' );

add_filter( 'show_admin_bar', '__return_false' );

?>