<?php
namespace ELM\Routes;

defined('ABSPATH') || exit;

class Route_Booking {

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes() {
        register_rest_route('electric/v1', '/bookings', [
            'methods'             => 'GET',
            'callback'            => [$this, 'get_bookings'],
            'permission_callback' => [$this, 'permissions_check'],
        ]);
    }

    public function permissions_check($request) {
        // For public access, use: return true;
        return current_user_can('manage_options');
    }

    public function get_bookings($request) {
        $args = [
            'post_type'      => 'elm_booking',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];

        $posts = get_posts($args);

        $data = array_map(function($post) {
            return [
                'id'      => $post->ID,
                'name'    => get_the_title($post),
                'email'   => get_post_meta($post->ID, 'email', true),
                'phone'   => get_post_meta($post->ID, 'phone', true),
                'message' => get_post_meta($post->ID, 'message', true),
                'date'    => get_the_date('', $post),
            ];
        }, $posts);

        return rest_ensure_response([
            'status' => 'success',
            'data'   => $data
        ]);
    }
}
