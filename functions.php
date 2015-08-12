<?php
/**
 * Theme Functions
 *
 * @package     Fabricated
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, The Pixelista
 * @license     GPL-2.0+
 * @since       1.0.0
 */

/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

load_child_theme_textdomain( 'fabricated', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'fabricated' ) );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', __( 'Fabricated Theme', 'fabricated' ) );
define( 'CHILD_THEME_URL', 'http://thepixelista.com/themes/fabricated/' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array(
	'width' 	=> 1140,
	'height' 	=> 150
) );

/** Add support for custom background */
add_theme_support( 'custom-background' );

/** Sets Content Width */
$content_width = apply_filters( 'content_width', 680, 680, 1020 );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array(
	'fabricated-purple' => __( 'Purple', 'fabricated' ),
	'fabricated-blue'   => __( 'Blue', 'fabricated' ),
	'fabricated-green'  => __( 'Green', 'fabricated' ),
) );

add_action( 'wp_enqueue_scripts', 'fabricated_load_google_fonts' );
/**
 * Enqueue Google fonts
 *
 * @since 2.0.0
 */
function fabricated_load_google_fonts() {
	wp_enqueue_style(
		'fabricated-google-fonts',
		'http://fonts.googleapis.com/css?family=Open+Sans|Cutive|Sanchez|Sacramento|Julius+Sans+One',
		array(),
		CHILD_THEME_VERSION
	);
}

add_action( 'wp_enqueue_scripts', 'fabricated_load_javascript' );
/**
 * Register and enqueue JavaScript Files
 *
 * @since 2.0.0
 */
function fabricated_load_javascript() {
	wp_enqueue_script( 'fabricated-mobile-menu', get_stylesheet_directory_uri() . '/js/mobile-menu.js', array('jquery'), '2.0.0', true );
	if ( is_home() ) {
		wp_enqueue_script( 'fabricated-home-slider', get_stylesheet_directory_uri() . '/js/home-slider.js', array('jquery'), '2.0.0', true );
	}
 }

/** Unregister layout settings */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

/** Unregister secondary sidebar */
unregister_sidebar( 'sidebar-alt' );

/** Add new image sizes */
add_image_size( 'featured', 285, 100, TRUE );
add_image_size( 'slider', 1140, 445, TRUE );

/** Relocate the post info */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_before_entry', 'genesis_post_info', 12 );

add_filter( 'comment_form_defaults', 'fabricated_comment_text' );
/**
* Change the comment form arguments.
*/
function fabricated_comment_text( $args ) {
	$args['title_reply'] = __( 'Speak Your Mind', 'text-domain' );
	$args['comment_notes_before'] = '';
	$args['comment_notes_after'] = '';
	return $args;
}

/** Customize the post info function */
add_filter( 'genesis_post_info', 'fabricated_post_info_filter', 12 );
function fabricated_post_info_filter( $post_info ) {
	if ( ! is_page() ) {
	    $post_info = '
	    <div class=\'date-info\'>' .
	    	__( 'published', 'fabricated' ) .
		    ' [post_date format="F j, Y" before="<span class=\'date\'>" after="</span>"] ' . '
	    </div>
	    <div class="comments">
	    	[post_comments]
	    </div>';
	    return $post_info;
	}
}

/** Change the default comment callback */
add_filter( 'genesis_comment_list_args', 'fabricated_comment_list_args' );
function fabricated_comment_list_args( $args ) {
	$args['callback'] = 'fabricated_comment_callback';
	return $args;
}

/** Customize the comment section */
function fabricated_comment_callback( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<?php do_action( 'genesis_before_comment' ); ?>

		<div class="comment-header">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, $size = $args['avatar_size'] ); ?>
				<?php printf( '<cite class="fn">%s</cite> <span class="says">%s:</span>', get_comment_author_link(), apply_filters( 'comment_author_says_text', __( 'says', 'fabricated' ) ) ); ?>
				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( '%1$s ' . __( 'at', 'fabricated' ) . ' %2$s', get_comment_date(), get_comment_time() ); ?></a>
				<?php edit_comment_link( __( 'Edit', 'fabricated' ), g_ent( '&bull; ' ), '' ); ?>
				</div><!-- end .comment-meta -->
		 	</div><!-- end .comment-author -->
		</div><!-- end .comment-header -->
		<div class="comment-content">
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p class="alert"><?php echo apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'fabricated' ) ); ?></p>
			<?php endif; ?>
			<?php comment_text(); ?>
		</div><!-- end .comment-content -->
		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
		<?php do_action( 'genesis_after_comment' );
	/** No ending </li> tag because of comment threading */
}

add_filter( 'genesis_footer_output', 'fabricated_footer_output_filter', 10, 3 );
/**
* Amend footer content.
*
* @since 1.0
*
* @param string $output
* @param string $creds
* @return string HTML markup
*/
function fabricated_footer_output_filter( $output, $creds ) {
	$backtotop_text = '[footer_backtotop]';
	$creds_start = 'Copyright [footer_copyright] ';
	$creds_end = '<a href="http://stephwhitacre.com">Steph Whitacre</a> | Built on the <a href="http://www.studiopress.com/" target="_blank">Genesis Framework</a> | Published via <a href="http://desk.pm/" target="_blank">Desk</a>';
	$output = '<div class="footer"><div class="creds">' . $creds_start . $creds_end . '</div></div>';
	return $output;
}

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Register widget areas **/
genesis_register_sidebar( array(
	'id'			=> 'home-slider',
	'name'			=> __( 'Home - Slider', 'fabricated' ),
	'description'	=> __( 'This is the slider section on the home page.', 'fabricated' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-top',
	'name'			=> __( 'Home - Top', 'fabricated' ),
	'description'	=> __( 'This is the top section of the home page.', 'fabricated' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-cta',
	'name'			=> __( 'Home - Call To Action', 'fabricated' ),
	'description'	=> __( 'This is the call to action section on the home page.', 'fabricated' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-middle',
	'name'			=> __( 'Home - Middle', 'fabricated' ),
	'description'	=> __( 'This is the middle section of the home page.', 'fabricated' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-twitter',
	'name'			=> __( 'Home - Twitter', 'fabricated' ),
	'description'	=> __( 'This is the twitter feed section on the home page.', 'fabricated' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom',
	'name'			=> __( 'Home - Bottom', 'fabricated' ),
	'description'	=> __( 'This is the bottom section of the home page.', 'fabricated' ),
) );


//* Projects Custom Post Type
function projects_register() {
  $args = array(
      'label' => __('Projects'),
      'singular_label' => __('projects'),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'has_archive' => true,
      'capability_type' => 'page',
      'hierarchical' => true,
      '_builtin' => false,
      'supports' => array('title','editor','thumbnail', 'page-attributes', 'genesis-seo'),
      'rewrite' => array('slug'=>'projects','with_front'=>false),
      'menu_icon' => 'dashicons-welcome-widgets-menus'
    );
  register_post_type( 'projects' , $args );
  flush_rewrite_rules();
}
add_action('init', 'projects_register');



