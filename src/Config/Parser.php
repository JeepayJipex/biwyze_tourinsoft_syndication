<?php

namespace BiwyzeTourinsoft\Config;

class Parser
{
    public static function get(string $identifier): array
    {
        $className = "BiwyzeTourinsoft\\Config\\".ucfirst($identifier);
        return $className::getOptions();
    }
}