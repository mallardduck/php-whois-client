Whois Client PHP Library
=========================
[![Travis Build Status](https://travis-ci.org/mallardduck/whois-client.svg?branch=master)](https://travis-ci.org/mallardduck/whois-client)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/mallardduck/whois-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/mallardduck/whois-client/?branch=master)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/filp/whoops.svg?style=flat-square)]()
[![Scrutinizer Build](https://img.shields.io/scrutinizer/build/g/mallardduck/whois-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/mallardduck/whois-client/)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mallardduck/whois-client/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

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

composer require mallardduck/whois-client:dev-master

License
=====
Whois Client PHP Library is open source software licensed under the [GPLv3 license](LICENSE).
