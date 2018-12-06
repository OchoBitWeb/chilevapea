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
		'name'          => 'Topbar Widget Right',
		'id'            => 'topbar_widget_right',
		'before_widget' => '<div  class="section">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => 'Topbar Widget Left',
		'id'            => 'topbar_widget_left',
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
function topbar_widget_right( $content ) {
	echo '<div id="topbar">';
	if ( is_active_sidebar( 'topbar_widget_left' ) && is_main_query() ) {
		echo '<div id="topbar-left">';
		dynamic_sidebar( 'topbar_widget_left' );
		echo '</div>';
	}
	if ( is_active_sidebar( 'topbar_widget_right' ) && is_main_query() ) {
		echo '<div id="topbar-right">';
		dynamic_sidebar( 'topbar_widget_right' );
		echo '<div class="section">';
		storefront_product_search();
		echo '</div></div>';
	}
	echo '</div>';
	return $content;
}
add_filter( 'storefront_header', 'topbar_widget_right' );

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

// Remove header cart

function remove_sf_actions() {
	remove_action( 'storefront_header', 'storefront_header_cart', 60 );
	remove_action( 'storefront_header', 'storefront_product_search', 40 );
	remove_action( 'homepage', 'storefront_homepage_content', 5 );
	remove_action( 'homepage', 'storefront_popular_products', 5 );
	remove_action( 'homepage', 'storefront_on_sale_products', 5 );
	remove_action( 'homepage', 'storefront_best_selling_products', 5 );
	remove_action( 'storefront_content_top', 'storefront_shop_messages', 15 );
	remove_action( 'storefront_homepage', 'storefront_homepage_header', 10 );
	remove_action( 'storefront_homepage', 'storefront_page_content', 20 );
}
add_action( 'init', 'remove_sf_actions', 1 );

function tp_homepage_blocks_custom() {
	/* Shop by Category */
	add_filter( 'storefront_product_categories_args', function( $args ) {
		$args = array(
			'orderby' => 'title',
			'order'   => 'DESC',
			'limit'   => 5,
			'columns' => 5,
			'child_categories' => '',
			'title' => __( 'Categorías', 'storefront' ),
		);
		return $args;
	} );

	/* New In */
	add_filter( 'storefront_recent_products_args', function( $args ) {
		$args = array(
			'orderby' => 'title',
			'order'   => 'DESC',
			'limit'   => 5,
			'columns' => 5,
			'title'   => __( 'Productos Recientes', 'storefront' ),

		);
		return $args;
	} );
	/* Best Sellers */
	add_filter( 'storefront_best_selling_products_args', function( $args ) {
		$args = array(
			'orderby' => 'title',
			'order'   => 'DESC',
			'limit'   => 5,
			'columns' => 5,
			'title'   => __( 'Mejores Vendidos', 'storefront' ),
		);
		return $args;
	} );

	/* And so on.... */
}
add_action( 'after_setup_theme', 'tp_homepage_blocks_custom' );


/* Footer Credits */
function storefront_credit() {
	?>
	<div class="site-info">
		<?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?>
		<?php if ( apply_filters( 'storefront_credit_link', true ) ) { ?>
		<br />
		<?php
		if ( apply_filters( 'storefront_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
			the_privacy_policy_link( '', '' );
		}
		?>
		<?php } ?>
	</div><!-- .site-info -->
	<?php
}

/* Logo Carousel Home*/
function logo_carousel_home() {
	?>
	<section class="storefront-product-section storefront-product-brands">
		<h2 class="section-title">Marcas</h2>
		<div><?php echo do_shortcode( '[logocarousel id="804"]' ); ?></div>
	</section>
	<?php
}
add_filter( 'storefront_homepage_after_product_categories', 'logo_carousel_home' );

function full_width_headers() {
	?>
		<div class="full-width_title">
			<?php
			echo the_title( '<h3>', '</h3>' );
			?>
		</div>
	<?php
}
add_filter( 'storefront_before_content', 'full_width_headers' );


/* Mensaje evios */
function wnd_checkout_message_bottom() {
	echo '<div class="wnd-checkout-message">
		<p><strong>Región Metropolitana de Santiago:</strong></p>
		<p>
			<ol>
				<li>Todo envió será hecho a la sucursal de ChileExpress mas cercana al cliente, <strong>con cobro a destino.</strong> <strong class="alert">Será de mucha ayuda para nosotros que coloques la sucursal de tu preferencia para retirar tus productos.</strong></li>
				<li>Toda compra que supere los <strong>50.000 $</strong> tendrán envió gratuito y llegara directo a tu domicilio sin necesidad de que vayas a retirar en sucursal. </li>
			</ol>
		</p>
		<p><strong>Regiones:</strong></p>
		<p>
			<ol>
				<li>Todo envió será hecho a la sucursal de ChileExpress mas cercana al cliente, <strong>con cobro a destino.</strong> <strong class="alert">Será de mucha ayuda para nosotros que coloques la sucursal de tu preferencia para retirar tus productos.</strong></li>
				<li>Toda compra que supere los <strong>100.000 $</strong> tendrán envió gratuito hasta la sucursal de ChileExpress mas cercana al cliente.</li>
			</ol>
		</p>
	</div>';
}
add_action( 'woocommerce_after_shipping_rate', 'wnd_checkout_message_bottom', 10 );
