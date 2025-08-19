<?php
namespace ELM;

defined('ABSPATH') || exit;

class Settings_Page {

    private $admin_view;

    public function __construct() {
        $this->admin_view = new \ELM\Admin_View();
    }

    public function init() {
        add_action('admin_menu', [$this, 'add_plugin_settings_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_notices', [$this, 'plugin_admin_notices']);
    }

    public function add_plugin_settings_page() {
        add_menu_page(
            __('Electric Lineman Settings', ELM_TEXT_DOMAIN),
            __('Lineman Settings', ELM_TEXT_DOMAIN),
            'manage_options',
            'electric-lineman-settings',
            [$this, 'render_settings_page'],
            'dashicons-admin-generic',
            27
        );

        add_submenu_page(
            'electric-lineman-settings',
            __('All Bookings', ELM_TEXT_DOMAIN),
            __('Bookings', ELM_TEXT_DOMAIN),
            'manage_options',
            'elm-bookings',
            [$this->admin_view, 'render_bookings_page']
        );
    }

    public function render_settings_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Electric Lineman Settings', ELM_TEXT_DOMAIN) . '</h1>';
        echo '<div id="electric-lineman-admin-root"></div>'; // React mounts here
        echo '</div>';
    }

    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_electric-lineman-settings') {
            return;
        }

        $build_url  = ELM_URL . 'build/';
        $build_path = ELM_PATH . 'build/';

        // style
        if (file_exists($build_path . 'style.css')) {
            wp_enqueue_style(
                'elm-admin-style',
                $build_url . 'style.css',
                [],
                filemtime($build_path . 'style.css')
            );
        }

        // script (depends on WordPress' React + api-fetch)
        if (file_exists($build_path . 'index.js')) {
            wp_enqueue_script(
                'elm-admin-script',
                $build_url . 'index.js',
                ['wp-element', 'wp-components', 'wp-api-fetch'],
                filemtime($build_path . 'index.js'),
                true
            );

            wp_localize_script('elm-admin-script', 'elmSettings', [
                'apiUrl' => esc_url_raw(rest_url('elm/v1/')),
                'nonce'  => wp_create_nonce('wp_rest'),
            ]);
        }
    }

    public function plugin_admin_notices() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'electric-lineman-settings') {
            return;
        }
        echo '<div class="notice notice-warning"><p><strong>' .
            esc_html__('Warning:', ELM_TEXT_DOMAIN) .
            '</strong> ' .
            esc_html__('If you delete the Electric Lineman plugin, all booking data will be permanently removed.', ELM_TEXT_DOMAIN) .
            '</p></div>';
    }
}
