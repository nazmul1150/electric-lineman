<?php
namespace ELM;

defined('ABSPATH') || exit;

class Form_Handler {

    public function init() {
        // Handle form submission for both logged-in and guest users
        add_action('admin_post_nopriv_elm_submit_booking', [$this, 'handle_form']);
        add_action('admin_post_elm_submit_booking', [$this, 'handle_form']);
    }

    public function handle_form() {
        // Validate nonce
        if ( ! isset($_POST['_wpnonce']) || ! wp_verify_nonce($_POST['_wpnonce'], 'elm_booking_form') ) {
            wp_die(__('Invalid nonce.', 'electric-lineman'));
        }

        // Sanitize form inputs
        $name    = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email   = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone   = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

        // Example: Save to custom table or post type
        $post_id = wp_insert_post([
            'post_type'   => 'elm_booking',
            'post_title'  => $name,
            'post_status' => 'publish',
            'meta_input'  => [
                'email'   => $email,
                'phone'   => $phone,
                'message' => $message,
            ]
        ]);

        // Redirect after submission
        wp_redirect(home_url('/thank-you'));
        exit;
    }
}
