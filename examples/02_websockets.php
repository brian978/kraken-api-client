<?php

use KrakenApi\ClientBuilder;
use KrakenApi\Query\Exception\ResponseException;
use KrakenApi\Query\Websockets\TokenQuery;

require_once 'vendor/autoload.php';

/**
 * The file structure MUST be
 *
 * <?php
 *
 * return [
 *     '<your_key>', // KEY
 *     '<your_secret>' // SECRET
 * ];
 */
list($key, $secret) = require __DIR__ . '/config.php';

// Create the client
$clientBuilder = new ClientBuilder();
$clientBuilder
    ->setApiKey($key)
    ->setApiSecret($secret);

$krakenClient = $clientBuilder->build();

// Query the API
$query = new TokenQuery($krakenClient);

// Usage
try {
    print_r($query->execute());
} catch (ResponseException $e) {
    // Handle errors
    print_r($e->getErrors());
}
