<?php

if (! defined('ABSPATH')) {
    exit;
}

class RCC_Init
{
    public function __construct()
    {
        $this->includes();
    }

    public function includes()
    {
        require_once plugin_dir_path(__FILE__) . 'class-rcc-restrictor.php';
        new RCC_Restrictor();

        // ✅ Register settings tab using correct hook
        add_filter('woocommerce_get_settings_pages', function ($settings) {
            $settings[] = include plugin_dir_path(__FILE__) . 'class-rcc-settings.php';
            return $settings;
        });
    }
}
