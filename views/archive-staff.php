<?php
/**
 * Archive for Simple Staff Custom Post Type.
 *
 * @author Robin Cornett
 * @package Staff_Post_Type
 */

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'simple_staff_archive_loop' );

function simple_staff_archive_loop() {
	echo '<div class="entry">';

	global $wp_query, $post;


	if ( have_posts() ) :
		echo '<div class="descriptions">';
		while ( have_posts() ) : the_post();

			if( 0 == $wp_query->current_post ) { ?>
				<article id="<?php the_ID(); ?>-desc" <?php post_class( 'active-desc' ); ?>> <?php
			}
			else { ?>
				<article id="<?php the_ID(); ?>-desc" <?php post_class( '' ); ?> style="display:none"> <?php

			}
			echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
			echo get_the_post_thumbnail( $post->ID, 'medium', array( 'class' => 'alignright' ) );
			$department = get_the_term_list( $post->ID, 'department', '', ' ,', '' );
			if ( $department ) {
				echo '<h4>Department: ' . $department . '</h4>';
			}
			echo the_content();

			echo '</article>';
		endwhile;

		if ( is_active_sidebar( 'after-staff' ) ) {
			echo '<div class="after-staff">';
			genesis_widget_area( 'after-staff' );
			echo '</div>';
		}
		echo '</div>';

	endif;

	rewind_posts();

	if ( have_posts() ) : // second loop for thumbs
		while ( have_posts() ) : the_post();
			if( 0 == $wp_query->current_post ) { ?>
				<article id="<?php the_ID(); ?>" <?php post_class( 'active-staff thumb' ); ?>> <?php
			}
			else { ?>
				<article id="<?php the_ID(); ?>" <?php post_class( 'thumb' ); ?>> <?php
			}
			echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
			echo '<h4>' . get_the_title() . '</h4>';
			echo '</article>';
		endwhile;
	endif;

	echo '</div>'; // close desc-wrapper and entry
}

genesis();
