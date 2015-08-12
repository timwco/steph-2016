<?php
/**
 * Controls the homepage output.
 */
add_action( 'genesis_meta', 'fabricated_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function fabricated_home_genesis_meta() {
	if ( is_active_sidebar( 'home-slider' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-cta' ) || is_active_sidebar( 'home-middle' ) || is_active_sidebar( 'home-twitter' ) || is_active_sidebar( 'home-bottom' ) ) {
		// Force a full width layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		add_filter( 'body_class', 'fabricated_body_class' );
		/** Add body class to home page **/
		function fabricated_body_class( $classes ) {
			$classes[] = 'fabricated-home';
			return $classes;
		}
		// Remove the default loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		// Add the slider if it's active
		if ( is_active_sidebar( 'home-slider' ) ) {
			add_action( 'genesis_loop', 'fabricated_home_slider' );
		}
		// Add the middle section if sidebars are active
		if ( is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-cta' ) || is_active_sidebar( 'home-middle' ) ) {
			add_action( 'genesis_loop', 'fabricated_home_middle' );
		}
		// Add the bottom section if sidebars are active
		if ( is_active_sidebar( 'home-twitter' ) || is_active_sidebar( 'home-bottom' ) ) {
			add_action( 'genesis_loop', 'fabricated_home_bottom' );
		}
	}
}

// Display the slider section
function fabricated_home_slider() {
	// genesis_widget_area( 'home-slider', array(
	// 	'before' => '<div class="home-slider widget-area">',
	// 	'after' => '</div>',
	// ) );
	?>

		<section class="homeTop">
			<div class="htLeft">
				<div class="imgBlock ibLarge">
					<a href="http://stephwhitacre.com/blog/"><img src="http://localhost/Steph/wp-content/uploads/2015/08/largeBanner.png"></a>
				</div>
			</div>
			<div class="htRight">
				<div class="imgBlock ibSmall">
					<a href="http://stephwhitacre.com/projects/the-volunteer-project/"><img src="http://localhost/Steph/wp-content/uploads/2015/08/bookLong.png"></a>
				</div>
				<div class="imgBlock ibSmall">
					<a href="http://stephwhitacre.com/cannonball/"><img src="http://localhost/Steph/wp-content/uploads/2015/08/cannonballNew.png"></a>
				</div>
			</div>
		</section>

	<?php
}

// Display the middle section
function fabricated_home_middle() {
	genesis_widget_area( 'home-top', array(
		'before' => '<section class="home-top widget-area">',
		'after' => '</section>',
	) );
	genesis_widget_area( 'home-cta', array(
		'before' => '<aside class="home-cta widget-area">',
	) );
	genesis_widget_area( 'home-middle', array(
		'before' => '<section class="home-middle widget-area">',
		'after' => '</section>',
	) );
}

// Display the bottom section
function fabricated_home_bottom() {
	genesis_widget_area( 'home-twitter', array(
		'before' => '<aside class="home-twitter widget-area">',
	) );
	genesis_widget_area( 'home-bottom', array(
		'before' => '<aside class="home-bottom widget-area">',
	) );
}

genesis();