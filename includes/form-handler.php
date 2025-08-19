<?php
namespace ELM;

defined('ABSPATH') || exit;

class Form_Handler {
    public function init() {
        add_shortcode('elm_booking_form', [$this, 'render_form']);
        add_action('init', [$this, 'handle_form_submission']);
    }

    public function render_form() {
        ob_start();

        if (isset($_GET['elm_success'])) {
            echo '<div class="notice notice-success" style="padding:10px;">' .
                esc_html__('Booking submitted successfully!', ELM_TEXT_DOMAIN) .
            '</div>';
        }
        ?>
        <form method="post" action="">
            <?php wp_nonce_field('elm_booking_form_action', 'elm_booking_form_nonce'); ?>

            <p>
                <label for="elm_name"><?php esc_html_e('Name', ELM_TEXT_DOMAIN); ?></label><br>
                <input type="text" name="elm_name" id="elm_name" required>
            </p>

            <p>
                <label for="elm_phone"><?php esc_html_e('Phone', ELM_TEXT_DOMAIN); ?></label><br>
                <input type="text" name="elm_phone" id="elm_phone" required>
            </p>

            <p>
                <label for="elm_service"><?php esc_html_e('Service', ELM_TEXT_DOMAIN); ?></label><br>
                <input type="text" name="elm_service" id="elm_service" required>
            </p>

            <p>
                <label for="elm_booking_date"><?php esc_html_e('Booking Date', ELM_TEXT_DOMAIN); ?></label><br>
                <input type="date" name="elm_booking_date" id="elm_booking_date" required>
            </p>

            <p>
                <button type="submit" name="elm_submit_booking">
                    <?php esc_html_e('Submit Booking', ELM_TEXT_DOMAIN); ?>
                </button>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }

    public function handle_form_submission() {
        if (!isset($_POST['elm_submit_booking'])) {
            return;
        }

        if (!isset($_POST['elm_booking_form_nonce']) ||
            !wp_verify_nonce($_POST['elm_booking_form_nonce'], 'elm_booking_form_action')) {
            return;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'elm_bookings';

        // normalize date -> DATETIME
        $booking_date = sanitize_text_field($_POST['elm_booking_date']);
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $booking_date)) {
            $booking_date .= ' 00:00:00';
        }

        $inserted = $wpdb->insert(
            $table_name,
            [
                'name'         => sanitize_text_field($_POST['elm_name']),
                'phone'        => sanitize_text_field($_POST['elm_phone']),
                'service'      => sanitize_text_field($_POST['elm_service']),
                'booking_date' => $booking_date,
            ],
            ['%s', '%s', '%s', '%s']
        );

        if ($inserted === false) {
            error_log('ELM insert failed: ' . $wpdb->last_error);
        }

        wp_safe_redirect(add_query_arg('elm_success', '1', wp_get_referer()));
        exit;
    }
}
