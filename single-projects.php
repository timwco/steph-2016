<?php
/**
 * This file adds the Landing template to the Fabricated Child Theme.
 *
 * @author StudioPress
 * @package Fabricated
 * @subpackage Customizations
 * @author Tim Whitacre
 */

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action ('genesis_loop', 'genesis_do_loop'); // Remove the standard loop
add_action( 'genesis_loop', 'custom_do_grid_loop' ); // Add custom loop
function custom_do_grid_loop() {  
    
  // Intro Text (from page content)
  echo '<div class="page-entry entry project-piece">';
  echo '<h1 class="entry-title">'. get_the_title() .'</h1>';
  echo '<a class="moreProjects" href="/projects">See More Projects &raquo;</a>';
  echo '<div class="entry-content projectWrapper">' . get_the_content() ;

  if( have_posts() ):
        
    while( have_posts() ): the_post(); global $post; ?>

      <div class="one-fourth first">
        <?php echo get_the_post_thumbnail( $id, array(250,250) ) ?>
      </div>
      <div class="three-fourths last">
        <?php the_content() ?>
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