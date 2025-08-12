<?php
namespace ELM;

defined( 'ABSPATH' ) || exit;

class DB_Handler {

    public function activate() {
        global $wpdb;

        $table_name      = $wpdb->prefix . 'elm_bookings';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(100) NOT NULL,
            phone varchar(50) NOT NULL,
            service varchar(100) NOT NULL,
            booking_date datetime NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) {$charset_collate};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }
}
