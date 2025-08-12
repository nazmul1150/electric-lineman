<?php
namespace ELM;

defined('ABSPATH') || exit;

class Admin_View {

    public function init() {
        //add_action('admin_menu', [$this, 'add_admin_page']);
    }

    // public function add_admin_page() {
    //     add_menu_page(
    //         __('All Bookings', ELM_TEXT_DOMAIN),   // Page title
    //         __('Bookings', ELM_TEXT_DOMAIN),       // Menu title
    //         'manage_options',                         // Capability
    //         'elm-bookings',                           // Menu slug
    //         [$this, 'render_bookings_page'],          // Callback
    //         'dashicons-list-view',                    // Icon
    //         26                                        // Position
    //     );
    // }

    public function render_bookings_page() {
        $args = [
            'post_type'      => 'elm_booking',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        $bookings = get_posts($args);
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('All Bookings', ELM_TEXT_DOMAIN); ?></h1>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Name', ELM_TEXT_DOMAIN); ?></th>
                        <th><?php esc_html_e('Email', ELM_TEXT_DOMAIN); ?></th>
                        <th><?php esc_html_e('Phone', ELM_TEXT_DOMAIN); ?></th>
                        <th><?php esc_html_e('Message', ELM_TEXT_DOMAIN); ?></th>
                        <th><?php esc_html_e('Date', ELM_TEXT_DOMAIN); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ( $bookings ) : ?>
                        <?php foreach ( $bookings as $booking ) : ?>
                            <tr>
                                <td><?php echo esc_html( get_the_title( $booking->ID ) ); ?></td>
                                <td><?php echo esc_html( get_post_meta( $booking->ID, 'email', true ) ); ?></td>
                                <td><?php echo esc_html( get_post_meta( $booking->ID, 'phone', true ) ); ?></td>
                                <td><?php echo esc_html( get_post_meta( $booking->ID, 'message', true ) ); ?></td>
                                <td><?php echo esc_html( get_the_date( '', $booking->ID ) ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5"><?php esc_html_e('No bookings found.', ELM_TEXT_DOMAIN); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
