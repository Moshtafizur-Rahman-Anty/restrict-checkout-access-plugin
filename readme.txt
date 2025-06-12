=== Restrict Checkout Access ===

Contributors: moshtafizur01
Tags: woocommerce, checkout restriction, user role, guest block, block checkout, restrict checkout
Requires at least: 5.6
Tested up to: 6.5
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Restrict access to the WooCommerce checkout page based on user roles, specific usernames, or guest status. Useful for B2B stores, approval-only stores, or controlled environments.

== Description ==

**Restrict Checkout Access** gives WooCommerce store owners full control over who can access the checkout page.

You can block checkout access for:

- Specific user roles (like `Subscriber`, `Customer`, etc.)
- Specific usernames (comma-separated list)
- Guests (users who are not logged in)

When blocked users try to visit the checkout page, they will be shown a customizable message and redirected to the page they came from — no blank error screen or crashes.

== Features ==

- Restrict checkout access by WordPress user roles
- Block checkout for specific usernames
- Prevent guests (non-logged-in users) from checking out
- Customize the message shown when access is denied
- Integrates natively with WooCommerce settings panel
- Clean, lightweight, and easy to use

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the **Plugins** menu in WordPress
3. Go to **WooCommerce → Settings → Checkout Restriction** to configure


== Frequently Asked Questions ==

= Where are the settings? =

Go to **WooCommerce → Settings → Checkout Restriction** tab.

= What happens when a blocked user tries to access checkout? =

They are redirected back to the page they came from, and an error message is shown using WooCommerce's built-in notice system.

= Can I block only guests? =

Yes. Enable the "Block Guests" checkbox and leave other settings empty if you only want to restrict checkout for non-logged-in users.

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
First version of the plugin. Add user role and guest-based restrictions for checkout access.
