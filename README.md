# Whois Client PHP Library
[![Source Code](https://img.shields.io/static/v1?label=source&message=mallardduck/php-whois-client&color=blue&style=for-the-badge)](https://packagist.org/packages/mallardduck/whois-client)
[![License](https://img.shields.io/packagist/l/mallardduck/whois-client?style=for-the-badge)](https://packagist.org/packages/mallardduck/whois-client)
[![PHP Version](https://img.shields.io/packagist/php-v/mallardduck/whois-client.svg?style=for-the-badge)](https://packagist.org/packages/mallardduck/whois-client)
[![Latest Stable Version](https://img.shields.io/packagist/v/mallardduck/whois-client?logo=packagist&label=Release&style=for-the-badge)](https://packagist.org/packages/mallardduck/whois-client)
[![Total Download Count](https://img.shields.io/packagist/dt/mallardduck/whois-client?logo=packagist&style=for-the-badge)](https://packagist.org/packages/mallardduck/whois-client/stats)
[![Travis Build Status](https://img.shields.io/travis/mallardduck/php-whois-client?logo=travis&style=for-the-badge)](https://travis-ci.org/mallardduck/php-whois-client)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/quality/g/mallardduck/php-whois-client?logo=scrutinizer&style=for-the-badge)](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/mallardduck/php-whois-client?logo=scrutinizer&style=for-the-badge)](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/?branch=master)
[![Coverage Status](https://img.shields.io/coveralls/github/mallardduck/php-whois-client?logo=coveralls&style=for-the-badge)](https://coveralls.io/github/mallardduck/php-whois-client?branch=master)

## A message to Russian 🇷🇺 people

If you currently live in Russia, please read [this message](./ToRussianPeople.md).

## Purpose

When you need to work with Whois lookups in PHP this library provides a very basic client!

Rather than focus on the user-friendly output this library focuses on the raw Whois protocol. The library is limited in
function since its intended to be a low-level client that handles only request and raw output. Basically the package
supports the look-up of a TLDs primary Whois server and then will do a query of the domain provided.

## Requirements
* PHP >= 8.0

### Past PHP version support
| PHP | Package |
|-----|---------|
| 8.0 | Current |
| 7.4 | 2.0.7   |
| 7.3 | 1.2.1   |


## Features
* Pure PHP based Whois client.
* Simple API for getting raw Whois results in PHP.
* Unicode IDN and punycode support.

## Installation
The best installation method is to simply use composer.

https://packagist.org/packages/mallardduck/whois-client

### Stable version

```bash
composer require mallardduck/whois-client
```

## Example usage

```php
require __DIR__ . '/vendor/autoload.php';

use MallardDuck\Whois\Client;

$client = new Client('whois.nic.me');
$response = $client->makeRequest('danpock.me');
echo $response;
```

## License

Whois Client PHP Library is open source software licensed under the [GPLv3 license](LICENSE).
