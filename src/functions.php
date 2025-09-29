<?php

// relier style

function ajouter_style() {
     wp_enqueue_style( 'monstyle', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'ajouter_style', PHP_INT_MAX );
