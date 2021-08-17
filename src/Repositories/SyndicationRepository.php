<?php

namespace BiwyzeTourinsoft\Repositories;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;

class SyndicationRepository
{
    public function all()
    {
        global $wpdb;
        return $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ARRAY_A);
    }

    public function get(int $id)
    {
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');
    }

    public function update(int $id, array $data)
    {
        global $wpdb;

        $data['updated_at'] = date('Y-m-d H:i:s');
        $wpdb->update($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, $data, ['id' =>$id]);
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');
    }

    public function store (array $data) {
        global $wpdb;

        $wpdb->insert($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, array_merge($data, [
            'created_at' => date('Y-m-d H:i:s')
        ]));

        $id = $wpdb->insert_id;
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE . ' WHERE id = ' . $id . ';');

    }

    public function delete(int $id)
    {
        global $wpdb;

        return $wpdb->delete($wpdb->prefix . BiwyzeTourinsoftSyndication::SYNDICATIONS_TABLE, ['id' => $id]);
    }
}