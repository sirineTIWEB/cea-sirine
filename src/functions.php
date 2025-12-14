<?php
/**
 * Functions and definitions for theme-cea-sirine
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Remove automatic paragraph wrapping from content
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

// Theme setup
function theme_cea_sirine_setup() {
    // Add theme support for title tag
    add_theme_support('title-tag');

    // Add theme support for custom logo
    add_theme_support('custom-logo');

    // Add theme support for post thumbnails (featured images)
    add_theme_support('post-thumbnails');

    // Set custom image sizes
    add_image_size('thumbnail', 150, 150, true);      // Hard crop
    add_image_size('medium', 300, 300, false);        // Soft proportional crop
    add_image_size('medium_large', 768, 0, false);    // No height limit
    add_image_size('large', 1024, 1024, false);       // Soft proportional crop

    // Add theme support for HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menu
    register_nav_menu('primary', esc_html__('Navigation Menu', 'theme-cea-sirine'));
}
add_action('after_setup_theme', 'theme_cea_sirine_setup');

// Enqueue scripts and styles
function theme_cea_sirine_scripts() {
    // Adobe Fonts (Typekit)
    wp_enqueue_style('adobe-fonts', 'https://use.typekit.net/iis6mvj.css', array(), null);

    // Main stylesheet
    wp_enqueue_style('theme-cea-sirine-style', get_stylesheet_uri());

    // GSAP Library
    wp_enqueue_script('gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array('gsap'), '3.12.5', true);

    // GSAP Animations
    wp_enqueue_script('theme-cea-gsap-animations', get_template_directory_uri() . '/assets/js/gsap-animations.js', array('gsap', 'gsap-scrolltrigger'), '1.0.0', true);

    // Main JavaScript
    wp_enqueue_script('theme-cea-sirine-main', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0', true);

    // Contact Form animation
    wp_enqueue_script('theme-cea-contact-form', get_template_directory_uri() . '/js/contact-form.js', array(), '1.0.0', true);

}
add_action('wp_enqueue_scripts', 'theme_cea_sirine_scripts');
