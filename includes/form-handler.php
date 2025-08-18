<?php
namespace ELM;

defined('ABSPATH') || exit;

class Form_Handler {

    public function init() {
        // ✅ Shortcode add
        add_shortcode('elm_booking_form', [$this, 'render_form']);

        // ✅ Debug log
        error_log("✅ ELM Booking Form Shortcode Registered");
    }

    public function render_form() {
        ob_start();
        ?>
        <form method="post" class="elm-booking-form">
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
                <label for="elm_date"><?php esc_html_e('Booking Date', ELM_TEXT_DOMAIN); ?></label><br>
                <input type="date" name="elm_date" id="elm_date" required>
            </p>
            <p>
                <button type="submit"><?php esc_html_e('Book Now', ELM_TEXT_DOMAIN); ?></button>
            </p>
        </form>
        <?php
        return ob_get_clean();
    }
}
