<?php

namespace BiwyzeTourinsoft\Controllers;

use BiwyzeTourinsoft\Handlers\SyndicationPostCreator;
use BiwyzeTourinsoft\Handlers\SyndicationPostDeleter;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class SyncSyndicationController extends \WP_REST_Controller
{
    public static function updateAll(\WP_REST_Request $request): \WP_REST_Response
    {
        $syndications = (new SyndicationRepository())->all();
        foreach ($syndications as $syndication) {
            if (!self::syncSyndication($syndication)) {
                return new \WP_REST_Response('error updating syndications, this one failed : ' . $syndication['name'], 500);
            }
        }
        return new \WP_REST_Response('updated all syndications', 200);
    }

    public static function updateOne(\WP_REST_Request $request): \WP_REST_Response
    {

        $id = $request->get_param('id');
        $syndication = (new SyndicationRepository())->get($id);
        if (!self::syncSyndication(json_decode(json_encode($syndication), true))) {
            return new \WP_REST_Response('error updating syndication', 500);
        }
        return new \WP_REST_Response('updated all syndications', 200);
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