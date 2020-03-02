# Whois Client PHP Library
[![Travis Build Status](https://travis-ci.org/mallardduck/php-whois-client.svg?branch=master)](https://travis-ci.org/mallardduck/php-whois-client)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/mallardduck/php-whois-client.svg)](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mallardduck/php-whois-client/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Latest Stable Version](https://poser.pugx.org/mallardduck/whois-client/v/stable)](https://packagist.org/packages/mallardduck/whois-client)
[![License](https://poser.pugx.org/mallardduck/whois-client/license)](https://packagist.org/packages/mallardduck/whois-client)
[![Coverage Status](https://coveralls.io/repos/github/mallardduck/php-whois-client/badge.svg?branch=master)](https://coveralls.io/github/mallardduck/php-whois-client?branch=master)

If you are working with Whois in PHP this library provides a very basic client.

Rather than focus on the user friendly output this library focuses on the raw Whois protocol. The library is limited in function since it's intended to be a low-level client that handles only request and raw output. Basically the package supports the look up of a TLDs primary Whois server and then will do a query of the domain provided.

Note: The last version to support PHP version 7.0 was tagged as 0.4.0.

## Requirements
* PHP >= 7.1

## Features
* Pure PHP based Whois client.
* Simple API for getting raw Whois results in PHP.
* Unicode IDN and punycode support.

## Installation
The best installation method is to simply use composer.

#### Stable version

`composer require mallardduck/whois-client`

#### Latest development version

`composer require "mallardduck/whois-client":"dev-master"`

### Example usage

```php
require 'vendor/autoload.php';

use MallardDuck\Whois\Client;

$client = new Client;
$results = $client->lookup('google.com');
```

## To-Do
### Before V2
This library will take a more minimalistc direction and a secondary library will provide a more guided experience. So anything in here that complicates the 'problem' of being a RFC 3912 client for PHP will be removed.
- [ ] Rip out anything that's not about being a thin RFC 3912 client.
- [ ] Consider removing IDN/punny support in favor of implementing in secondary library.

## License

Whois Client PHP Library is open source software licensed under the [GPLv3 license](LICENSE).
