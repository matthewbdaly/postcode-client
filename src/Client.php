<?php

namespace Matthewbdaly\Postcode;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\MessageFactory;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;
use Matthewbdaly\Postcode\Exceptions\PaymentRequired;
use Matthewbdaly\Postcode\Exceptions\PostcodeNotFound;
use Matthewbdaly\Postcode\Contracts\Client as ClientContract;

/**
 * Postcode client
 */
class Client implements ClientContract
{
    /**
     * Base URL
     *
     * @var $baseUrl
     */
    protected $baseUrl = 'https://api.ideal-postcodes.co.uk/v1/postcodes/';

    /**
     * API key
     *
     * @var $key
     */
    protected $key;

    /**
     * Constructor
     *
     * @param HttpClient     $client         The HTTP client instance.
     * @param MessageFactory $messageFactory The message factory instance.
     * @return void
     */
    public function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * Get base URL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Get API key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set API key
     *
     * @param string $key The API key.
     * @return Client
     */
    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Make the HTTP request
     *
     * @param string $postcode The postcode to look up.
     * @return mixed
     * @throws PaymentRequired Payment required to perform the lookup.
     * @throws PostcodeNotFound Postcode not found.
     */
    public function get(string $postcode)
    {
        $url = $this->getBaseUrl() . rawurlencode($postcode) . '?' . http_build_query([
            'api_key' => $this->getKey()
        ]);
        $request = $this->messageFactory->createRequest(
            'GET',
            $url,
            [],
            null,
            '1.1'
        );
        $response = $this->client->sendRequest($request);
        if ($response->getStatusCode() == 402) {
            throw new PaymentRequired;
        }
        if ($response->getStatusCode() == 404) {
            throw new PostcodeNotFound;
        }
        $data = json_decode($response->getBody()->getContents(), true);
        return $data;
    }
}
