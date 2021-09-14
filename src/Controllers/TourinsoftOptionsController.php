<?php

namespace BiwyzeTourinsoft\Controllers;

use BiwyzeTourinsoft\Repositories\OptionsRepository;

class TourinsoftOptionsController extends \WP_REST_Controller
{
    public static function list(\WP_REST_Request $request): \WP_REST_Response
    {
        return new \WP_REST_Response(OptionsRepository::allOptions(), 200);
    }

    public static function register(\WP_REST_Request $request): \WP_REST_Response
    {

    }
}