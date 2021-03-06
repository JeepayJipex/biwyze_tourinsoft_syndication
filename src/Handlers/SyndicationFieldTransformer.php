<?php

namespace BiwyzeTourinsoft\Handlers;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
class SyndicationFieldTransformer
{
    public static function handleFieldTransform(string $fieldKey, $fieldValue)
    {
        $fieldValue = SyndicationFieldReader::separateField($fieldValue);

        if(!method_exists(__CLASS__, strtolower($fieldKey))) {
            $transformedField =  array_map(function($value) {
                return implode('<br />', $value);
            }, $fieldValue);

            if(count($transformedField) === 1) {
                return $transformedField[0];
            }
            return $transformedField;
        }
        $method = strtolower($fieldKey);
        return self::{$method}($fieldValue);
    }

    public static function photos ($field) {
        return $field;
    }
}