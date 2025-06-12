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
class RCC_Restrictor {

    /**
     * Constructor
     * Hooks into 'template_redirect' early to intercept access before rendering the checkout page.
     */
    public function __construct() {
        // Priority 0 ensures it runs as early as possible
        add_action( 'template_redirect', [ $this, 'maybe_block_checkout_access' ], 0 );
    }

    /**
     * Blocks checkout access based on settings.
     */
    public function maybe_block_checkout_access() {
        // Only apply logic on the main checkout page (not endpoints like order-received)
        if ( is_checkout() && ! is_wc_endpoint_url() ) {

            // Check if the plugin is enabled
            $enabled = get_option( 'rcc_enable', 'yes' );
            if ( $enabled !== 'yes' ) {
                return;
            }

            // Fetch plugin settings
            $blocked_roles     = (array) get_option( 'rcc_blocked_roles', [] );
            $blocked_usernames = array_map( 'trim', explode( ',', get_option( 'rcc_blocked_usernames', '' ) ) );
            $block_guests      = get_option( 'rcc_block_guests', 'no' );
            $block_message     = get_option(
                'rcc_block_message',
                __( 'You are not allowed to access the checkout page.', 'restrict-checkout-access' )
            );

            $should_block = false;

            // Check current user
            if ( is_user_logged_in() ) {
                $user       = wp_get_current_user();
                $username   = $user->user_login;
                $user_roles = (array) $user->roles;

                // Match blocked roles or usernames
                if ( array_intersect( $user_roles, $blocked_roles ) || in_array( $username, $blocked_usernames, true ) ) {
                    $should_block = true;
                }
            } elseif ( $block_guests === 'yes' ) {
                $should_block = true;
            }

            if ( $should_block ) {
                // Show block message
                wc_add_notice( $block_message, 'error' );

                // Redirect back or to homepage
                $referer = wp_get_referer();
                wp_safe_redirect( $referer ? $referer : home_url() );
                exit;
            }
        }
    }
}
