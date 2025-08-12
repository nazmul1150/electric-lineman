<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Electric_Lineman
 */

defined('WP_UNINSTALL_PLUGIN') || exit;

// Delete plugin options
delete_option('elm_default_message');
delete_option('elm_notification_email');

// Delete all elm_booking posts
$bookings = get_posts([
    'post_type'      => 'elm_booking',
    'post_status'    => 'any',
    'numberposts'    => -1,
    'fields'         => 'ids',
]);

if (!empty($bookings)) {
    foreach ($bookings as $booking_id) {
        wp_delete_post($booking_id, true);
    }
}


global $wpdb;

// Table name
$table_name = $wpdb->prefix . 'elm_bookings';

// Drop custom table
$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

// Delete plugin options
delete_option('elm_plugin_settings');

// If multisite, delete network options
if (is_multisite()) {
    delete_site_option('elm_plugin_settings');
}