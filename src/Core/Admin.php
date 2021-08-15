<?php

namespace BiwyzeTourinsoft\Core;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class Admin
{
    public static function createAdminPages() {
        add_menu_page('Tourinsoft Syndication Options', 'Syndications Tourinsoft', 'manage_options', 'biwyze_tourinsoft_admin', [Admin::class, 'mainAdminPage']);
    }

    public static function mainAdminPage() {
        require_once BiwyzeTourinsoftSyndication::PLUGIN_DIR . '/src/Views/dashboard_home.php';
    }
}