<?php
/**
 * Created by PhpStorm.
 * User: shegun
 * Date: 6/13/2019
 * Time: 2:24 PM
 */

namespace ShegunBabs\Remita;


use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpQuery
{

    private $client;
    private $params;

    const REMITA_BASE_URL = 'https://remitademo.net/remita/exapp/api/v1/send/api/';

    private function __construct($merchant_id, $api_key, $api_token)
    {
        $request_id = round(microtime(true) * 1000);
        $apiHash = hash('sha512', $api_key.$request_id.$api_token);
        $authorization = "remitaConsumerKey=$api_key, remitaConsumerToken=$apiHash";

        $this->client = new Client([
            'base_uri' => self::REMITA_BASE_URL,
            'headers' => [
                'MERCHANT_ID' => $merchant_id,
                'API_KEY' => $api_key,
                'REQUEST_ID' => $request_id,
                'REQUEST_TS' => Carbon::now()->toW3cString(),
                'AUTHORIZATION' => $authorization,
                'User-Agent' => 'EasyCreditNg API Server',
            ]
        ]);
    }


    public static function withConfig($merchant_id, $api_key, $request_id)
    {
        return new static($merchant_id, $api_key, $request_id);
    }


    protected function params(array $params)
    {
        $this->params = $params;
        return $this;
    }


    public function post($url): array
    {
        $status = null;
        $response = null;
        $has_data = null;
        $http_status = null;

        try {
            $apiResponse = $this->client->request('POST', $url, [
                'json' => $this->params,
            ]);


            $data = (string) $apiResponse->getBody();
            $response = json_decode($data);
            $status = isset($response->status) === true ? true : false;
            $has_data = $response->hasData;

        } catch (RequestException $exception) {
            $status = false;
            $has_data = false;
            $response = $exception->getMessage();
            $http_status = $exception->getCode();
        }

        return compact('status', 'has_data', 'response', 'http_status');
    }


    public function get($url)
    {
        $response = null;
        $status = null;
        $has_data = null;
        $http_status = null;

        try {

            if (is_null($this->params))
                $response = $this->client->request('GET', $url);
            else
                $response = $this->client->request('GET', $url, [
                    'query' => $this->params
                ]);

            $data = (string) $response->getBody();
            $response = json_decode($data);
            $status = isset($response->status) === true ? true : false;
            $has_data = $response->hasData;
        } catch (RequestException $exception){
            $http_status = $exception->getCode();
            $response = $exception->getMessage();
            $status = false;
            $has_data = false;

        }
        return compact('status', 'has_data', 'response');
    }
}