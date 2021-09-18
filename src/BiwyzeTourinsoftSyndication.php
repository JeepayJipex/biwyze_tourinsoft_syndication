<?php

namespace BiwyzeTourinsoft;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\Core\Admin;
use BiwyzeTourinsoft\Core\Install;
use BiwyzeTourinsoft\Core\Loader;
use BiwyzeTourinsoft\Handlers\CustomPostType;
use BiwyzeTourinsoft\Repositories\OptionsRepository;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class BiwyzeTourinsoftSyndication
{
    const VERSION = "1.0.0";
    const DB_VERSION = "1.1";
    const PREFIX = "biwyze_ts";
    const PLUGIN_NAME = 'Biwyze Tourinsoft Syndication';

    const SYNDICATIONS_TABLE = 'tourinsoft_syndications';

    const PLUGIN_DIR = WP_PLUGIN_DIR . "/biwyze_tourinsoft_syndication";

    const TOURINSOFT_URL = 'https://wcf.tourinsoft.com';
    const CDT_OPTION = 'biwyze_tourinsoft_cdt';
    const TOURINSOFT_API_VERSION_OPTION = 'biwyze_tourinsoft_api_version';
    const MINIMUM_ELEMENTOR_VERSION = 1.8;
    const MINIMUM_PHP_VERSION = 7.0;

    public function boot() {
        OptionsRepository::registerDefaults(OptionsRepository::KEEP_SAVED);
        add_action( 'plugins_loaded', [$this, 'plugins_loaded']);
        add_action('admin_menu', [Admin::class, 'createAdminPages']);
        if (!wp_next_scheduled('cron_tourinsoft')) {
            wp_schedule_event(strtotime('04:00:00'), 'daily', 'cron_tourinsoft');
        }
        (new Loader())->load();
    }

    public function plugins_loaded () {
        (new Install())->checkDBUpdate();
    }

    public static function is_elementor_compatible() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            var_dump('action non loaded');
            return false;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            return false;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            return false;
        }

        return true;

    }

}