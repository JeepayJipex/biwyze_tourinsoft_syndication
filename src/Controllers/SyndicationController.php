<?php

namespace BiwyzeTourinsoft\Controllers;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Handlers\SyndicationReader;

class SyndicationController
{
    public static function index()
    {
        try {
            global $wpdb;
            return $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ARRAY_A);
        } catch (\Exception $exception) {
            return self::handleError($exception->getMessage());
        }
    }

    public static function show(\WP_REST_Request $request)
    {
    }

    public static function store(\WP_REST_Request $request)
    {

        try {
            $params = $request->get_param('syndication');
            $params = json_decode(json_encode($params), true);
            global $wpdb;

            $wpdb->insert($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, array_merge($params, [
                'created_at' => date('Y-m-d H:i:s')
            ]));

            (new SyndicationReader($params['syndic_id'], $params['name']))->readSyndicData();

            $id = $wpdb->insert_id;

            return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');
        } catch (\Exception $e) {
            return self::handleError($e->getMessage(), 500);
        }

    }

    public static function update(\WP_REST_Request $request)
    {
        try {
            $params = $request->get_param('syndication');
            $params = json_decode(json_encode($params), true);
            global $wpdb;

            $params['updated_at'] = date('Y-m-d H:i:s');
            $wpdb->update($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, $params, ['id' => $request->get_param('id')]);
            (new SyndicationReader($params['syndic_id'], $params['name']))->readSyndicData();
            return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $request->get_param('id') . ';');
        } catch (\Exception $e) {
            return self::handleError($e->getMessage(), 500);
        }
    }

    public static function delete(\WP_REST_Request $request)
    {
        try {
            global $wpdb;

            $wpdb->delete($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ['id' => $request->get_param('id')]);
            return ["success" => true];
        } catch (\Exception $exception) {
            return self::handleError($exception->getMessage());
        }
    }

    /**
     * @return \WP_Error
     */
    protected static function handleError(string $message, int $status = 500): \WP_Error
    {
        return new \WP_Error('rest custom error', $message, ['status' => $status]);
    }
}