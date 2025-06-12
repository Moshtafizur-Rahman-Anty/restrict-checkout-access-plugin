<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Class RCC_Init
 *
 * Initializes the plugin by loading required files and registering settings.
 */
class RCC_Init
{
    /**
     * RCC_Init constructor.
     * Automatically called when the plugin is loaded.
     */
    public function __construct()
    {
        $this->includes();
    }

    /**
     * Load plugin components and register WooCommerce settings page.
     */
    public function includes()
    {
        // Load the class responsible for blocking checkout access
        require_once plugin_dir_path(__FILE__) . 'class-rcc-restrictor.php';
        new RCC_Restrictor();

        // Register the plugin's settings tab within WooCommerce settings
        add_filter('woocommerce_get_settings_pages', function ($settings) {
            // Include and initialize the settings class, which extends WC_Settings_Page
            $settings[] = include plugin_dir_path(__FILE__) . 'class-rcc-settings.php';
            return $settings;
        });
    }
}
