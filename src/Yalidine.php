<?php
namespace Sebbahnouri\Yalidine;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class Yalidine
{
    private string $url = "https://api.yalidine.com/v1/";
    private string $apiId;
    private string $apiToken;
    private Client $client;

    public function __construct()
    {
        $this->apiId = config('Yale-config.api_id');
        $this->apiToken = config('Yale-config.api_token');

        $this->client = new Client([
            'base_uri' => $this->url,
            'headers' => [
                'X-API-ID' => $this->apiId,
                'X-API-TOKEN' => $this->apiToken,
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     * Perform a HTTP request to Yalidine API
     *
     * @param string $method HTTP method (GET, POST, DELETE, etc.)
     * @param string $endpoint API endpoint path
     * @param array $options Request options (query, json payload, etc.)
     * @return array|null Response data as an associative array or null on failure
    */
    private function request(string $method, string $endpoint, array $options = []): ?array
    {
        try {
            if (isset($options['json'])) {
                $options['json'] = json_encode($options['json']);
            }

            $response = $this->client->request($method, $endpoint, $options);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    /**
     * Retrieve parcels based on tracking numbers
     *
     * @param array $trackings List of tracking numbers
     * @return array|null Response data from API
     */
    public function retrieveParcels(array $trackings = []): ?array
    {
        $options = $trackings ? ['query' => ['tracking' => implode(',', $trackings)]] : [];
        return $this->request('GET', 'parcels', $options);
    }

    /**
     * Create new parcels
     *
     * @param array $parcels List of parcels to create
     * @return array|null Response data from API
     */
    public function createParcels(array $parcels): ?array
    {
        return $this->request('POST', 'parcels', ['json' => $parcels]);
    }

    /**
     * Delete parcels based on tracking numbers
     *
     * @param array $trackings List of tracking numbers
     * @return array|null Response data from API
     */
    public function deleteParcels(array $trackings): ?array
    {
        $options = $trackings ? ['query' => ['tracking' => implode(',', $trackings)]] : [];
        return $this->request('DELETE', 'parcels', $options);
    }

    /**
     * Retrieve delivery fees based on wilaya IDs
     *
     * @param array $wilayaIds List of wilaya IDs
     * @return array|null Response data from API
     */
    public function retrieveDeliveryfees(array $wilayaIds = []): ?array
    {
        $options = $wilayaIds ? ['query' => ['wilaya_id' => implode(',', $wilayaIds)]] : [];
        return $this->request('GET', 'deliveryfees', $options);
    }

    /**
     * Retrieve archived parcels based on status
     *
     * @param string|null $status Status of parcels to retrieve
     * @return array|null Response data from API
     */
    public function retrieveHistoryParcels(?string $status): ?array
    {
        $options = $status ? ['query' => ['status' => $status]] : [];
        return $this->request('GET', 'histories', $options);
    }
}