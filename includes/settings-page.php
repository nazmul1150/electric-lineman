<?php
namespace ELM;

defined('ABSPATH') || exit;

class Settings_Page {

    public function init() {
        add_action('admin_menu', [$this, 'add_plugin_settings_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function add_plugin_settings_page() {
        add_menu_page(
            __('Electric Lineman Settings', 'electric-lineman'),
            __('Lineman Settings', 'electric-lineman'),
            'manage_options',
            'electric-lineman-settings',
            [$this, 'render_settings_page'],
            'dashicons-admin-generic',
            27
        );
    }

    public function render_settings_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Electric Lineman Settings', 'electric-lineman') . '</h1>';
        echo '<div id="electric-lineman-admin-root"></div>'; // React will hook here
        echo '</div>';
    }

    public function enqueue_admin_assets($hook_suffix) {
        // Load only on our plugin's settings page
        if ($hook_suffix !== 'toplevel_page_electric-lineman-settings') {
            return;
        }

        $build_url = ELM_URL . 'build/';
        // $asset_version = filemtime(ELM_PATH . 'build/static/js/main.js'); // Ensure cache busting
        $asset_version = '1.0.0'; // For simplicity, use a static version

        // Enqueue CSS
        wp_enqueue_style(
            'elm-admin-style',
            $build_url . 'static/css/main.css',
            [],
            $asset_version
        );

        // Enqueue JS
        wp_enqueue_script(
            'elm-admin-script',
            $build_url . 'static/js/main.js',
            [],
            $asset_version,
            true
        );

        // Optional: Pass data to React if needed
        wp_localize_script('elm-admin-script', 'elmSettings', [
            'apiUrl' => esc_url_raw(rest_url('electric/v1/')),
            'nonce'  => wp_create_nonce('wp_rest'),
        ]);
    }
}
