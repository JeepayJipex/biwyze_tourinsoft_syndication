<?php

namespace BiwyzeTourinsoft\Handlers;

use BiwyzeTourinsoft\BiwyzeTourinsoftSyndication;
use BiwyzeTourinsoft\Helpers;

class SyndicationReader
{

    /**
     * @var string
     */
    private $id;

    private $cdt;

    private $version;

    private $url_suffix = 'Objects?$format=json';
    /**
     * @var string
     */
    private $syndicationName;

    private $versionCorrespondances = [
        '3.0' => 'value',
        '1.0' => 'd'
    ];
    /**
     * @var mixed
     */
    private $data;

    public function __construct(string $id, string $syndicationName)
    {
        $this->id = $id;
        $this->cdt = get_option(BiwyzeTourinsoftSyndication::CDT_OPTION, 'cdt31');
        $this->version = get_option(BiwyzeTourinsoftSyndication::TOURINSOFT_API_VERSION_OPTION, '3.0');
        $this->syndicationName = $syndicationName;
    }

    public function readSyndicData () {
        $this->data = $this->getJsonContent();
        set_transient('syndic_data_' . esc_sql($this->id) . '_' . esc_sql($this->syndicationName), $this->data, 0);
        return $this->data;
    }

    public function getOffers() {
        $data = get_transient('syndic_data_' . esc_sql($this->id) . '_' . esc_sql($this->syndicationName)) ?? $this->readSyndicData();
        return $data[$this->versionCorrespondances[$this->version] ?? 'd'];
    }

    private function getJsonContent() {
        $json = Helpers::file_get_contents_curl($this->buildSyndicUrl());
        return json_decode($json, true);
    }

    private function buildSyndicUrl() {
        return BiwyzeTourinsoftSyndication::TOURINSOFT_URL . "/Syndication/$this->version/$this->cdt/$this->id/" . $this->url_suffix;
    }

}