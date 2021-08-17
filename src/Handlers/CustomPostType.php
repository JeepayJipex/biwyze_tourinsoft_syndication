<?php

namespace BiwyzeTourinsoft\Handlers;

class CustomPostType
{
    public $types;

    public function __construct(array $types = [])
    {
        $this->types = $types;
    }

    public function generateCustomPostTypes()
    {
        foreach($this->types as $type) {
            register_post_type($type, $this->generateArgs($type));
            $this->registerTaxonomiesToCpt($type);
        }
    }

    private function generateLabels(string $typeName): array
    {
        return [
            'name' => _x($typeName, 'Post Type General Name'),
            'singular_name' => _x($typeName, 'Post Type Singular Name'),
            'menu_name' => __($typeName),
            'all_items' => __('Tous les articles ' . $typeName),
            'view_item' => __('Voir l\'article' . $typeName),
            'add_new_item' => __('Ajouter un ' . $typeName),
            'add_new' => __('Ajouter'),
            'edit_item' => __('Editer le ' . $typeName),
            'update_item' => __('Modifier le ' . $typeName),
            'search_items' => __('Rechercher un ' . $typeName),
            'not_found' => __('Non trouvé'),
            'not_found_in_trash' => __('Non trouvé dans la corbeille'),
        ];
    }

    private function generateArgs(string $typeName): array
    {
        return [
            'label' => __($typeName),
            'description' => __('Tous les ' . $typeName),
            'labels' => $this->generateLabels($typeName),
            'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'],
            'hierarchical' => true,
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => sanitize_title($typeName), 'with_front' => false],
            'taxonomies' => ['category', 'post_tag'],
        ];
    }
    private function registerTaxonomiesToCpt($typeName)
    {
        register_taxonomy_for_object_type('category', $typeName);
        register_taxonomy_for_object_type('post_tag', $typeName);
        register_taxonomy_for_object_type('tag', $typeName);
    }
}