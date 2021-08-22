<?php

namespace BiwyzeTourinsoft\Handlers;

class SyndicationPostCreator
{
    /**
     * @var array
     */
    private $syndication;
    /**
     * @var array
     */
    private $offers;
    /**
     * @var SyndicationReader
     */
    private $reader;

    public function __construct(array $syndication)
    {
        $this->syndication = $syndication;
        $this->reader = new SyndicationReader($syndication['syndic_id'], $syndication['name']);
    }

    public function readContent(): SyndicationPostCreator
    {
        $this->offers = $this->reader->getParsedOffers();
        return $this;
    }

    public function createPosts(): bool
    {
        foreach($this->offers as $offer) {
            $id = $this->createPost($offer);
            if ($id === 0) { return false; }
            $this->addPostCustomFieldsMetas($id, $offer);
        }
        return true;
    }

    /**
     * @param array $offer
     * @return int
     */
    public function createPost(array $offer): int
    {
        if (!function_exists('wp_insert_post') || !function_exists('wp_strip_all_tags')) {
            return 0;
        }
        $newPost = [
            'post_title' => wp_strip_all_tags($offer['SyndicObjectName']),
            'post_content' => "",
            'post_type' => $this->syndication['associated_post_type'],
            'post_status' => 'publish',
            'post_category' => [$this->syndication['category_id']],
            'comment_status' => 'closed'
        ];
        return wp_insert_post($newPost, false);
    }

    /**
     * @deprecated not implemented yet
     */
    public function addPostFeaturedImage()
    {}

    /**
     * @param int $id
     * @param array $offer
     * @return bool
     */
    public function addPostCustomFieldsMetas (int $id, array $offer): bool
    {
        if(!function_exists('add_post_meta') || !function_exists('sanitize_title')) {
            return false;
        }
        foreach($offer as $key => $value) {
            add_post_meta($id, $key, $value);
        }
        add_post_meta($id, 'syndication_number', sanitize_title($this->syndication['name']) . '_' . $this->syndication['syndic_id'] . '_' . $this->syndication['category_id']);
        return true;
    }
}