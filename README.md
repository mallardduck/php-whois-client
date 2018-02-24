Whois Client PHP Library
=========================
[![Travis Build Status](https://travis-ci.org/mallardduck/whois-client.svg?branch=master)](https://travis-ci.org/mallardduck/whois-client)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/mallardduck/whois-client.svg)](https://scrutinizer-ci.com/g/mallardduck/whois-client/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mallardduck/whois-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mallardduck/whois-client/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mallardduck/whois-client/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Latest Stable Version](https://poser.pugx.org/mallardduck/whois-client/v/stable)](https://packagist.org/packages/mallardduck/whois-client)
[![License](https://poser.pugx.org/mallardduck/whois-client/license)](https://packagist.org/packages/mallardduck/whois-client)

If you are working with Whois in PHP this library provides a very basic client.

Rather than focus on the user friendly output this library focuses on the raw Whois protocol. The library is limited in function since it's intended to be a low-level client that handles only request and raw output. Basically the package supports the look up of a TLDs primary Whois server and then will do a query of the domain provided.

Requirements
============
* PHP >= 5.6

Installation
============
* Pure PHP based Whois client.
* Simple API for getting raw Whois results in PHP.

Installation
============
The best installation method is to simply use composer.

#### Stable version

`composer require mallardduck/whois-client`

#### Latest development version

`composer require "mallardduck/whois-client":"dev-master"`

Example usage
=====

```php
require 'vendor/autoload.php';

use MallardDuck\Whois\Client;

$client = new Client;
$results = $client->lookup('google.com');
```

License
=====
Whois Client PHP Library is open source software licensed under the [GPLv3 license](LICENSE).
