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
            'elementor' => self::elementorFields()
        ];
    }

    protected static function elementorFields () {
        if (get_option(BiwyzeTourinsoftSyndication::PREFIX . '_' . 'use_elementor_templates', false)) {
            return array_map(static function ($syndication) {
                return ['identifier' => 'elementor_template_'.$syndication['syndic_id'], 'label' => "Syndication ". $syndication['name'], 'type'=> 'input', 'input' => 'number'];
            }, SyndicationRepository::all());
        }
        return [];
    }
}
