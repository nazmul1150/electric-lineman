<?php
namespace ELM\Routes;

defined('ABSPATH') || exit;

class Route_Settings {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('electric/v1', '/settings', [
            [
                'methods'             => 'GET',
                'callback'            => [$this, 'get_settings'],
                'permission_callback' => [$this, 'permissions_check'],
            ],
            [
                'methods'             => 'POST',
                'callback'            => [$this, 'update_settings'],
                'permission_callback' => [$this, 'permissions_check'],
            ]
        ]);
    }

    public function permissions_check($request) {
        return current_user_can('manage_options');
    }

    public function get_settings($request) {
        $settings = [
            'default_message' => get_option('elm_default_message', ''),
            'notification_email' => get_option('elm_notification_email', get_option('admin_email')),
        ];

        return rest_ensure_response([
            'status' => 'success',
            'data'   => $settings,
        ]);
    }

    public function update_settings($request) {
        $params = $request->get_json_params();

        if (isset($params['default_message'])) {
            update_option('elm_default_message', sanitize_text_field($params['default_message']));
        }

        if (isset($params['notification_email'])) {
            update_option('elm_notification_email', sanitize_email($params['notification_email']));
        }

        return rest_ensure_response([
            'status'  => 'success',
            'message' => __('Settings updated.', 'electric-lineman'),
        ]);
    }
}
