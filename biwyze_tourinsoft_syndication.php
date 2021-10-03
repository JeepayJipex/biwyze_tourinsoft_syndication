<?php
/*
Plugin Name: Biwyze Tourinsoft
Plugin URI: https://biwyze.fr
Description: Plugin pour l'intégration d'offres présentes sur Tourinsoft à votre site Wordpress
Version: 1.0
Author: Jean Mariette
Author URI: https://biwyze.fr
Requires PHP: 7.0
Requires at least: 5.8.1
License: propriétaire
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use BiwyzeTourinsoft\Core\Install;

require_once(__DIR__ . '/vendor/autoload.php');

if(!function_exists('biwyze_plugin_install')) {
    function biwyze_plugin_install()
    {
        (new Install())->start();
    }

}

if(!function_exists('biwyze_plugin_uninstall')) {
    function biwyze_plugin_uninstall()
    {

    }
}

register_activation_hook(__FILE__, 'biwyze_plugin_install');
register_deactivation_hook(__FILE__, 'biwyze_plugin_uninstall');

(new \BiwyzeTourinsoft\BiwyzeTourinsoftSyndication())->boot();
