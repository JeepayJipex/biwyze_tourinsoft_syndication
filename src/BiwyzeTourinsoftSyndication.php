<?php

namespace BiwyzeTourinsoft;

use BiwyzeTourinsoft\Core\Admin;
use BiwyzeTourinsoft\Core\Install;

class BiwyzeTourinsoftSyndication
{
    const VERSION = "1.0.0";
    const DB_VERSION = "1.0";
    const PREFIX = "biwyze_ts";
    const PLUGIN_NAME = 'Biwyze Tourinsoft Syndication';

    const SYNDICATIONS_TABLE = 'tourinsoft_syndications';

    const PLUGIN_DIR = WP_PLUGIN_DIR . "/biwyze_tourinsoft_syndication";

    public function boot() {
        add_action( 'plugins_loaded', [$this, 'checkUpdate']);
        add_action('admin_menu', [Admin::class, 'createAdminPages']);
    }

    public function checkUpdate () {
        (new Install())->checkDBUpdate();
    }
}