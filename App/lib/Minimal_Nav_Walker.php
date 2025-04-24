<?php

class Minimal_Nav_Walker extends Walker_Nav_Menu
{

    # Start Element -> Creates the <a> tag
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        # Combine classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-link'; # Add our base class
        $classes[] = 'menu-item-' . $item->ID; # Keep unique item id class if needed

        # Check for current item classes added by WP
        $isCurrent = in_array('current-menu-item', $classes) ||
            in_array('current_page_item', $classes) ||
            in_array('current-menu-ancestor', $classes); # Include ancestor for child pages

        if ($isCurrent) {
            $classes[] = 'w--current'; # Add our active class
        }

        # Filter out WP default classes we don't want (optional, can be strict)
        $allowedClasses = array('nav-link', 'w--current', 'menu-item-' . $item->ID); // Add any others you might want
        $classes = array_intersect($classes, $allowedClasses);
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';


        # Link attributes
        $atts = array();
        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = ! empty($item->target)     ? $item->target     : '';
        $atts['rel']    = ! empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = ! empty($item->url)        ? $item->url        : '';
        $atts['aria-current'] = $item->current ? 'page' : ''; # WP adds this, keep it for accessibility

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        # Get item title
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        # Build the output <a> tag
        $item_output = $args->before; # Typically empty
        $item_output .= '<a' . $attributes . $class_names . '>';
        $item_output .= $args->link_before . $title . $args->link_after; # Typically empty
        $item_output .= '</a>';
        $item_output .= $args->after; # Typically empty

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    # End Element -> We don't need </li> so this does nothing
    function end_el(&$output, $item, $depth = 0, $args = null)
    {
        return;
    }

    # Start Level -> We don't want submenus (ul) for depth=1
    function start_lvl(&$output, $depth = 0, $args = null)
    {
        return;
    }

    # End Level -> We don't want submenus (ul closing tag)
    function end_lvl(&$output, $depth = 0, $args = null)
    {
        return;
    }
}
