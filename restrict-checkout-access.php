<?php

/**
 * Plugin Name: Restrict Checkout Access
 * Description: Restricts access to the WooCommerce checkout page based on user role, username, or guest status. Helps store owners control who can place orders based on defined access rules.
 * Version: 1.0.0
 * Author: Moshtafizur
 * Author URI: https://profiles.wordpress.org/moshtafizur01/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: restrict-checkout-access
 * Domain Path: /languages
 * Requires at least: 5.6
 * Tested up to: 6.8
 * Requires PHP: 7.2
 * WC requires at least: 5.0
 * WC tested up to: 8.9
 * WC HPOS Compatible: yes
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



// ✅ Declare HPOS compatibility properly
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
}, 10 );

// Plugin loader...
add_action( 'plugins_loaded', 'rcc_run_plugin', 20 );

/**
 * Initialize plugin functionality after all plugins (including WooCommerce) are loaded.
 * Priority 20 ensures WooCommerce has been initialized.
 */
add_action( 'plugins_loaded', 'rcc_run_plugin', 20 );

/**
 * Main plugin initializer.
 * Checks for WooCommerce before loading plugin classes.
 */
function rcc_run_plugin() {

    // Proceed only if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        // Load the plugin's core initialization class
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-rcc-init.php';
        new RCC_Init();

    } else {
        // Show admin notice if WooCommerce is not active
        add_action( 'admin_notices', function () {
            echo '<div class="notice notice-error"><p><strong>Restrict Checkout Access:</strong> WooCommerce must be installed and active.</p></div>';
        } );
    }

    load_plugin_textdomain( 'restrict-checkout', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}
