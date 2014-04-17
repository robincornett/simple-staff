<?php
/**
 * Custom staff post type
 *
 * @package   Staff_Post_Type
 * @author    Robin Cornett <hello@robincornett.com>
 * @license   GPL-2.0+
 * @link      http://robincornett.com
 * @copyright 2014 Robin Cornett Creative, LLC
 *
 * Plugin Name:       Simple Staff Post Type
 * Plugin URI:        http://robincornett.com
 * Description:       This sets up a simple Staff CPT.
 * Author:            Robin Cornett
 * Author URI:        http://robincornett.com
 * Text Domain:       simple-staff
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Version:           1.0.0
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SIMPLE_STAFF', plugin_dir_path( __FILE__ ) );

add_action( 'init', 'simple_staff_post_type' );
function simple_staff_post_type() {

	$labels = array(
		'name'          => __( 'Staff', 'simple-staff' ),
		'singular_name' => __( 'Staff', 'simple-staff' ),
	);

	$supports = array( 'title', 'editor', 'thumbnail', 'genesis-cpt-archives-settings', 'page-attributes', 'genesis-seo' );

    $post_type_args = array(
    	'labels'              => $labels,
		'menu_icon'           => 'dashicons-groups',
		'exclude_from_search' => false,
		'has_archive'         => true,
		'hierarchical'        => true,
		'public'              => true,
		'rewrite'             => array( 'slug' => 'staff' ),
		'supports'            => $supports,
	);

	register_post_type( 'staff', $post_type_args );
}

add_action( 'wp_enqueue_scripts', 'simple_staff_script' );
function simple_staff_script() {
	if( is_post_type_archive( 'staff' ) ) {
		wp_enqueue_script( 'staff-fader', plugins_url( 'views/staff.js', __FILE__ ), array( 'jquery' ), false, false );
		wp_enqueue_style( 'staff-style', plugins_url( 'views/staff.css', __FILE__ ), array(), 1.0 );
	}
}

add_action( 'pre_get_posts', 'simple_staff_order', 9999 );
function simple_staff_order( $query ) {
	if ( $query->is_main_query() && is_post_type_archive( 'staff' ) ) {
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', -1 );
	}
}

/**
 * Template Redirect
 * Use plugin templates for custom post types.
 */
add_filter( 'template_include', 'simple_staff_load_custom_templates' );
function simple_staff_load_custom_templates( $original_template ) {
	if ( basename( get_template_directory() ) == 'genesis' ) {
		if ( is_post_type_archive( 'staff' ) ) {
			return SIMPLE_STAFF . '/views/archive-staff.php';
		}
		elseif ( is_singular( 'staff' ) ) {
			return SIMPLE_STAFF . '/views/single-staff.php';
		}
		else {
			return $original_template;
		}
	}
	else {
		return $original_template;
	}
}

add_action( 'widgets_init', 'simple_staff_register_widget' );
/**
 * Register sidebar to show after staff archive/single
 */
function simple_staff_register_widget() {
	register_sidebar( array(
		'id'				=> 'after-staff',
		'name'			=> __( 'After Staff', 'simple-staff' ),
		'description'	=> __( 'This is a widget area which will show after the staff archive page or single staff entry content.', 'simple-staff' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>'
	) );
}