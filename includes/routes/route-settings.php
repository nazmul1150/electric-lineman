<?php
namespace ELM\Routes;

defined('ABSPATH') || exit;

class Route_Settings {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('elm/v1', '/settings', [
            [
                'methods'  => 'GET',
                'callback' => [$this, 'get_settings'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ],
            [
                'methods'  => 'POST',
                'callback' => [$this, 'update_settings'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                },
            ],
        ]);
    }

    public function get_settings() {
        return [
            'company_name'  => get_option('elm_company_name', ''),
            'company_phone' => get_option('elm_company_phone', ''),
        ];
    }

    public function update_settings(\WP_REST_Request $request) {
        $data = $request->get_json_params();

        if (isset($data['company_name'])) {
            update_option('elm_company_name', sanitize_text_field($data['company_name']));
        }
        if (isset($data['company_phone'])) {
            update_option('elm_company_phone', sanitize_text_field($data['company_phone']));
        }

        return [
            'success' => true,
            'message' => __('Settings saved successfully!', 'electric-lineman'),
        ];
    }
}
