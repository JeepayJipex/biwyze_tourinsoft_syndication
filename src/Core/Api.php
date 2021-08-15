<?php

namespace BiwyzeTourinsoft\Core;

use BiwyzeTourinsoft\Controllers\SyndicationController;

class Api
{
    public function registerRestRoutes() {
        add_action('rest_api_init', function () {
            register_rest_route('tourinsoft/v1', '/syndication', [
                [
                    'methods' => ['POST'],
                    'callback' => [SyndicationController::class, 'store'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ],
                [
                    'methods' => ['GET'],
                    'callback' => [SyndicationController::class, 'index']
                ],
            ]);

            register_rest_route('tourinsoft/v1', "/syndication/(?P<id>\d+)", [
                [
                    'methods' => ['PUT'],
                    "args" => [
                        "id" => [
                            'required' => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return is_numeric($param);
                            }]
                    ],
                    'callback' => [SyndicationController::class, 'update'],
                    'permission_callback' => function ($request) {
                        return current_user_can( 'manage_options' );
                    }
                ],
                [
                    'methods' => ['DELETE'],
                    "args" => [
                        "id" => [
                            'required' => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return is_numeric($param);
                            }]
                    ],
                    'callback' => [SyndicationController::class, 'delete'],
                    'permission_callback' => function ($request) {
                        return current_user_can( 'manage_options' );
                    }
                ],
                [
                    'methods' => ['GET'],
                    "args" => [
                        "id" => [
                            'required' => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return is_numeric($param);
                            }]
                    ],
                    'callback' => [SyndicationController::class, 'show']
                ],
            ]);
        });
    }
}