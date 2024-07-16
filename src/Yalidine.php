<?php
namespace Sebbahnouri\Yalidine;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Yalidine
{
    private string $url = "https://api.yalidine.com/v1/";
    private string $apiId;
    private string $apiToken;


    public function __construct()
    {
        $this->apiId = config('Yale-config.api_id');
        $this->apiToken = config('Yale-config.api_token');
    }

    /**
     * Retrieve parcels based on tracking numbers
     *
     * @param array $trackings List of tracking numbers
     * @return array|null Response data from API
     */
    public function retrieveParcels(array $trackings = [])
    {
        $options = [];
        if ($trackings) {
            $tracking = implode(',', $trackings);
            $options['query'] = [
                'tracking' => $tracking
            ];
        }

        $response = $this->request('GET', 'parcels', $options);
        //TODO:create a jsonserialize class to represent the response
        return $response;
    }

    /**
     * Create new parcels
     *
     * @param array $parcels List of parcels to create
     * @return array|null Response data from API
     */
    public function createParcels(array $parcels)
    {
        $options = [
            'json' => $parcels
        ];

        $response = $this->request('POST', 'parcels', $options);
        //TODO:create a jsonserialize class to represent the response
        return $response;
    }

    /**
     * Delete parcels based on tracking numbers
     *
     * @param array $trackings List of tracking numbers
     * @return array|null Response data from API
     */
    public function deleteParcels(array $trackings)
    {
        $options = [];
        if ($trackings) {
            $tracking = implode(',', $trackings);
            $options['query'] = [
                'tracking' => $tracking
            ];
        }

        $response = $this->request('DELETE', 'parcels', $options);
        //TODO:create a jsonserialize class to represent the response
        return $response;
    }

    /**
     * Retrieve delivery fees based on wilaya IDs
     *
     * @param array $wilayaIds List of wilaya IDs
     * @return array|null Response data from API
     */
    public function retrieveDeliveryfees(array $wilayaIds = [])
    {
        $options = [];
        if ($wilayaIds) {
            $wilayaIds = implode(',', $wilayaIds);
            $options['query'] = [
                'wilaya_id' => $wilayaIds
            ];
        }

        $response = $this->request('GET', 'deliveryfees', $options);
        //TODO:create a jsonserialize class to represent the response
        return $response;
    }

    /**
     * Retrieve archived parcels based on status
     *
     * @param string|null $status Status of parcels to retrieve
     * @return array|null Response data from API
     */
    public function retrieveHistoryParcels(?string $status) // the param should be an enum of all the status 
    {
        $options = [];
        if ($status) {
            $options['query'] = [
                'status' => $status
            ];
        }

        $response = $this->request('GET', 'histories', $options);
        //TODO:create a jsonserialize class to represent the response
        return $response; 
    }

    /**
     * Initiate a request & return data
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @return mixed
    */
    private function request(string $method, string $endpoint, array $options): ?array
    {
        try {
            $client = new Client([
                'default' => [
                    'headers' => [
                        'X-API-ID' => $this->apiId,
                        'X-API-TOKEN' => $this->apiToken,
                        'Content-Type' => 'application/json'
                    ]
                ]
            ]);
            $url = $this->url . '/' . $endpoint;

            if (isset($options['json'])) {
                $options['json'] = json_encode($options['json']);
            }

            $response = $client->request($method, $url, $options);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return null;
    }
}