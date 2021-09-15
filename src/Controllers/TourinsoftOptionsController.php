<?php

namespace BiwyzeTourinsoft\Controllers;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\Repositories\OptionsRepository;
use BiwyzeTourinsoft\Repositories\SyncSyndicationRepository;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class TourinsoftOptionsController extends \WP_REST_Controller
{
    public static function list(\WP_REST_Request $request): \WP_REST_Response
    {
        return new \WP_REST_Response(OptionsRepository::allOptions(), 200);
    }

    public static function register(\WP_REST_Request $request): \WP_REST_Response
    {
        $options = $request->get_param('options');
        $options = json_decode(json_encode($options), true);

        if (OptionsRepository::saveOptions($options)) {
            return new \WP_REST_Response('done', 200);
        }
        return \WP_REST_Response('Error while updating options', 500);
    }

    public static function generateExport(\WP_REST_Request $request): \WP_REST_Response
    {
        return new \WP_REST_Response([
            'syndications' => array_map(static function ($syndication) {
                return [
                    "name" => $syndication['name'],
                    "syndic_id" => $syndication['syndic_id'],
                    "category_id" => get_term_by('id', $syndication['category_id'], 'category') ? $syndication['category_id'] : '0',
                    "associated_post_type" => 'article_tourinsoft'
                ];
            }, SyndicationRepository::all()),
            'options' => OptionsRepository::allOptions()
        ], 200);
    }

    public static function importData(\WP_REST_Request $request): \WP_REST_Response
    {
        $options = $request->get_param('options');
        $options = json_decode(json_encode($options), true);

        $syndications = $request->get_param('syndications');
        $syndications = json_decode(json_encode($syndications), true);

        OptionsRepository::saveOptions($options);
        SyndicationRepository::empty();
        foreach ($syndications as $syndication) {
            $newSyndication = SyndicationRepository::store($syndication);
        }
//        SyncSyndicationRepository::updateAll();

        return new \WP_REST_Response('done', 201);
    }
}