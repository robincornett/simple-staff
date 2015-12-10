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

function simplestaff_require() {
	$files = array(
		'class-simplestaff',
		'class-simplestaff-posttype',
	);

	foreach ( $files as $file ) {
		require plugin_dir_path( __FILE__ ) . 'includes/' . $file . '.php';
	}
}
simplestaff_require();

// Instantiate dependent classes
$simplestaff_posttype = new SimpleStaff_PostType();

$simplestaff = new SimpleStaff(
	$simplestaff_posttype
);

$simplestaff->run();
