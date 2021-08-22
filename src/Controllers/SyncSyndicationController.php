<?php

namespace BiwyzeTourinsoft\Controllers;

use BiwyzeTourinsoft\Handlers\SyndicationPostCreator;
use BiwyzeTourinsoft\Handlers\SyndicationPostDeleter;
use BiwyzeTourinsoft\Repositories\SyncSyndicationRepository;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

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

    /**
     * @param $syndication
     * @return bool
     */
    protected static function syncSyndication($syndication): bool
    {
        $deleter = new SyndicationPostDeleter($syndication);
        $posts = $deleter->getSyndicationAssociatedPosts();
        if (!$deleter->deletePosts($posts)) {
            return false;
        }

        $updater = new SyndicationPostCreator($syndication);
        if (!$updater->readContent()->createPosts()) {
            return false;
        }
        return true;
    }
}