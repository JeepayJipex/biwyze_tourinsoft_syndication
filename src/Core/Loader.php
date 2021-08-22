<?php

namespace BiwyzeTourinsoft\Core;

use BiwyzeTourinsoft\Handlers\CustomPostType;
use BiwyzeTourinsoft\Repositories\SyncSyndicationRepository;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class Loader
{

    public function load() {
       $this->registerAssets();
       $this->registerRestRoutes();
       $this->executeTourinsoftCrons();
        add_action('init', [$this, 'registerCustomPostTypes']);
    }

    public function registerAssets () {
        add_action('admin_enqueue_scripts', [Admin::class, 'addAdminAssets'],10,1);
        add_filter( 'script_loader_tag', function ( $tag, $handle ) {

            if (!in_array($handle, ['biwyze_tourinsoft_alpine_js']) )
                return $tag;

            return str_replace( ' src', ' defer="defer" src', $tag );
        }, 10, 2 );

    }

    public function registerRestRoutes() {
        (new Api())->registerRestRoutes();
    }

    public function registerCustomPostTypes()
    {
        $syndicationsNames = array_map(static function ($syndication) {
            return sanitize_title($syndication['name']);
        }, (new SyndicationRepository())->all());

        (new CustomPostType($syndicationsNames))->generateCustomPostTypes();
    }

    public function executeTourinsoftCrons() {
        add_action( 'cron_tourinsoft', [SyncSyndicationRepository::class, 'updateAll']);
    }
}