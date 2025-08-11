<?php
namespace ELM;

defined('ABSPATH') || exit;

class Admin_View {

    public function init() {
        //add_action('admin_menu', [$this, 'add_admin_page']);
    }

    // public function add_admin_page() {
    //     add_menu_page(
    //         __('All Bookings', 'electric-lineman'),   // Page title
    //         __('Bookings', 'electric-lineman'),       // Menu title
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
            <h1><?php esc_html_e('All Bookings', 'electric-lineman'); ?></h1>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Name', 'electric-lineman'); ?></th>
                        <th><?php esc_html_e('Email', 'electric-lineman'); ?></th>
                        <th><?php esc_html_e('Phone', 'electric-lineman'); ?></th>
                        <th><?php esc_html_e('Message', 'electric-lineman'); ?></th>
                        <th><?php esc_html_e('Date', 'electric-lineman'); ?></th>
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
                            <td colspan="5"><?php esc_html_e('No bookings found.', 'electric-lineman'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
