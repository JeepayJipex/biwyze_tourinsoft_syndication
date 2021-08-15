<?php

namespace BiwyzeTourinsoft\Handlers;

class SyndicationFieldReader
{
    /**
     * @var string
     */

    public static function separateField($fieldValue): array
    {
        return self::separateInnerValues(self::separateOccurences($fieldValue));
    }

    public static function separateOccurences(string $fieldValue): array
    {
        $values =  explode('#', $fieldValue);
        return array_filter($values, function ($value) {
            return $value !== '';
        });
    }

    public static function separateInnerValues(array $values): array
    {
        return array_map(function ($value) {
            $arrayValue = explode('|', $value);
            return array_filter($arrayValue, function ($value) {
                return $value !== '';
            });
        }, $values);
    }
}