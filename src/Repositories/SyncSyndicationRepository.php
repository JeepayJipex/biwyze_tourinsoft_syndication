<?php

namespace BiwyzeTourinsoft\Repositories;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\Handlers\SyndicationPostCreator;
use BiwyzeTourinsoft\Handlers\SyndicationPostDeleter;

class SyncSyndicationRepository
{

    public static function updateOne(int $id)
    {
        $syndication = SyndicationRepository::get($id);
        if (!self::syncSyndication(json_decode(json_encode($syndication), true))) {
            throw new \Exception('error updating syndication');
        }
    }
    public static function updateAll()
    {
        $syndications = SyndicationRepository::all();
        foreach ($syndications as $syndication) {
            if (!self::syncSyndication($syndication)) {
                throw new \Exception('error updating syndications, this one failed : ' . $syndication['name']);
            }
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