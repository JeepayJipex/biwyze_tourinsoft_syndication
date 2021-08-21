<?php

namespace BiwyzeTourinsoft;

use BiwyzeTourinsoft\Core\Admin;
use BiwyzeTourinsoft\Core\Install;
use BiwyzeTourinsoft\Core\Loader;
use BiwyzeTourinsoft\Handlers\CustomPostType;
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

    public function boot() {
        add_action( 'plugins_loaded', [$this, 'plugins_loaded']);
        add_action('admin_menu', [Admin::class, 'createAdminPages']);

        (new Loader())->load();
    }

    public function plugins_loaded () {
        (new Install())->checkDBUpdate();
    }

}