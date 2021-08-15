<?php

namespace BiwyzeTourinsoft;

use BiwyzeTourinsoft\Core\Install;

class BiwyzeTourinsoftSyndication
{
    const VERSION = "1.0.0";
    const DB_VERSION = "1.0";
    const PREFIX = "biwyze_ts";
    const PLUGIN_NAME = 'Biwyze Tourinsoft Syndication';

    const SYNDICATIONS_TABLE = 'tourinsoft_syndications';


    public function boot() {
        add_action( 'plugins_loaded', [$this, 'checkUpdate']);
    }

    public function checkUpdate () {
        (new Install())->checkDBUpdate();
    }
}