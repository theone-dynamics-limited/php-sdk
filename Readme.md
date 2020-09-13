![Logdo](.github/logo.png?raw=true)

# Logdo, php SDK

Logdo is a self hosted application logging server that brings back the fun in reading logs.

- Simple interface for viewing logs
- App based logging setup
- Members can join teams and have access to teams' apps logs.
- Clean APIs and SDKs...

... and many more ....

```php
<?php
require('vendor/autoload.php');

use Logdo\Logdo;

$appId = "---YOUR APP ID HERE---";
$apiToken = "---YOUR API KEY HERE---";

$logdo = Logdo::createInstance($apiToken, $appId)
    ->log('Some log')
    ->to('http://logdo.test')
    ->as(Logdo::INFO);

if (!$logdo->wasSuccessful()) {
    // Do some failure handling
    die($logdo->getErrorMessage());
}

// Do some success handling
echo "Successfuly logged!";
```

## Help and docs

We use GitHub issues only to discuss bugs and new features. For support please refer to:

- [Documentation](http://logdo.dev/docs)


## Installing Logdo php SDK

The recommended way to install the SDK through
[Composer](https://getcomposer.org/). Note that the SDK requires 
```php
"php":">=7.2",
"guzzlehttp/guzzle": "^7.0"
```

Seriously, because why not? php 5.6 is so 2016. I was't even writing php back then!

```bash
composer require logdo/logdo-php
```

## Contributing

Contributions are welcome in any form.

