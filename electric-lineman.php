<?php
/**
 * Plugin Name: Electric Lineman
 * Description:  * Description: Book trusted electric linemen with ease. A professional electric service booking solution for modern businesses.
 * Version: 1.0.0
 * Author: Nazmul
 * License: GPLv2 or later
 * Text Domain: electric-lineman-booking
 */

defined('ABSPATH') || exit;
 
define('ELM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ELM_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once ELM_PLUGIN_PATH . 'includes/class-electric-lineman.php';

function run_electric_lineman() {
    $plugin = new Electric_Lineman\Main();
    $plugin->run();
}
run_electric_lineman();
