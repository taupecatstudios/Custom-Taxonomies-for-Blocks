<?php
/**
 * Plugin Name: Custom Taxonomies for Blocks
 * Plugin URI: https://taupecatstudios.com/wordpress-plugins/custom-taxonomies-for-blocks/
 * Description: Enables older custom taxonomies to be used with the WordPress block editor interface (a.k.a. Gutenberg).
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 5.6
 * Author: Tracy Rotton, Taupecat Studios
 * Author URI: https://taupecatstudios.com
 * License: MIT
 * Text Domain: ctfb
 *
 * @package Custom Taxonomies for Blocks
 *
 * @todo Add an administration interface to allow site administrators to choose custom taxonomies they want to enable in the block editor interface.
 */

namespace Custom_Taxonomies_for_Blocks;

/**
 * Set the "show_in_rest" property for custom taxonomies to true.
 *
 * @return boolean True if custom taxonomies were converted;
 *                 False if the conditions were not met to convert custom taxonomies.
 */
function custom_taxonomies_for_blocks() {

	// In order for this plugin to run, one of the following scenarios must be true:
	// * WordPress version must be equal to or greater than 5.0.0 _and_ the Classic Editor plugin must not be active; OR
	// * the Gutenberg plugin must be installed and activated.
	//
	// Assume that we will _not_ be running this plugin, then test for these two conditions
	// to override that assumption.
	$convert_taxonomies = false;

	// Grab the information we'll need to test for our two activation conditions.
	global $wp_version;
	$version5       = ( -1 < version_compare( $wp_version, '5.0.0' ) );
	$classic_editor = class_exists( 'Classic_Editor' );
	$gutenberg      = defined( 'GUTENBERG_VERSION' );

	// WordPress version + Classic Editor test.
	if ( ( $version5 && ! $classic_editor ) || $gutenberg ) {

		$convert_taxonomies = true;
	}

	if ( ! $convert_taxonomies ) {

		return $convert_taxonomies;
	}

	/** If we haven't met either of the above conditions, we can continue on... */

	// Get the global $wp_taxonomies variable.
	global $wp_taxonomies;

	// Create an array of the "default" WordPress taxonomies (as of WordPress 5.3-RC2).
	// These are the taxonomies created in wp-includes/taxonomy.php.
	$default_taxonomies = array( 'category', 'post_tag', 'nav_menu', 'link_category', 'post_format' );

	// Loop through all of the registered taxonomies. If a taxonomy is *not* a default taxonomy,
	// convert to "show_in_rest = true" if that property is currently false.
	foreach ( $wp_taxonomies as $slug => $object ) {

		if ( ! in_array( $slug, $default_taxonomies, true ) ) {

			// Check to make sure all *three* REST-related properties are false.
			// If "show_in_rest" is false, but "rest_base" or "rest_controller_class"
			// have non-false values, something is going on and we're better not to
			// mess with things.
			if ( false === $object->show_in_rest ) {

				if ( ( false === $object->rest_base ) && ( false === $object->rest_controller_class ) ) {

					$wp_taxonomies[ $slug ]->show_in_rest = true;
				}
			}
		}
	}

	return $convert_taxonomies;
}

// Run action at "init" action hook, setting the priority value to a high integer
// to overcome as many instances of custom taxonomy registration as possible.
add_action( 'init', __NAMESPACE__ . '\\custom_taxonomies_for_blocks', 999 );
