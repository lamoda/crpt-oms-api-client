Lamoda CRPT OMS Api Client
==========================

[![Build Status](https://travis-ci.org/lamoda/crpt-oms-api-client.svg?branch=master)](https://travis-ci.org/lamoda/crpt-oms-api-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lamoda/crpt-oms-api-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lamoda/crpt-oms-api-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/lamoda/crpt-oms-api-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/lamoda/crpt-oms-api-client/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/lamoda/crpt-oms-api-client/badges/build.png?b=master)](https://scrutinizer-ci.com/g/lamoda/crpt-oms-api-client/build-status/master)

## Installation

### Composer

```sh
composer require lamoda/crpt-oms-api-client
```

## Description

This library implements API client for the Order Management Station (OMS) of the CRPT (https://crpt.ru/)

Library implements V2 version of OMS Api's

Currently this client implements just a subset of the OMS Api methods.

## Usage

```php
<?php

use GuzzleHttp\Client;
use Lamoda\OmsClient\Impl\Serializer\SymfonySerializerAdapterFactory;
use Lamoda\OmsClient\V2\OmsApi;

$client = new Client([
    // Uri to your OMS
    'base_uri' => 'http://oms_uri',
    'timeout'  => 2.0,
]);

$serializer = SymfonySerializerAdapterFactory::create();

$omsApi = new OmsApi($client, $serializer);

/*
 * Call all required methods of API
 */
// $response = $omsApi->getICBufferStatus();
```

## Signing of OMS requests

It is also possible to send signed OMS requests for orders.

To do that implement `\Lamoda\OmsClient\V2\Signer\SignerInterface`. 

Signer must return signature for the given data (no data itself transformation is required).
