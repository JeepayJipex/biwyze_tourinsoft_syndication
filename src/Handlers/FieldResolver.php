<?php

namespace BiwyzeTourinsoft\Handlers;

class FieldResolver
{
    public static function getFeaturedImageUrl(string $fieldName, int $postId)
    {
        $field = get_post_meta($fieldName, $postId);

        if (!$field) return '#';
        if (!is_array($field)) return $field;
        while (is_array($field) && count($field) > 0) {
            $field = $field[0];
        }
        return is_array($field) ? $field[0] : $field;
    }
}