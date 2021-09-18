<?php

namespace BiwyzeTourinsoft\Handlers\ACF;

use BiwyzeTourinsoft\Config\Parser;

class FieldsGroupCreator
{
    public static function createSyndicationFieldGroup(array $syndication, array $fields)
    {
        $fieldsOptions = Parser::get('fields');
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group([
                'key' => 'syndication' . sanitize_title($syndication['name']),
                'title' => $syndication['name'] . ' Groupe de champs',
                'fields' => self::buildFieldArray($fields, $fieldsOptions),
                'location' => [
                    [
                        [
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => $syndication['associated_post_type'],
                        ],
                        [
                            'param' => 'post_category',
                            'operator' => '==',
                            'value' => $syndication['category_id'],
                        ]
                    ],
                ],
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                ]);

        endif;
    }

    public static function buildFieldArray(array $fields, array $fieldOption): array
    {
        $groupFields = [];
        foreach ($fields as $field => $value) {
            if(isset($fieldOption[$field])) {
                $type = $fieldOption[$field];
                $groupFields[] = FieldCreator::{$type}($field, $value);
                continue;
            }
            $groupFields[] = FieldCreator::text($field, $value);
        }
        return $groupFields;
    }
}