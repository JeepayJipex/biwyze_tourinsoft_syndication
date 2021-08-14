<?php
/*
Plugin Name: Biwyze Tourinsoft
Plugin URI: https://biwyze.fr
Description: Plugin pour l'intégration d'offres présentes sur Tourinsoft à votre site Wordpress
Version: 1.0
Author: Jean Mariette
Author URI: https://biwyze.fr
License: propriétaire
*/

require_once(__DIR__ . '/vendor/autoload.php');

$plugin = new \BiwyzeTourinsoft\BiwyzeTourinsoftSyndication();
$plugin->boot();