<?php

namespace BiwyzeTourinsoft\Core;

use BiwyzeTourinsoft\Controllers\SyncSyndicationController;
use BiwyzeTourinsoft\Controllers\SyndicationController;
use BiwyzeTourinsoft\Controllers\TourinsoftOptionsController;

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
                    'permission_callback' => function ($request) {return true;},
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
                    'permission_callback' => function ($request) {return true;},
                    'callback' => [SyndicationController::class, 'show']
                ],
            ]);

            register_rest_route('tourinsoft/v1', '/updater', [
                [
                    'methods' => ['POST'],
                    'callback' => [SyncSyndicationController::class, 'updateAll'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ]
            ]);
            register_rest_route('tourinsoft/v1', '/updater/(?P<id>\d+)', [
                [
                    'methods' => ['POST'],
                    'callback' => [SyncSyndicationController::class, 'updateOne'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ]
            ]);

            register_rest_route('tourinsoft/v1', '/options', [
                [
                    'methods' => ['GET'],
                    'callback' => [TourinsoftOptionsController::class, 'list'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ]
            ]);

            register_rest_route('tourinsoft/v1', '/options', [
                [
                    'methods' => ['POST'],
                    'callback' => [TourinsoftOptionsController::class, 'register'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ]
            ]);

            register_rest_route('tourinsoft/v1', '/export', [
                [
                    'methods' => ['GET'],
                    'callback' => [TourinsoftOptionsController::class, 'generateExport'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ]
            ]);

            register_rest_route('tourinsoft/v1', '/import', [
                [
                    'methods' => ['POST'],
                    'callback' => [TourinsoftOptionsController::class, 'importData'],
                    'permission_callback' => function () {
                        return current_user_can( 'manage_options' );
                    }
                ]
            ]);
        });

    }
}