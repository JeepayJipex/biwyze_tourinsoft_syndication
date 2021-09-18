<?php

namespace BiwyzeTourinsoft\Core;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class Admin
{
    public static function createAdminPages()
    {
        add_menu_page('Tourinsoft Syndication Options', 'Syndications Tourinsoft', 'manage_options', 'biwyze_tourinsoft_admin', [Admin::class, 'mainAdminPage']);
    }

    public static function mainAdminPage()
    {
        require_once BiwyzeTourinsoftSyndication::PLUGIN_DIR . '/src/Views/dashboard_home.php';
    }

    public static function addAdminAssets ($hook)
    {
        if($hook === "toplevel_page_biwyze_tourinsoft_admin") {
            wp_enqueue_style('biwyze_tourinsoft_bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css', [], '5.1.0');
            wp_enqueue_script('biwyze_tourinsoft_bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', [], '5.0.2');
            wp_enqueue_script('biwyze_tourinsoft_alpine_js', 'https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js', [], '3.0.0');
            wp_enqueue_script('biwyze_tourinsoft_axios_js', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js', [], '0.21.1');
            wp_enqueue_script('biwyze_tourinsoft_admin_js', plugins_url('biwyze_tourinsoft_syndication/assets/js/admin-bundle.js'), ['biwyze_tourinsoft_alpine_js', 'biwyze_tourinsoft_axios_js'], BiwyzeTourinsoftSyndication::VERSION);
            wp_localize_script('biwyze_tourinsoft_admin_js', 'biwyzeGlobals', [
                'rest_url' => rest_url(),
                'rest_nonce' => wp_create_nonce('wp_rest'),
            ]);
        }
    }

}