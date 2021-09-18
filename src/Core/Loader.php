<?php

namespace BiwyzeTourinsoft\Core;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Handlers\CustomPostType;
use BiwyzeTourinsoft\Repositories\OptionsRepository;
use BiwyzeTourinsoft\Repositories\SyncSyndicationRepository;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;
use BiwyzeTourinsoft\Widgets\CustomFieldImages;
use BiwyzeTourinsoft\Widgets\CustomFieldText;

class Loader
{

    public function load()
    {
        $this->registerAssets();
        $this->registerRestRoutes();
        $this->executeTourinsoftCrons();
        add_action('init', [$this, 'registerCustomPostTypes']);
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action( 'elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories'] );

    }

    public function registerAssets()
    {
        add_action('admin_enqueue_scripts', [Admin::class, 'addAdminAssets'], 10, 1);
        add_filter('script_loader_tag', function ($tag, $handle) {

            if (!in_array($handle, ['biwyze_tourinsoft_alpine_js']))
                return $tag;

            return str_replace(' src', ' defer="defer" src', $tag);
        }, 10, 2);

    }

    public function registerRestRoutes()
    {
        (new Api())->registerRestRoutes();
    }

    public function registerCustomPostTypes()
    {
        (new CustomPostType(['article_tourinsoft']))->generateCustomPostTypes();
        if ((int)OptionsRepository::getOption('create_custom_types') === 0) return;

        $syndicationsNames = array_map(static function ($syndication) {
            return sanitize_title($syndication['name']);
        }, SyndicationRepository::all());

        (new CustomPostType($syndicationsNames))->generateCustomPostTypes();
    }

    public function register_widgets()
    {
        if (BiwyzeTourinsoftSyndication::is_elementor_compatible()) {
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CustomFieldText());
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new CustomFieldImages());
        }

    }

    function add_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'tourinsoft',
            [
                'title' => 'Tourinsoft',
                'icon' => 'fa fa-plug',
            ]
        );
    }

    public function executeTourinsoftCrons()
    {
        add_action('cron_tourinsoft', [SyncSyndicationRepository::class, 'updateAll']);
    }
}