# Logging Integration Example

This example demonstrates how to integrate PSR-3 compatible logging with the Promptchan SDK.

## Basic Logging Setup

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;

// Create a logger that outputs to the console
$logger = new Logger('promptchan');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

// Initialize client with logger
$client = new PromptchanClient('your-api-key-here', $logger);

// Make a request - all HTTP activity will be logged
$request = new CreateImageRequest(
    prompt: 'A beautiful sunset over mountains'
);

$response = $client->image()->create($request);
echo "Gems used: {$response->gems}\n";
echo "Image data length: " . strlen($response->image) . " bytes\n";
```

## File Logging

```php
use Monolog\Formatter\LineFormatter;

// Create logger that writes to file
$logger = new Logger('promptchan');

// Add file handler with custom format
$fileHandler = new StreamHandler(__DIR__ . '/logs/promptchan.log', Logger::INFO);
$formatter = new LineFormatter(
    "[%datetime%] %channel%.%level_name%: %message% %context%\n",
    'Y-m-d H:i:s'
);
$fileHandler->setFormatter($formatter);
$logger->pushHandler($fileHandler);

$client = new PromptchanClient('your-api-key-here', $logger);
```

## Rotating Log Files

```php
// Create rotating file handler (daily rotation, keep 30 days)
$logger = new Logger('promptchan');
$rotatingHandler = new RotatingFileHandler(
    __DIR__ . '/logs/promptchan.log',
    30, // Keep 30 days
    Logger::DEBUG
);
$logger->pushHandler($rotatingHandler);

$client = new PromptchanClient('your-api-key-here', $logger);
```

## Multiple Log Handlers

```php
// Log to both console and file with different levels
$logger = new Logger('promptchan');

// Console handler - only errors and above
$consoleHandler = new StreamHandler('php://stdout', Logger::ERROR);
$logger->pushHandler($consoleHandler);

// File handler - all debug info
$fileHandler = new StreamHandler(__DIR__ . '/logs/debug.log', Logger::DEBUG);
$logger->pushHandler($fileHandler);

// Separate file for errors only
$errorHandler = new StreamHandler(__DIR__ . '/logs/errors.log', Logger::ERROR);
$logger->pushHandler($errorHandler);

$client = new PromptchanClient('your-api-key-here', $logger);
```

## Custom Log Formatting

```php
use Monolog\Formatter\JsonFormatter;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\MemoryUsageProcessor;

$logger = new Logger('promptchan');

// JSON formatter for structured logging
$jsonHandler = new StreamHandler(__DIR__ . '/logs/structured.log', Logger::INFO);
$jsonHandler->setFormatter(new JsonFormatter());

// Add processors for additional context
$logger->pushProcessor(new WebProcessor());
$logger->pushProcessor(new MemoryUsageProcessor());

$logger->pushHandler($jsonHandler);

$client = new PromptchanClient('your-api-key-here', $logger);
```

## What Gets Logged

The SDK logs the following information:

### Request Logging
- HTTP method and URL
- Request headers (API key is masked)
- Request body (when applicable)
- Request timestamp

### Response Logging
- HTTP status code
- Response headers
- Response body
- Response time
- Response timestamp

### Error Logging
- HTTP errors (4xx, 5xx status codes)
- Network errors
- Parsing errors
- Exception details

## Log Levels Used

- **DEBUG**: Detailed request/response information
- **INFO**: General API calls and successful operations
- **WARNING**: Recoverable errors or unusual conditions
- **ERROR**: HTTP errors and exceptions
- **CRITICAL**: Severe errors that might affect application

## Example Log Output

```
[2024-01-15 10:30:15] promptchan.INFO: Making POST request to https://api.promptchan.ai/v1/image/create
[2024-01-15 10:30:15] promptchan.DEBUG: Request headers: {"Content-Type":"application/json","Authorization":"Bearer ***"}
[2024-01-15 10:30:15] promptchan.DEBUG: Request body: {"prompt":"A beautiful sunset over mountains","style":"anime"}
[2024-01-15 10:30:16] promptchan.INFO: Received response with status 200 in 1.2s
[2024-01-15 10:30:16] promptchan.DEBUG: Response body: {"image":"iVBORw0KGgoAAAANSUhEUgAA...","gems":5}
```

## Complete Example with Error Handling

```php
try {
    // Setup logger
    $logger = new Logger('promptchan');
    $logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
    $logger->pushHandler(new StreamHandler(__DIR__ . '/logs/api.log', Logger::DEBUG));
    
    // Initialize client
    $client = new PromptchanClient('your-api-key-here', $logger);
    
    // Image generation request
    $imageRequest = new CreateImageRequest(
        prompt: 'A cyberpunk cityscape at night',
        style: 'realistic',
        quality: 'high'
    );
    
    $logger->info('Starting image generation request');
    $imageResponse = $client->image()->create($imageRequest);
    $logger->info('Image generated successfully', [
        'gems_used' => $imageResponse->gems,
        'image_size' => strlen($imageResponse->image)
    ]);
    
    // Chat request
    $chatRequest = new \Chudno\Promptchan\DataTransferObjects\ChatRequest(
        message: 'Hello, how are you?'
    );
    
    $logger->info('Starting chat request');
    $chatResponse = $client->chat()->sendMessage($chatRequest);
    $logger->info('Chat response received', [
        'reply_length' => strlen($chatResponse->reply),
        'character' => $chatResponse->character
    ]);
    
} catch (\Exception $e) {
    $logger->error('API request failed', [
        'error' => $e->getMessage(),
        'status_code' => $client->getLastStatusCode(),
        'trace' => $e->getTraceAsString()
    ]);
    
    echo "Error: {$e->getMessage()}\n";
}
```

## Custom Logger Implementation

You can also implement your own PSR-3 compatible logger:

```php
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class CustomLogger extends AbstractLogger
{
    public function log($level, $message, array $context = []): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = empty($context) ? '' : ' ' . json_encode($context);
        
        echo "[{$timestamp}] {$level}: {$message}{$contextStr}\n";
        
        // You could also send to external services:
        // - Elasticsearch
        // - Sentry
        // - CloudWatch
        // - Custom API endpoints
    }
}

$customLogger = new CustomLogger();
$client = new PromptchanClient('your-api-key-here', $customLogger);
```

## Integration with Laravel

```php
// In a Laravel service provider or controller
use Illuminate\Support\Facades\Log;

$client = new PromptchanClient(
    config('services.promptchan.api_key'),
    Log::channel('promptchan')
);
```

## Integration with Symfony

```php
// In Symfony with dependency injection
use Psr\Log\LoggerInterface;

class PromptchanService
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly string $apiKey
    ) {}
    
    public function getClient(): PromptchanClient
    {
        return new PromptchanClient($this->apiKey, $this->logger);
    }
}
```

## Performance Considerations

1. **Log Level**: Use appropriate log levels in production (INFO or higher)
2. **Async Logging**: Consider async handlers for high-traffic applications
3. **Log Rotation**: Implement log rotation to manage disk space
4. **Sensitive Data**: The SDK automatically masks API keys in logs

## Security Notes

- API keys are automatically masked in log output as `***`
- Be careful not to log sensitive user data
- Consider encrypting log files in production
- Implement proper log access controls