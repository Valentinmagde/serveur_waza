<?php

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

trait ConsumeExternalService
{
    /**
     * Send request to any service
     * @param $method
     * @param $requestUrl
     * @param array $formParams
     * @param array $headers
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = [])
    {
        $client = new Client([
            'base_uri'  =>  $this->baseUri,
        ]);

        if(isset($this->secret))
        {
            $headers['Authorization'] = $this->secret;
        }
        
        $response = $client->request($method, $requestUrl, [
            'debug' => fopen('php://stderr', 'w'),
            'json' => $formParams,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'Authorization' => $headers['Authorization'],
            ]
        ]);
        
        return $response->getBody()->getContents();
    }
}