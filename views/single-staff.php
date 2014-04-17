<?php

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_entry_content', 'simple_staff_entry_content', 12 );

function simple_staff_entry_content() {
	global $post;

	echo get_the_post_thumbnail( $post->ID, 'medium', array( 'class' => 'alignright' ) );
	echo the_content();
}

add_action( 'genesis_after_entry', 'simple_staff_sidebar' );
function simple_staff_sidebar() {
if ( is_active_sidebar( 'after-staff' ) ) {
			echo '<div class="after-staff">';
			genesis_widget_area( 'after-staff' );
			echo '</div>';
	}
}

genesis();
