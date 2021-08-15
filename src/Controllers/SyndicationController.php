<?php

namespace BiwyzeTourinsoft\Controllers;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class SyndicationController
{
    public static function index()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ARRAY_A);

        return $results;
    }

    public static function show(WP_REST_Request $request)
    {}

    public static function store($request)
    {
            $params = $request->get_param('syndication');
            $params = json_decode(json_encode($params), true);

            global $wpdb;

            $wpdb->insert($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, array_merge($params, [
                'created_at' => date('Y-m-d H:i:s')
            ]));

            $id = $wpdb->insert_id;

            return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');
    }

    public static function update(WP_REST_Request $request)
    {}

    public static function delete(WP_REST_Request $request)
    {}
}