<?php

namespace Matthewbdaly\Postcode;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Message\MessageFactory;
use Http\Discovery\MessageFactoryDiscovery;

class Client
{
    protected $baseUrl = 'https://api.ideal-postcodes.co.uk/v1/postcodes/';

    protected $key;

    public function __construct(HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setKey(string $key)
    {
        $this->key = $key;
        return $this;
    }
}
