<?php

namespace BiwyzeTourinsoft\Handlers;

class SyndicationPostDeleter
{
    /**
     * @var array
     */
    private $syndication;

    public function __construct(array $syndication)
    {
        $this->syndication = $syndication;
    }

    public function getSyndicationAssociatedPosts (): array
    {
        if (function_exists('get_posts')) {
            return get_posts([
                'post_type' => sanitize_title($this->syndication['name']),
                'meta_query' => [
                    'key' => 'syndication_number',
                    'value' => sanitize_title($this->syndication['name']) . '_' . $this->syndication['syndic_id'] . '_' . $this->syndication['category_id'],
                    'compare' => '='
                ],
                'category' => $this->syndication['category_id'],
                'posts_per_page' => -1,
                'nopaging' => true
            ]);
        }
        return [];
    }

    public function deletePosts(array $posts): bool
    {
        if (function_exists('wp_delete_post')) {
            foreach ($posts as $post) {
                wp_delete_post($post->ID, true);
            }
            return true;
        }
        return false;
    }

    /**
     * @deprecated not implemented yet
     */
    public function cleanFeaturedImage()
    {}
}