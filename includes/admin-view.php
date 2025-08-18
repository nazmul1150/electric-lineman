<?php
namespace ELM;

defined('ABSPATH') || exit;

class Admin_View {

    public function init() {
        add_action('admin_menu', [$this, 'add_admin_page']);
    }

    public function add_admin_page() {
        // add_menu_page(
        //     __('All Bookings', ELM_TEXT_DOMAIN),   // Page title
        //     __('Bookings', ELM_TEXT_DOMAIN),       // Menu title
        //     'manage_options',                      // Capability
        //     'elm-bookings',                        // Menu slug
        //     [$this, 'render_bookings_page'],       // Callback
        //     'dashicons-list-view',                 // Icon
        //     26                                     // Position
        // );
    }

    public function render_bookings_page() {
        if ( ! current_user_can('manage_options') ) {
            return;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'elm_bookings';

        // Safe query with prepare
        $bookings = $wpdb->get_results( "SELECT * FROM {$table_name} ORDER BY created_at DESC" );

        ?>
        <div class="wrap">
            <h1><?php echo esc_html__( 'All Bookings', ELM_TEXT_DOMAIN ); ?></h1>

            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'ID', ELM_TEXT_DOMAIN ); ?></th>
                        <th><?php esc_html_e( 'Name', ELM_TEXT_DOMAIN ); ?></th>
                        <th><?php esc_html_e( 'Phone', ELM_TEXT_DOMAIN ); ?></th>
                        <th><?php esc_html_e( 'Service', ELM_TEXT_DOMAIN ); ?></th>
                        <th><?php esc_html_e( 'Booking Date', ELM_TEXT_DOMAIN ); ?></th>
                        <th><?php esc_html_e( 'Created At', ELM_TEXT_DOMAIN ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $bookings ) : ?>
                        <?php foreach ( $bookings as $booking ) : ?>
                            <tr>
                                <td><?php echo esc_html( $booking->id ); ?></td>
                                <td><?php echo esc_html( $booking->name ); ?></td>
                                <td><?php echo esc_html( $booking->phone ); ?></td>
                                <td><?php echo esc_html( $booking->service ); ?></td>
                                <td><?php echo esc_html( $booking->booking_date ); ?></td>
                                <td><?php echo esc_html( $booking->created_at ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6"><?php esc_html_e( 'No bookings found.', ELM_TEXT_DOMAIN ); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
