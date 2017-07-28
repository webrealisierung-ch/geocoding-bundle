<?php

/**
 * @copyright 2017 Webrealisierung GmbH
 *
 * @license LGPL-3.0+
 */

namespace Wr\GeocodingBundle\Service;
use Contao\CoreBundle\Monolog\ContaoContext;
use Psr\Log\LoggerInterface;

/**
 * A class to calculate the geo position form a given address, city, place or country over the google geocode api.
 * Requires a active google maps api key
 *
 * @author Daniel Steuri <mail@webrealisierung.ch>
 * @package Wr\GeocodingBundle\Service
 */
class Geocoder
{

    private $logger;

    public $lng;
    public $lat;
    public $coords;

    public $formattedAddress;
    public $placeId;
    public $types;
    public $status;

    public $geocoderResponse;

    /**
     * Geocoder constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger=$logger;
    }

    /**
     * @param $address string
     * @param $country string
     * @param $apiKey string
     * @return bool|mixed|null
     */
    public function calculate($address,$country,$apiKey)
    {
        $apiKey = urlencode($apiKey);
        $address = urlencode($address);
        $country = urlencode($country);

        if (!function_exists('curl_init')) {
            $this->logger->info('Missing PHP Extension CURL', array(
                'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, ContaoContext::GENERAL
                )));
            return false;
        }

        $urlParams = sprintf(
            'https://maps.googleapis.com/maps/api/geocode/json?address=%s+%s&key=%s',
            $address, $country, $apiKey
        );

        $ch = curl_init($urlParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->geocoderResponse=$googleApiGeocodeResponse = json_decode(curl_exec($ch));
        curl_close($ch);
        $this->checkResponseStatus($googleApiGeocodeResponse);
        if ($this->status === "OK" && !empty($this->coords)) {
            return $this->geocoderResponse;
        } else{
            return NULL;
        }
    }

    /**
     * @param $geocoderResponse
     * @return void
     */
    private function checkResponseStatus($geocoderResponse){
        switch ($geocoderResponse->status){
            case "OK":
                $this->lat = $geocoderResponse->results[0]->geometry->location->lat;
                $this->lng = $geocoderResponse->results[0]->geometry->location->lng;
                $this->coords=$this->lat.",".$this->lng;
                $this->formattedAddress=$geocoderResponse->results[0]->formatted_address;
                $this->placeId=$geocoderResponse->results[0]->place_id;
                $this->types=$geocoderResponse->results[0]->types;
                $this->status=$geocoderResponse->status;
                $this->logger->info('The coordinates are correcty calculated with the specified address.', array(
                    'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, ContaoContext::GENERAL
                    )));
                break;
            case "ZERO_RESULTS":
                $this->status=$geocoderResponse->status;
                $this->logger->info('The coordinates could not be calculated with the specified address.', array(
                    'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, ContaoContext::GENERAL
                    )));
                break;
            case "OVER_QUERY_LIMIT":
                $this->status=$geocoderResponse->status;
                $this->logger->info('The API request quota is exhausted.', array(
                    'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL
                    )));
                break;
            case "REQUEST_DENIED":
                $this->status=$geocoderResponse->status;
                $this->logger->info('API key is missing, expired or wrong.', array(
                    'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL
                    )));
                break;
            case "INVALID_REQUEST":
                $this->status=$geocoderResponse->status;
                $this->logger->info('Address, Component or LatLng is missing in the request', array(
                    'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL
                    )));
                break;
            case "UNKNOWN_ERROR":
                $this->status=$geocoderResponse->status;
                $this->logger->info('A unknown error is occurred. Maybe you can try again later', array(
                    'contao' => new ContaoContext(__CLASS__.'::'.__FUNCTION__, TL_GENERAL
                    )));
                break;
        }
    }
}
