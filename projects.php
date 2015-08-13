<?php
/**
 * This file adds the Landing template to the Fabricated Child Theme.
 *
 * @author StudioPress
 * @package Fabricated
 * @subpackage Customizations
 * @author Tim Whitacre
 */

/*
Template Name: Projects Page
*/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'custom_do_grid_loop' ); // Add custom loop
function custom_do_grid_loop() {  
    
  // Intro Text (from page content)
  echo '<div class="page-entry entry">';
  echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
  echo '<div class="entry-content projectWrapper">' . get_the_content() ;
  $args = array(
    'post_type' => 'projects', // enter your custom post type
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'posts_per_page'=> '12',  // overrides posts per page in theme settings
  );
  $loop = new WP_Query( $args );
  if( $loop->have_posts() ):
        
    while( $loop->have_posts() ): $loop->the_post(); global $post; ?>

      <div class="project">
        <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( $id, array(250,250) ) ?></a>
        <h3><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></h3>
      </div>

    <?php
    endwhile;
    
  endif;
  
  // Outro Text (hard coded)
  echo '</div><!-- end .entry-content -->';
  echo '</div><!-- end .page .hentry .entry -->';
}
  
/** Remove Post Info */
remove_action('genesis_before_post_content','genesis_post_info');
remove_action('genesis_after_post_content','genesis_post_meta');
 
genesis();