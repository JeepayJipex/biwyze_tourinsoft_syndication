<?php

namespace BiwyzeTourinsoft\Handlers\ACF;

class FieldCreator
{
    public static function generic(string $fieldName, string $type, $fieldValue)
    {
        return [
            'key' => sanitize_title($fieldName),

            /* (string) Visible when editing the field value */
            'label' => $fieldName,

            /* (string) Used to save and load data. Single word, no spaces. Underscores and dashes allowed */
            'name' => sanitize_title($fieldName),

            /* (string) Type of field (text, textarea, image, etc) */
            'type' => $type,

            /* (string) Instructions for authors. Shown when submitting data */
            'instructions' => '',

            /* (int) Whether or not the field value is required. Defaults to 0 */
            'required' => 0,

            /* (mixed) Conditionally hide or show this field based on other field's values.
            Best to use the ACF UI and export to understand the array structure. Defaults to 0 */
            'conditional_logic' => 0,

            /* (array) An array of attributes given to the field element */
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),

            /* (mixed) A default value used by ACF if no value has yet been saved */
            'default_value' => '',
        ];
    }

    public static function text(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'text', $fieldValue), [
            /* ... Insert generic settings here ... */

            /* (string) Appears within the input. Defaults to '' */
            'placeholder' => '',

            /* (string) Appears before the input. Defaults to '' */
            'prepend' => '',

            /* (string) Appears after the input. Defaults to '' */
            'append' => '',

            /* (string) Restricts the character limit. Defaults to '' */
            'maxlength' => '',

            /* (bool) Makes the input readonly. Defaults to 0 */
            'readonly' => 0,

            /* (bool) Makes the input disabled. Defaults to 0 */
            'disabled' => 0,

        ]);
    }

    public static function textarea(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'textarea', $fieldValue), [
            /* ... Insert generic settings here ... */

            /* (string) Appears within the input. Defaults to '' */
            'placeholder' => '',

            /* (string) Restricts the character limit. Defaults to '' */
            'maxlength' => '',

            /* (int) Restricts the number of rows and height. Defaults to '' */
            'rows' => '',

            /* (new_lines) Decides how to render new lines. Detauls to 'wpautop'.
            Choices of 'wpautop' (Automatically add paragraphs), 'br' (Automatically add <br>) or '' (No Formatting) */
            'new_lines' => '',

            /* (bool) Makes the input readonly. Defaults to 0 */
            'readonly' => 0,

            /* (bool) Makes the input disabled. Defaults to 0 */
            'disabled' => 0,
        ]);
    }

    public static function number(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'number', $fieldValue), []);
    }

    public static function email(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'email', $fieldValue), [

            /* ... Insert generic settings here ... */

            /* (string) Appears within the input. Defaults to '' */
            'placeholder' => '',

            /* (string) Appears before the input. Defaults to '' */
            'prepend' => '',

            /* (string) Appears after the input. Defaults to '' */
            'append' => '',

        ]);
    }

    public static function url(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'url', $fieldValue), []);
    }

    public static function wysiwyg(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'wysiwyg', $fieldValue), []);
    }

    public static function oembed(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'oembed', $fieldValue), []);
    }

    public static function image(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'image', $fieldValue), []);
    }


    public static function gallery(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'gallery', $fieldValue), []);
    }

    public static function true_false(string $fieldName, $fieldValue)
    {
        return array_merge(self::generic($fieldName,'text', $fieldValue), []);
    }

}