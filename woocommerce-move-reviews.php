<?php
/**
 * Plugin Name: WooCommerce Move Reviews
 * Plugin URI: http://captaintheme.com/
 * Description: Allows you to easily move reviews from one product to another.
 * Version: 1.0.1
 * Author: Captain Theme
 * Author URI: http://captaintheme.com/
 * License: GPL2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Check if WooCommerce is active
 **/

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	// Brace Yourself
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-wcmr.php' );

	// Start the Engine
	add_action( 'plugins_loaded', array( 'WCMR', 'get_instance' ) );

}
