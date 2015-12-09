<?php

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action( 'genesis_entry_content', 'simple_staff_entry_content', 12 );
function simple_staff_entry_content() {
	$department = get_the_term_list( get_the_ID(), 'department', '', ' ,', '' );
	if ( $department ) {
		echo '<h4>Department: ' . $department . '</h4>';
	}
	echo get_the_post_thumbnail( get_the_ID(), 'medium', array( 'class' => 'alignright' ) );
	echo the_content();
}

add_action( 'genesis_entry_content', 'simple_staff_sidebar', 20 );
function simple_staff_sidebar() {
	if ( is_active_sidebar( 'after-staff' ) ) {
		echo '<div class="after-staff">';
		genesis_widget_area( 'after-staff' );
		echo '</div>';
	}
}

genesis();
