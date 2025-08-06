<?php
/**
 * Plugin Name: Electric Lineman
 * Description:  * Description: Book trusted electric linemen with ease. A professional electric service booking solution for modern businesses.
 * Version: 1.0.0
 * Author: Nazmul
 * License: GPLv2 or later
 * Text Domain: electric-lineman-booking
 */


if ( !defined( 'ABSPATH' ) ) exit;

define( 'ELM_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELM_URL', plugin_dir_url( __FILE__ ) );

// Autoloader for OOP structure
spl_autoload_register( function($class){
    if(strpos($class, 'ELM\\') !== false ){
        $class_path = str_replace( 'ELM\\', '', $class );
        $class_path = str_replace( '\\', DIRECTORY_SEPARATOR, $class_path );
        $file = ELM_PATH . 'includes/' . strtolower($class_path) . '.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }
} );

// Plugin Init
add_action('plugins_loaded', function() {
    $plugin = new ELM\Main();
    $plugin->run();
});