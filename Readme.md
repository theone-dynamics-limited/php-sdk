
![Logdo](.github/logo.png?raw=true)
# Logdo, PHP SDK ![Tests](https://github.com/logdo/php-sdk/actions/workflows/php_versions_compatibilty_and_tests.yml/badge.svg)
LogDo: You production logs, exactly like you are used to them on your local 🥳

- Simple interface for viewing logs
- App based logging setup
- Members can join teams and have access to teams' apps logs.
- Clean APIs and SDKs...

... and many more ....

```php
require_once __DIR__ . '/../vendor/autoload.php';
use LogdoPhp\Logdo;
$logdo = Logdo::instance()
    ->logger()
    ->for(app_id: "app_id")
    ->log(log: "hello world")
    ->at(incident_datetime: "2023-01-31 12:07:56")
    ->as(environment: "local")
    ->with(stack_trace: "stack trace")
    ->level(log_level: "info")
    ->go();
```

## Tests

To run tests in this sdk, run
```bash
composer run tests
```
## Help and docs

We use GitHub issues only to discuss bugs and new features. You can also RTFML [here | documentation.](http://logdo.theonehq.com/docs)


## Installing Logdo php SDK

The recommended way to install the SDK through [Composer](https://getcomposer.org/).
```bash
composer require logdo/logdo-php
```

## Contributing

Contributions are welcome in any form.

## Bug and Security Report

Report and bugs and security issue to `theguys@theoneapp.rocks`