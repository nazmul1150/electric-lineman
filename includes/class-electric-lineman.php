<?php

namespace Electric_Lineman;

defined('ABSPATH') || exit;

class Main {

    public function __construct() {
        $this->load_dependencies();
    }

    public function load_dependencies() {
        require_once ELM_PLUGIN_PATH . 'includes/admin-view.php';
        require_once ELM_PLUGIN_PATH . 'includes/form-handler.php';
        require_once ELM_PLUGIN_PATH . 'includes/csettings-page.php';
        require_once ELM_PLUGIN_PATH . 'includes/helpers.php';

        // Load custom REST API routes
        require_once ELM_PLUGIN_PATH . 'includes/routes/route-booking.php';
        require_once ELM_PLUGIN_PATH . 'includes/routes/route-settings.php';
    }

    public function run() {
        (new Admin_View())->init();
        (new Form_Handler())->init();
        (new Settings_Page())->init();

        new \Electric_Lineman\Routes\Booking_Route();
        new \Electric_Lineman\Routes\Settings_Route();
    }
}
