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

$appId = "2f725873e5415ce874dceddfe50a70f5";
$apiToken = "lpdXmbkBwU3EJsELdWvUP8Lg16Vqs0aYE2B10vZf";

$logdo = Logdo::createInstance($apiToken, $appId)
    ->log('Some second log')
    ->to('http://logdo.test')
    ->as(Logdo::INFO);

if (!$logdo->wasSuccessful()) {
    // Do something
    die($logdo->getErrorMessage());
}

echo "\nSuccessfuly logged!\n";
```

## Help and docs

We use GitHub issues only to discuss bugs and new features. For support please refer to:

- [Documentation](http://logdo.dev/docs)


## Installing Logdo php SDK

The recommended way to install Guzzle is through
[Composer](https://getcomposer.org/).

```bash
composer require logdo/logdo-php
```

## Contributing

Contributions are welcome in any form.

