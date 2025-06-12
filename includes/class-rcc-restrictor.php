<?php

if (! defined('ABSPATH')) {
    exit;
}

class RCC_Restrictor
{

    public function __construct()
    {
        add_action('template_redirect', [$this, 'maybe_block_checkout_access'], 0); // earlier priority
    }

    public function maybe_block_checkout_access()
    {
        if (is_checkout() && ! is_wc_endpoint_url()) {
            $enabled = get_option('rcc_enable', 'yes');
            if ($enabled !== 'yes') {
                return;
            }

            $blocked_roles     = (array) get_option('rcc_blocked_roles', []);
            $blocked_usernames = array_map('trim', explode(',', get_option('rcc_blocked_usernames', '')));
            $block_guests      = get_option('rcc_block_guests', 'no');
            $block_message     = get_option('rcc_block_message', __('You are not allowed to access the checkout page.', 'restrict-checkout'));

            $should_block = false;

            if (is_user_logged_in()) {
                $user       = wp_get_current_user();
                $username   = $user->user_login;
                $user_roles = (array) $user->roles;

                if (array_intersect($user_roles, $blocked_roles) || in_array($username, $blocked_usernames)) {
                    $should_block = true;
                }
            } elseif ($block_guests === 'yes') {
                $should_block = true;
            }

            if ($should_block) {
                wc_add_notice($block_message, 'error');

                // Redirect back to the referring page or homepage
                $referer = wp_get_referer();
                if ($referer) {
                    wp_safe_redirect($referer);
                } else {
                    wp_safe_redirect(home_url());
                }
                exit;
            }
        }
    }

}
