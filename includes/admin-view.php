<?php
namespace ELM;

defined('ABSPATH') || exit;

class Admin_View {

    public function init() {
        // এই ক্লাস Settings_Page থেকেই submenu দিয়ে ব্যবহার হচ্ছে
    }

    public function render_bookings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wpdb;
        $table = $wpdb->prefix . 'elm_bookings';
        // simple safe read (no user input)
        $rows = $wpdb->get_results("SELECT * FROM {$table} ORDER BY created_at DESC");
        ?>
        <div class="wrap">
            <h1><?php echo esc_html__('All Bookings', ELM_TEXT_DOMAIN); ?></h1>

            <table class="widefat fixed striped">
                <thead>
                <tr>
                    <th><?php esc_html_e('ID', ELM_TEXT_DOMAIN); ?></th>
                    <th><?php esc_html_e('Name', ELM_TEXT_DOMAIN); ?></th>
                    <th><?php esc_html_e('Phone', ELM_TEXT_DOMAIN); ?></th>
                    <th><?php esc_html_e('Service', ELM_TEXT_DOMAIN); ?></th>
                    <th><?php esc_html_e('Booking Date', ELM_TEXT_DOMAIN); ?></th>
                    <th><?php esc_html_e('Created At', ELM_TEXT_DOMAIN); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($rows)) : ?>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?php echo esc_html($r->id); ?></td>
                            <td><?php echo esc_html($r->name); ?></td>
                            <td><?php echo esc_html($r->phone); ?></td>
                            <td><?php echo esc_html($r->service); ?></td>
                            <td><?php echo esc_html($r->booking_date); ?></td>
                            <td><?php echo esc_html($r->created_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="6"><?php esc_html_e('No bookings found.', ELM_TEXT_DOMAIN); ?></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}
