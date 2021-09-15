<?php

namespace BiwyzeTourinsoft\Repositories;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Config\Parser;

class OptionsRepository
{
    const OVERRIDE_SAVED = 1;
    const KEEP_SAVED = 1;

    public static function registerDefaults(int $saveType)
    {
        if (!function_exists('update_option')) return;
        if (!function_exists('get_option')) return;
        if (!function_exists('add_option')) return;
        if (!function_exists('esc_sql')) return;

        $optionDefaults = Parser::get('options')['defaults'];

        foreach ($optionDefaults as $option => $default) {

            $optionName = esc_sql(BiwyzeTourinsoftSyndication::PREFIX . '_' . $option);

            if($saveType === self::KEEP_SAVED && get_option($optionName, null) !== null) {
                continue;
            }

            if($saveType === self::OVERRIDE_SAVED && get_option($optionName, null) !== null) {
                update_option($optionName, $default);
            }

            add_option($optionName, $default);
        }
    }

    /**
     * @return array
     */
    public static function allOptions(): array
    {
        if (!function_exists('get_option')) return [];

        $optionsList = Parser::get('options')['list'];
        $optionsDefault = Parser::get('options')['defaults'];
        $options = [];

        foreach ($optionsList as $option) {
            $options[] = array_merge($option, ['value' => self::getOption($option['identifier'])]);
        }

        return $options;
    }

    public static function getOption(string $option, $default = null)
    {
        if (!function_exists('get_option')) return null;

        $optionsDefault = Parser::get('options')['defaults'];

        return get_option(BiwyzeTourinsoftSyndication::PREFIX . '_' . $option, $default ?? $optionsDefault[$option] ?? null);
    }

    public static function saveOptions(array $options) {
        if (!function_exists('update_option')) return;
        if (!function_exists('get_option')) return;
        if (!function_exists('add_option')) return;
        if (!function_exists('esc_sql')) return;

        $success = true;
        foreach($options as $option) {
            $optionName = esc_sql(BiwyzeTourinsoftSyndication::PREFIX . '_' . $option['identifier']);
            $optionValue = get_option($optionName);
            $success = true;
            if($optionValue === $option['value']) continue;
            if($optionValue === null) {
                if(!add_option($optionName, $option['value'])) $success = false;
                continue;
            }
            if(!update_option($optionName, $option['value'])) $success = false;

            return $success;
        }
    }
}