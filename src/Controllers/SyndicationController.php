<?php

namespace BiwyzeTourinsoft\Controllers;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Handlers\SyndicationReader;
use BiwyzeTourinsoft\Repositories\SyndicationRepository;

class SyndicationController extends \WP_REST_Controller
{
    public static function index()
    {
        try {
            return SyndicationRepository::all();
        } catch (\Exception $exception) {
            return self::handleError($exception->getMessage());
        }
    }

    public static function show(\WP_REST_Request $request)
    {
        try {
            $id = $request->get_param('id');
            $syndication = SyndicationRepository::get($id);
            $reader = (new SyndicationReader($syndication->syndic_id, $syndication->name));

            return [
                'syndication' => $syndication,
                'content' => json_encode($reader->getRawData()),
                'offers' => [
                    'raw' => $reader->getOffers(),
                    'parsed' => $reader->getParsedOffers()
                ]
                          ];
        } catch (\Exception $exception) {
            return self::handleError($exception->getMessage());
        }
    }

    public static function store(\WP_REST_Request $request)
    {

        try {
            $params = $request->get_param('syndication');
            $params = json_decode(json_encode($params), true);

            if(!(new SyndicationReader($params['syndic_id'], $params['name']))->readSyndicData()) {
             throw new \Exception('impossible to read this syndication');
            }

            return SyndicationRepository::store($params);
        } catch (\Exception $e) {
            return self::handleError($e->getMessage());
        }

    }

    public static function update(\WP_REST_Request $request)
    {
        try {
            $params = $request->get_param('syndication');
            $params = json_decode(json_encode($params), true);
            return SyndicationRepository::update($request->get_param('id'), $params);
        } catch (\Exception $e) {
            return self::handleError($e->getMessage());
        }
    }

    public static function delete(\WP_REST_Request $request)
    {
        try {
            return ["success" => SyndicationRepository::delete($request->get_param('id'))];
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