<?php
namespace ELM;

defined('ABSPATH') || exit;

class Settings_Page {

    private $admin_view;

    public function __construct() {
        $this->admin_view = new \ELM\Admin_View();
    }

    public function init() {
        add_action('admin_notices', [$this, 'plugin_admin_notices']);
        add_action('admin_menu', [$this, 'add_plugin_settings_page']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
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
        //submenu
        add_submenu_page(
            'electric-lineman-settings',
            __( 'All Bookings', ELM_TEXT_DOMAIN ),
            __( 'Bookings', ELM_TEXT_DOMAIN ),
            'manage_options',
            'elm-bookings',
            [$this->admin_view, 'render_bookings_page'],
            'dashicons-list-view',
            26
        );
    }

    public function render_settings_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Electric Lineman Settings', ELM_TEXT_DOMAIN) . '</h1>';
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

    public function plugin_admin_notices() {
        if (isset($_GET['page']) && $_GET['page'] === 'electric-lineman-settings') {
            echo '<div class="notice notice-warning">
                    <p><strong>' . esc_html__('Warning:', ELM_TEXT_DOMAIN) . '</strong> 
                    ' . esc_html__('If you delete the Electric Lineman plugin, all booking data will be permanently removed.', ELM_TEXT_DOMAIN) . '</p>
                </div>';
        }
    }
}
