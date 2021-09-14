<?php

namespace BiwyzeTourinsoft\Config;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class Options
{
    public static function getOptions()
    {
        return [
            'list' => [
                [ 'identifier' => 'create_custom_types', 'label' => 'Créer des types de contenus personnalisés'],
                [ 'identifier' => BiwyzeTourinsoftSyndication::TOURINSOFT_API_VERSION_OPTION, 'label' => 'Version de Tourinsoft'],
                [ 'identifier' => BiwyzeTourinsoftSyndication::CDT_OPTION, 'label' => 'Identifiant CDT'],
            ],
            'defaults' => [
                'create_custom_types' => 0,
                BiwyzeTourinsoftSyndication::TOURINSOFT_API_VERSION_OPTION => '3.0',
                BiwyzeTourinsoftSyndication::CDT_OPTION => 'cdt31'
            ]
        ];
    }
}
