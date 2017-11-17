# php-selenium-server
[![Build Status](https://travis-ci.org/hayatravis/php-selenium-server.svg?branch=master)](https://travis-ci.org/hayatravis/php-selenium-server)
[![Coverage Status](https://coveralls.io/repos/github/hayatravis/php-selenium-server/badge.svg?branch=master)](https://coveralls.io/github/hayatravis/php-selenium-server?branch=master)
[![Total Downloads](https://poser.pugx.org/hayatravis/php-selenium-server/downloads)](https://packagist.org/packages/hayatravis/php-selenium-server)
[![License](https://poser.pugx.org/hayatravis/php-selenium-server/license)](https://packagist.org/packages/hayatravis/php-selenium-server)
[![composer.lock](https://poser.pugx.org/hayatravis/php-selenium-server/composerlock)](https://packagist.org/packages/hayatravis/php-selenium-server)


## Usage
```php
<?php
require_once './vendor/autoload.php';

$client = new \Hayatravis\Pss\PhpSeleniumServer();

// Start selenium-server-standalone.
$client->startSeleniumServer();

/*
 * Program using Facebook \ WebDriver \ Remote \ RemoteWebDriver etc...
 *
 */

// Get selenium-server-standalone process ID.
$client->getPid();

// Confirm that selenium-server-standalone is stopped.
$client->isStopSeleniumServer();

// Stop selenium-server-standalone.
$client->stopSeleniumServer();
```