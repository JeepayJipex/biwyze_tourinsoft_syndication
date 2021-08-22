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
        foreach ($this->types as $type) {
            if (!post_type_exists($type)) {
                register_post_type($type, $this->generateArgs($type));
                $this->registerTaxonomiesToCpt($type);
            }
        }
    }

    private function generateLabels(string $typeName): array
    {
        return [
            'name' => ucfirst($typeName) . ' (Tourinsoft)',
            'singular_name' => $typeName,
            'menu_name' => ucfirst($typeName) . ' (Tourinsoft)',
            'all_items' => 'Tous les ' . $typeName,
            'view_item' => 'Voir le/la/l\' ' . $typeName,
            'add_new_item' => 'Ajouter un ' . $typeName,
            'add_new' => 'Ajouter',
            'edit_item' => 'Editer le ' . $typeName,
            'update_item' => 'Modifier le ' . $typeName,
            'search_items' => 'Rechercher un ' . $typeName,
            'not_found' => 'Non trouvé',
            'not_found_in_trash' => 'Non trouvé dans la corbeille',
        ];
    }

    private function generateArgs(string $typeName): array
    {
        return [
            'label' => $typeName,
            'description' => 'Tous les ' . $typeName,
            'labels' => $this->generateLabels($typeName),
            'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'],
            'hierarchical' => true,
            'public' => true,
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
//            'rewrite' => ['slug' => sanitize_title($typeName), 'with_front' => false],
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