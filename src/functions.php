<?php
/**
 * Functions and definitions for theme-cea-sirine
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function theme_cea_sirine_setup() {
    // Add theme support for title tag
    add_theme_support('title-tag');

    // Add theme support for custom logo
    add_theme_support('custom-logo');

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
    // Main stylesheet
    wp_enqueue_style('theme-cea-sirine-style', get_stylesheet_uri());

    // Main JavaScript
    wp_enqueue_script('theme-cea-sirine-main', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'theme_cea_sirine_scripts');
