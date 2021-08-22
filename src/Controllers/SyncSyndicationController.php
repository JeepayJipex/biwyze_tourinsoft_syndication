<?php

namespace BiwyzeTourinsoft\Controllers;

use BiwyzeTourinsoft\Handlers\SyndicationPostCreator;
use BiwyzeTourinsoft\Handlers\SyndicationPostDeleter;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class SyncSyndicationController extends \WP_REST_Controller
{
    public function updateAll(\WP_Request $request)
    {
        $syndications = (new SyndicationRepository())->all();

        foreach ($syndications as $syndication) {
            $deleter = new SyndicationPostDeleter($syndication);
            $posts = $deleter->getSyndicationAssociatedPosts();
            if(!$deleter->deletePosts($posts)) {
                return new \WP_REST_Response('could not delete syndication data for syndication : ' . $syndication['name'], 500);
            }

            $updater = new SyndicationPostCreator($syndication);
            if (!$updater->readContent()->createPosts()) {
                return new \WP_REST_Response('could not update syndication posts for syndication : ' . $syndication['name'], 500);
            }
        }
        return new \WP_REST_Response('updated all syndications', 200);
    }
}