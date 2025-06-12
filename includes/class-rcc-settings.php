<?php

if (! defined('ABSPATH')) {
    exit;
}

class RCC_Settings extends WC_Settings_Page
{

    public function __construct()
    {
        $this->id    = 'rcc';
        $this->label = __('Checkout Restriction', 'restrict-checkout');

        parent::__construct();
    }

    public function get_settings()
    {
        return [
            [
                'title' => __('Restrict Checkout Access', 'restrict-checkout'),
                'type'  => 'title',
                'desc'  => __('Control access to the WooCommerce checkout page.', 'restrict-checkout'),
                'id'    => 'rcc_section_title',
            ],
            [
                'title'   => __('Enable Plugin', 'restrict-checkout'),
                'desc'    => __('Enable checkout access restriction', 'restrict-checkout'),
                'id'      => 'rcc_enable',
                'type'    => 'checkbox',
                'default' => 'yes',
            ],
            [
                'title'   => __('Blocked Roles', 'restrict-checkout'),
                'desc'    => __('Users with these roles will be blocked from checkout.', 'restrict-checkout'),
                'id'      => 'rcc_blocked_roles',
                'type'    => 'multiselect',
                'class'   => 'wc-enhanced-select',
                'options' => $this->get_all_roles(),
                'default' => [],
            ],

            [
                'title'   => __('Blocked Usernames', 'restrict-checkout'),
                'desc'    => __('Comma-separated list of usernames to block from checkout.', 'restrict-checkout'),
                'id'      => 'rcc_blocked_usernames',
                'type'    => 'text',
                'default' => '',
                'css'     => 'min-width: 300px;',
            ],
            [
                'title'   => __('Block Guests', 'restrict-checkout'),
                'desc'    => __('Prevent guests from accessing checkout', 'restrict-checkout'),
                'id'      => 'rcc_block_guests',
                'type'    => 'checkbox',
                'default' => 'no',
            ],
            [
                'title'    => __('Block Message', 'restrict-checkout'),
                'desc'     => __('Shown when a user is blocked. Leave blank to use default.', 'restrict-checkout'),
                'desc_tip' => true,
                'id'       => 'rcc_block_message',
                'type'     => 'textarea',
                'default'  => __('You are not allowed to access the checkout page.', 'restrict-checkout'),
            ],

            [
                'type' => 'sectionend',
                'id'   => 'rcc_section_end',
            ],
        ];
    }

    public function get_all_roles()
    {
        global $wp_roles;
        return $wp_roles->get_names();
    }
}

return new RCC_Settings();
