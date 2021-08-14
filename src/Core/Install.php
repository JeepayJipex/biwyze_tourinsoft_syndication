<?php

namespace BiwyzeTourinsoft\Core;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Database\Tables;

class Install
{
    /**
     * Starts all activation hooks and plugin installs
     */
    public function start()
    {
        $this->createTables();
        add_action( 'plugins_loaded', [$this, 'checkDbUpdate']);
    }


    /**
     * Create plugin database tables
     */
    private function createTables()
    {

        $currentDbVersion = get_option(BiwyzeTourinsoftSyndication::PREFIX . 'db_version');
        if ($currentDbVersion !== BiwyzeTourinsoftSyndication::DB_VERSION) {

            $tables = Tables::getTables();
            global $wpdb;
            $wpdb->show_errors();

            foreach ($tables as $table) {
                $sql = $table;
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);
            }

            update_option(BiwyzeTourinsoftSyndication::PREFIX . 'db_version', BiwyzeTourinsoftSyndication::DB_VERSION);
        }
    }

    /**
     * Updates database if plugin is updated
     */
    private function checkDbUpdate()
    {
        $currentDbVersion = get_option(BiwyzeTourinsoftSyndication::PREFIX . 'db_version');
        if ($currentDbVersion !== BiwyzeTourinsoftSyndication::DB_VERSION) {
            $this->createTables();
        }
    }
}