<?php

namespace BiwyzeTourinsoft\Database;

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
	`created_at` TIMESTAMP NOT NULL,
	`synced_at` TIMESTAMP NOT NULL,
	`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`active` TINYINT(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
)" . $wpdb->get_charset_collate() . ";"
     ];
 }
}