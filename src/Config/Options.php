<?php

namespace BiwyzeTourinsoft\Config;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Repositories\OptionsRepository;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class Options
{
    public static function getOptions()
    {
        return [
            'list' => [
                [ 'identifier' => 'create_custom_types', 'label' => 'Créer des types de contenus personnalisés', 'type' => 'boolean'],
                ['identifier' => 'use_elementor_templates', 'label' => 'Utiliser des templates Elementor', 'type' => 'boolean'],
                [ 'identifier' => BiwyzeTourinsoftSyndication::TOURINSOFT_API_VERSION_OPTION, 'label' => 'Version de Tourinsoft', 'type' => 'select', 'options' => ['1.0', '3.0', '5.0']],
                [ 'identifier' => BiwyzeTourinsoftSyndication::CDT_OPTION, 'label' => 'Identifiant CDT', 'type' => 'input', 'input' => 'text'],
            ],
            'defaults' => [
                'create_custom_types' => 0,
                'use_elementor_templates' => 0,
                BiwyzeTourinsoftSyndication::TOURINSOFT_API_VERSION_OPTION => '3.0',
                BiwyzeTourinsoftSyndication::CDT_OPTION => 'cdt31'
            ],
        ];
    }

    protected static function elementorFields () {
        if (OptionsRepository::getOption('use_elementor_templates') === "1") {
            return array_map(function ($syndication) {
                return ['identifier' => 'use_elementor_template_number', 'label' => "Syndication ". $syndication['name'] . ": Numéro de template elementor", 'type'=> 'boolean'];
            }, SyndicationRepository::all());
        }
        return [];
    }
}
