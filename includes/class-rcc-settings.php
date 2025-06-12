<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Class RCC_Settings
 *
 * Adds a custom settings tab to WooCommerce for restricting checkout access.
 */
class RCC_Settings extends WC_Settings_Page
{
    /**
     * RCC_Settings constructor.
     *
     * Sets tab ID and label, then calls the WooCommerce settings page parent constructor.
     */
    public function __construct()
    {
        $this->id    = 'rcc';
        $this->label = __('Checkout Restriction', 'restrict-checkout');

        parent::__construct();
    }

    /**
     * Defines all settings fields for this plugin.
     *
     * These fields are shown under WooCommerce → Settings → Checkout Restriction.
     *
     * @return array List of settings fields.
     */
    public function get_settings()
    {
        return [
            // Section title
            [
                'title' => __('Restrict Checkout Access', 'restrict-checkout'),
                'type'  => 'title',
                'desc'  => __('Control access to the WooCommerce checkout page.', 'restrict-checkout'),
                'id'    => 'rcc_section_title',
            ],

            // Enable/disable plugin
            [
                'title'   => __('Enable Plugin', 'restrict-checkout'),
                'desc'    => __('Enable checkout access restriction', 'restrict-checkout'),
                'id'      => 'rcc_enable',
                'type'    => 'checkbox',
                'default' => 'yes',
            ],

            // Blocked user roles
            [
                'title'   => __('Blocked Roles', 'restrict-checkout'),
                'desc'    => __('Users with these roles will be blocked from checkout.', 'restrict-checkout'),
                'id'      => 'rcc_blocked_roles',
                'type'    => 'multiselect',
                'class'   => 'wc-enhanced-select',
                'options' => $this->get_all_roles(),
                'default' => [],
            ],

            // Blocked usernames (manual entry)
            [
                'title'   => __('Blocked Usernames', 'restrict-checkout'),
                'desc'    => __('Comma-separated list of usernames to block from checkout.', 'restrict-checkout'),
                'id'      => 'rcc_blocked_usernames',
                'type'    => 'text',
                'default' => '',
                'css'     => 'min-width: 300px;',
            ],

            // Block guests
            [
                'title'   => __('Block Guests', 'restrict-checkout'),
                'desc'    => __('Prevent guests from accessing checkout', 'restrict-checkout'),
                'id'      => 'rcc_block_guests',
                'type'    => 'checkbox',
                'default' => 'no',
            ],

            // Custom block message
            [
                'title'    => __('Block Message', 'restrict-checkout'),
                'desc'     => __('Shown when a user is blocked. Leave blank to use default.', 'restrict-checkout'),
                'desc_tip' => true,
                'id'       => 'rcc_block_message',
                'type'     => 'textarea',
                'default'  => __('You are not allowed to access the checkout page.', 'restrict-checkout'),
            ],

            // End section
            [
                'type' => 'sectionend',
                'id'   => 'rcc_section_end',
            ],
        ];
    }

    /**
     * Get all available WordPress user roles.
     *
     * @return array Associative array of role key => role name.
     */
    public function get_all_roles()
    {
        global $wp_roles;
        return $wp_roles->get_names();
    }
}

// Return instance so WooCommerce settings can register it immediately.
return new RCC_Settings();
