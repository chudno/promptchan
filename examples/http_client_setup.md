# HTTP Client Setup

This example demonstrates how to configure different HTTP clients with the Promptchan SDK.

## Auto-Discovery (Recommended)

The SDK uses PSR-18 HTTP Client Discovery to automatically find and use any compatible HTTP client in your project:

```php
<?php

use Chudno\Promptchan\PromptchanClient;

// Simple initialization - auto-discovers HTTP client
$client = new PromptchanClient('your-api-key');
```

## Custom HTTP Client Configuration

### With Guzzle HTTP

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use GuzzleHttp\Client;
use Monolog\Logger;

$httpClient = new Client(['timeout' => 30]);
$logger = new Logger('promptchan');

$client = new PromptchanClient(
    apiKey: 'your-api-key',
    httpClient: $httpClient,
    logger: $logger
);
```

### Full Constructor Control

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Monolog\Logger;

$httpClient = new Client(['timeout' => 30]);
$requestFactory = new HttpFactory();
$streamFactory = new HttpFactory();
$logger = new Logger('promptchan');

$client = new PromptchanClient(
    apiKey: 'your-api-key',
    httpClient: $httpClient,
    requestFactory: $requestFactory,
    streamFactory: $streamFactory,
    logger: $logger,
    baseUri: 'https://api.promptchan.ai'
);
```

## Supported HTTP Clients

Any PSR-18 compatible HTTP client:
- **Guzzle HTTP** (`guzzlehttp/guzzle`)
- **Symfony HttpClient** (`symfony/http-client`)
- **ReactPHP HTTP Client** (`react/http`)
- **Buzz** (`kriswallsmith/buzz`)
- **cURL** (`php-http/curl-client`)

### Installation Commands

```bash
# For Guzzle (Recommended)
composer require guzzlehttp/guzzle

# For Symfony HttpClient
composer require symfony/http-client nyholm/psr7

# For ReactPHP
composer require react/http

# For Buzz
composer require kriswallsmith/buzz

# For cURL
composer require php-http/curl-client
```

## Advanced Guzzle Configuration

### With Retry Middleware

```php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Chudno\Promptchan\PromptchanClient;

$stack = HandlerStack::create();

// Add retry middleware
$stack->push(Middleware::retry(
    function ($retries, Request $request, Response $response = null, RequestException $exception = null) {
        // Retry on connection errors or 5xx responses
        if ($retries < 3) {
            if ($exception instanceof ConnectException) {
                return true;
            }
            if ($response && $response->getStatusCode() >= 500) {
                return true;
            }
        }
        return false;
    },
    function ($retries) {
        return $retries * 1000; // Delay in milliseconds
    }
));

$httpClient = new Client([
    'handler' => $stack,
    'timeout' => 30,
    'connect_timeout' => 10,
]);

$client = new PromptchanClient('your-api-key', $httpClient);
```

### With Custom Headers

```php
<?php

use GuzzleHttp\Client;
use Chudno\Promptchan\PromptchanClient;

$httpClient = new Client([
    'timeout' => 30,
    'headers' => [
        'User-Agent' => 'MyApp/1.0',
        'Accept' => 'application/json',
    ],
]);

$client = new PromptchanClient('your-api-key', $httpClient);
```

## Symfony HttpClient Example

```php
<?php

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;
use Chudno\Promptchan\PromptchanClient;

$httpClient = new Psr18Client(
    HttpClient::create([
        'timeout' => 30,
        'max_redirects' => 3,
    ])
);

$client = new PromptchanClient('your-api-key', $httpClient);
```

## ReactPHP Example

```php
<?php

use React\Http\Browser;
use React\Socket\Connector;
use Chudno\Promptchan\PromptchanClient;

$connector = new Connector([
    'timeout' => 30,
]);

$httpClient = new Browser($connector);

$client = new PromptchanClient('your-api-key', $httpClient);
```

## Tips

- Use Guzzle for most applications as it's the most feature-complete
- Symfony HttpClient is great for Symfony applications
- ReactPHP is ideal for async/event-driven applications
- Always set appropriate timeouts for your use case
- Consider adding retry logic for production applications