<?php

namespace BiwyzeTourinsoft\Config;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
class Parser
{
    public static function get(string $identifier): array
    {
        $className = "BiwyzeTourinsoft\\Config\\".ucfirst($identifier);
        return $className::getOptions();
    }
}