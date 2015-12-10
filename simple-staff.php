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
 * Version:           1.1.0
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
		'taxonomies'          => array( 'department' ),
	);

	register_post_type( 'staff', $post_type_args );
}

// Department taxonomy
add_action( 'init', 'simple_staff_taxonomy' );
function simple_staff_taxonomy() {
	$taxonomy_args = array(
		'labels'    => array(
			'name'         => __( 'Departments', 'simple-staff' ),
			'add_new_item' => __( 'Add New Department', 'simple-staff' ),
			),
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => array( 'slug' => 'department', 'with_front' => false ),
		'show_tagcloud'       => false,
	);

	register_taxonomy( 'department', 'staff', $taxonomy_args );
}

// Show the department as a column
add_filter( 'manage_taxonomies_for_staff_columns', 'simple_staff_show_column' );
function simple_staff_show_column( $taxonomies ) {

	$taxonomies[] = 'department';
	return $taxonomies;

}

add_action( 'wp_enqueue_scripts', 'simple_staff_script' );
function simple_staff_script() {
	if ( ( is_post_type_archive( 'staff' ) || is_tax( 'department' ) ) ) {
		$js_file  = apply_filters( 'simple_staff_js', plugins_url( '/views/staff.js', __FILE__ ) );
		$css_file = apply_filters( 'simple_staff_css', plugins_url( '/views/staff.css', __FILE__ ) );
		wp_enqueue_script( 'staff-fader', $js_file, array( 'jquery' ), '1.1.0', true );
		wp_enqueue_style( 'staff-style', $css_file, array(), '1.1.0' );
	}
}

add_action( 'pre_get_posts', 'simple_staff_order', 9999 );
function simple_staff_order( $query ) {
	if ( $query->is_main_query() && ( is_post_type_archive( 'staff' ) || is_tax( 'department' ) ) ) {
		$query->set( 'orderby', 'menu_order' );
		$query->set( 'order', 'ASC' );
		$query->set( 'posts_per_page', -1 );
	}
}

/**
 * Template Redirect
 * Use plugin templates for custom post types.
 */
add_action( 'after_setup_theme', 'simple_staff_load_templates' );
function simple_staff_load_templates() {
	$parent = basename( get_template_directory() );
	if ( 'genesis' !== $parent ) {
		return;
	}
	add_filter( 'archive_template', 'simple_staff_load_archive_template' );
	add_filter( 'single_template', 'simple_staff_load_single_template' );
}

function simple_staff_load_archive_template( $archive_template ) {
	if ( ( is_post_type_archive( 'staff' ) || is_tax( 'department' ) ) && locate_template( '' !== 'archive-staff.php' ) ) {
		$archive_template = plugin_dir_path( __FILE__ ) . '/views/archive-staff.php';
	}
	return $archive_template;
}

function simple_staff_load_single_template( $single_template ) {
	if ( is_singular( 'staff' ) && locate_template( '' !== 'single-staff.php' ) ) {
		$single_template = plugin_dir_path( __FILE__ ) . '/views/single-staff.php';
	}
	return $single_template;
}

add_action( 'widgets_init', 'simple_staff_register_widget' );
/**
 * Register sidebar to show after staff archive/single
 */
function simple_staff_register_widget() {
	register_sidebar( array(
		'id'            => 'after-staff',
		'name'          => __( 'After Staff', 'simple-staff' ),
		'description'   => __( 'This is a widget area which will show after the staff archive page or single staff entry content.', 'simple-staff' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	) );
}
