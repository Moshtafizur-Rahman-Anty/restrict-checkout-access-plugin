<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Class RCC_Restrictor
 *
 * Handles checkout access restriction logic based on roles, usernames, or guest status.
 */
class RCC_Restrictor
{
    /**
     * Constructor
     * Hook into 'template_redirect' early to intercept access before rendering the page.
     */
    public function __construct()
    {
        // Priority 0 ensures it runs as early as possible during page rendering
        add_action('template_redirect', [$this, 'maybe_block_checkout_access'], 0);
    }

    /**
     * Main logic to determine whether the user should be blocked from the checkout page.
     */
    public function maybe_block_checkout_access()
    {
        // Only act on the main checkout page, not endpoints like /order-received
        if (is_checkout() && ! is_wc_endpoint_url()) {
            // Check if the plugin is enabled
            $enabled = get_option('rcc_enable', 'yes');
            if ($enabled !== 'yes') {
                return;
            }

            // Get configured restriction options
            $blocked_roles     = (array) get_option('rcc_blocked_roles', []);
            $blocked_usernames = array_map('trim', explode(',', get_option('rcc_blocked_usernames', '')));
            $block_guests      = get_option('rcc_block_guests', 'no');
            $block_message     = get_option(
                'rcc_block_message',
                __('You are not allowed to access the checkout page.', 'restrict-checkout')
            );

            $should_block = false;

            if (is_user_logged_in()) {
                // Logged-in user — check role or username
                $user       = wp_get_current_user();
                $username   = $user->user_login;
                $user_roles = (array) $user->roles;

                // Block if user role or username matches the blocked list
                if (array_intersect($user_roles, $blocked_roles) || in_array($username, $blocked_usernames)) {
                    $should_block = true;
                }
            } elseif ($block_guests === 'yes') {
                // Guest user — block if guest restriction is enabled
                $should_block = true;
            }

            if ($should_block) {
                // Show error message using WooCommerce's native notice system
                wc_add_notice($block_message, 'error');

                // Redirect back to referring page or fallback to homepage
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
