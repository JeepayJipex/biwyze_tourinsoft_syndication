<?php

namespace BiwyzeTourinsoft\Database;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class Tables
{

 public static function getTables () {


     global $wpdb;

     return [
         "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE ."` (
	`id` INT unsigned NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`category_id` INT NOT NULL,
	`syndic_id` VARCHAR(255) NOT NULL,
	`associated_post_type` VARCHAR(255) NOT NULL,
	`synced_at` TIMESTAMP NOT NULL,
	`active` TINYINT(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
)" . $wpdb->get_charset_collate() . ";"
     ];
 }
}