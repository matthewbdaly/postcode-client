<?php

namespace Matthewbdaly\Postcode\Contracts;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\MessageFactory;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;
use Matthewbdaly\Postcode\Exceptions\PaymentRequired;
use Matthewbdaly\Postcode\Exceptions\PostcodeNotFound;

/**
 * Postcode client
 */
interface Client
{
    /**
     * Get base URL
     *
     * @return string
     */
    public function getBaseUrl();

    /**
     * Get API key
     *
     * @return string
     */
    public function getKey();

    /**
     * Set API key
     *
     * @param string $key The API key.
     * @return Client
     */
    public function setKey(string $key);

    /**
     * Make the HTTP request
     *
     * @param string $postcode The postcode to look up.
     * @return mixed
     * @throws PaymentRequired Payment required to perform the lookup.
     * @throws PostcodeNotFound Postcode not found.
     */
    public function get(string $postcode);
}
