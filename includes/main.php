<?php
namespace ELM;

defined('ABSPATH') || exit;

class Main {

    public function run() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function load_dependencies() {
        require_once ELM_PATH . 'includes/form-handler.php';
        require_once ELM_PATH . 'includes/admin-view.php';
        require_once ELM_PATH . 'includes/settings-page.php';
        require_once ELM_PATH . 'includes/helpers.php';
        require_once ELM_PATH . 'includes/db-handler.php';

        require_once ELM_PATH . 'includes/routes/route-booking.php';
        require_once ELM_PATH . 'includes/routes/route-settings.php';
    }

    private function init_hooks() {
        (new \ELM\Form_Handler())->init();
        (new \ELM\Admin_View())->init();
        (new \ELM\Settings_Page())->init();
        //new \ELM\Routes\DB_Handler();

        new \ELM\Routes\Route_Booking();
        new \ELM\Routes\Route_Settings();

        // register_activation_hook(
        //     __FILE__,
        //     function() {
        //         (new \ELM\Routes\DB_Handler())->activate();
        //     }
        // );
    }
}
 