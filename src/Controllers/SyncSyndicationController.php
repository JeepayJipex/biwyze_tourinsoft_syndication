<?php

namespace BiwyzeTourinsoft\Controllers;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\Handlers\SyndicationPostCreator;
use BiwyzeTourinsoft\Handlers\SyndicationPostDeleter;
use BiwyzeTourinsoft\Repositories\SyncSyndicationRepository;

class SyncSyndicationController extends \WP_REST_Controller
{
    public static function updateAll(\WP_REST_Request $request): \WP_REST_Response
    {
        try {
            SyncSyndicationRepository::updateAll();
            return new \WP_REST_Response('updated all syndications', 200);
        } catch (\Exception $exception) {
            return new \WP_REST_Response($exception->getMessage(), 500);
        }

    }

    public static function updateOne(\WP_REST_Request $request): \WP_REST_Response
    {
        try {
            $id = $request->get_param('id');
            SyncSyndicationRepository::updateOne($id);
            return new \WP_REST_Response('updated all syndications', 200);

        } catch (\Exception $exception) {
            return new \WP_REST_Response($exception->getMessage(), 500);
        }

    }
}