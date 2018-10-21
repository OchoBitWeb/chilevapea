<?php
/**
 * Chilevapea Theme
 *
 * @package    chilevapea
 */

/**
 * Enqueue the Child Theme CSS
 */
function chilevapea_scripts() {
	// Google Fonts. Add these lines if your website will use a different font.
	wp_enqueue_style( 'chilevapea-pt-serif', 'https://fonts.googleapis.com/css?family=PT+Serif:400,700' );
	//Styles
	wp_enqueue_style( 'storefront-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'chilevapea-style', get_stylesheet_directory_uri() . '/assets/css/custom.css' );
	// Scripts
	wp_enqueue_script( 'chilevapea-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), '20150825', true );
}
add_action( 'wp_enqueue_scripts', 'chilevapea_scripts' );

/**
 * Top Bar widget
 */

// Register widget
function topbar_widgets_init() {
	register_sidebar( array(
		'name'          => 'Topbar Widget',
		'id'            => 'topbar_widget',
		'before_widget' => '<div  class="section">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'Home Banner Widget',
		'id'            => 'home_banner_widget',
		'before_widget' => '<div  class="banner-section">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'topbar_widgets_init' );

// Add to top bar
function topbar_widget( $content ) {
	if ( is_active_sidebar( 'topbar_widget' ) && is_main_query() ) {
		echo '<div id="topbar">';
		dynamic_sidebar( 'topbar_widget' );
		echo '</div>';
	}
	return $content;
}
add_filter( 'storefront_before_header', 'topbar_widget' );

// Add Home Banner

function home_banner_widget( $content ) {
	if ( is_active_sidebar( 'home_banner_widget' ) && is_main_query() && is_front_page() ) {
		echo '<div id="banner">';
		dynamic_sidebar( 'home_banner_widget' );
		echo '</div>';
	}
	return $content;
}

add_filter( 'storefront_before_content', 'home_banner_widget' );
