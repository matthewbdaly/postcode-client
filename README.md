# postcode-client

[![Build Status](https://travis-ci.org/matthewbdaly/postcode-client.svg?branch=master)](https://travis-ci.org/matthewbdaly/postcode-client)

Postcode lookup client. Uses [Ideal Postcodes](https://ideal-postcodes.co.uk/) to look up UK postcodes. You will need to obtain an API key in order to use it.

Installation
------------

```
composer require matthewbdaly/postcode-client
```

This library uses [HTTPlug](http://docs.php-http.org/en/latest/httplug/introduction.html) for making HTTP requests, therefore you will also need to install [a client or adapter](http://docs.php-http.org/en/latest/clients.html).

Usage
-----

```
<?php

require 'vendor/autoload.php';

use Matthewbdaly\Postcode\Client;

$client = new Client();
$response = $client->setKey('<MY_API_KEY>')
    ->get('ID1 1QD');
```
