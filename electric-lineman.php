<?php
/**
 * Plugin Name: Electric Lineman
 * Description: Book trusted electric linemen with ease. A professional electric service booking solution for modern businesses.
 * Version: 1.0.0
 * Author: Nazmul
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: electric-lineman
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin paths
define( 'ELM_PATH', plugin_dir_path( __FILE__ ) );
define( 'ELM_URL', plugin_dir_url( __FILE__ ) );

// Get text domain dynamically
if ( ! defined( 'ELM_TEXT_DOMAIN' ) ) {
    $plugin_data = get_file_data( __FILE__, [ 'TextDomain' => 'Text Domain' ], 'plugin' );
    define( 'ELM_TEXT_DOMAIN', $plugin_data['TextDomain'] ?: 'electric-lineman' );
}

// Load translations
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( ELM_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
});

// Simple PSR-4 style autoloader
spl_autoload_register( function( $class ) {
    if ( strpos( $class, 'ELM\\' ) === 0 ) {
        $class_path = str_replace( 'ELM\\', '', $class );
        $class_path = str_replace( '\\', DIRECTORY_SEPARATOR, $class_path );
        $file       = ELM_PATH . 'includes/' . strtolower( $class_path ) . '.php';
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
});

// Activation hook
register_activation_hook( __FILE__, function() {
    require_once ELM_PATH . 'includes/db-handler.php';
    if ( class_exists( 'ELM\\DB_Handler' ) ) {
        ( new ELM\DB_Handler() )->activate();
    }
});

// Deactivation hook
register_deactivation_hook(__FILE__, function() {
    // Example: remove cron jobs or cleanup cache
    wp_clear_scheduled_hook('elm_some_cron_job');

    // You can also deactivate background processes here
});


// Init plugin
add_action( 'plugins_loaded', function() {
    if ( class_exists( 'ELM\\Main' ) ) {
        ( new ELM\Main() )->run();
    } else {
        require_once ELM_PATH . 'includes/main.php';
        if ( class_exists( 'ELM\\Main' ) ) {
            ( new ELM\Main() )->run();
        }
    }
});
