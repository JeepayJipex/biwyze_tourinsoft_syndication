<?php

namespace BiwyzeTourinsoft\Repositories;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class SyndicationRepository
{
    static public function all()
    {
        global $wpdb;
        return $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ARRAY_A);
    }

    public static function get(int $id)
    {
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');
    }

    public static function update(int $id, array $data)
    {
        global $wpdb;

        $data['updated_at'] = date('Y-m-d H:i:s');
        $wpdb->update($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, $data, ['id' =>$id]);
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');
    }

    public static function store (array $data) {
        global $wpdb;

        $wpdb->insert($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, array_merge($data, [
            'created_at' => date('Y-m-d H:i:s')
        ]));

        $id = $wpdb->insert_id;
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');

    }

    public static function delete(int $id)
    {
        global $wpdb;

        return $wpdb->delete($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ['id' => $id]);
    }

    public static function empty()
    {
        global $wpdb;
        return $wpdb->query("TRUNCATE table " .$wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE .";");
    }
}