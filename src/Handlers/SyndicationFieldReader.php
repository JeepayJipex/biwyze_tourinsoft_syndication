<?php

namespace BiwyzeTourinsoft\Handlers;

class SyndicationFieldReader
{
    /**
     * @var string
     */
    private $fieldKey;
    private $fieldValue;
    public $fieldValueArray;

    public function __construct(string $fieldKey, $fieldValue)
    {
        $this->fieldKey = $fieldKey;
        $this->fieldValue = $fieldValue;
        $this->fieldValueArray = $this->separateField($this->fieldValue);
    }

    private function separateField($fieldValue): array
    {
        return $this->separateInnerValues($this->separateOccurences($fieldValue));
    }

    private function separateOccurences(string $fieldValue): array
    {
        $values =  explode('#', $fieldValue);
        return array_filter($values, function ($value) {
            return $value !== '';
        });
    }

    private function separateInnerValues(array $values): array
    {
        return array_map(function ($value) {
            $arrayValue = explode('|', $value);
            return array_filter($arrayValue, function ($value) {
                return $value !== '';
            });
        }, $values);
    }
}