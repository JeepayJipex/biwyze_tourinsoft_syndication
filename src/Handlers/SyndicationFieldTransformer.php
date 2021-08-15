<?php

namespace BiwyzeTourinsoft\Handlers;

class SyndicationFieldTransformer
{
    public function handleFieldTransform(string $fieldKey, $fieldValue)
    {
        $fieldValue = (new SyndicationFieldReader($fieldKey, $fieldValue))->fieldValueArray;

        if(!method_exists($this, $fieldKey)) {
            $transformedField =  array_map(function($value) {
                return implode('\n', $value);
            }, $fieldValue);

            if(count($transformedField) === 1) {
                return $transformedField[0];
            }
            return $transformedField;
        }

        return $this->{$fieldKey}($fieldValue);
    }
}