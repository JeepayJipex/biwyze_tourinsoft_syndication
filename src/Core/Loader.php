<?php

namespace BiwyzeTourinsoft\Core;

class Loader
{

    public function load() {
       $this->registerAssets();
       $this->registerRestRoutes();
    }

    public function registerAssets () {
        add_action('admin_enqueue_scripts', [Admin::class, 'addAdminAssets'],10,1);
        add_filter( 'script_loader_tag', function ( $tag, $handle ) {

            if (  !in_array($handle, ['biwyze_tourinsoft_alpine_js']) )
                return $tag;

            return str_replace( ' src', ' defer="defer" src', $tag );
        }, 10, 2 );
    }

    public function registerRestRoutes() {
        (new Api())->registerRestRoutes();
    }
}