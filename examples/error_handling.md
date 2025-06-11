чя# Error Handling

This example demonstrates how to handle errors when using the Promptchan SDK.

## Basic Error Handling

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageStyle;
use Chudno\Promptchan\Enums\ImageQuality;
use Chudno\Promptchan\Exceptions\{ApiException, ValidationException};

$client = new PromptchanClient('your-api-key-here');

$request = new CreateImageRequest(
    prompt: 'Beautiful sunset over mountains',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA
);

try {
    $response = $client->image()->create($request);
    echo "Image created successfully!\n";
    echo "Gems used: {$response->gems}\n";
} catch (ValidationException $e) {
    echo "Invalid request: " . $e->getMessage() . "\n";
    echo "Please check your request parameters.\n";
} catch (ApiException $e) {
    echo "API error: " . $e->getMessage() . "\n";
    echo "HTTP Status: " . $e->getCode() . "\n";
}
```

## Comprehensive Error Handling

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageStyle;
use Chudno\Promptchan\Enums\ImageQuality;
use Chudno\Promptchan\Exceptions\{ApiException, ValidationException};
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Client\RequestExceptionInterface;

$client = new PromptchanClient('your-api-key-here');

$request = new CreateImageRequest(
    prompt: 'Beautiful landscape',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA
);

try {
    $response = $client->image()->create($request);
    
    echo "✅ Image generated successfully!\n";
    echo "Gems used: {$response->gems}\n";
    echo "Image size: " . strlen($response->image) . " characters\n";
    
} catch (ValidationException $e) {
    echo "❌ Validation Error: " . $e->getMessage() . "\n";
    echo "Please check your request parameters:\n";
    echo "- Ensure prompt is not empty\n";
    echo "- Check that style and quality enums are valid\n";
    echo "- Verify optional parameters are within allowed ranges\n";
    
} catch (ApiException $e) {
    $statusCode = $e->getCode();
    
    switch ($statusCode) {
        case 401:
            echo "❌ Authentication Error: Invalid API key\n";
            echo "Please check your API key and ensure it's valid.\n";
            break;
            
        case 402:
            echo "❌ Payment Required: Insufficient gems\n";
            echo "Please top up your account to continue.\n";
            break;
            
        case 429:
            echo "❌ Rate Limit Exceeded\n";
            echo "Please wait before making another request.\n";
            break;
            
        case 500:
        case 502:
        case 503:
            echo "❌ Server Error: " . $e->getMessage() . "\n";
            echo "The service is temporarily unavailable. Please try again later.\n";
            break;
            
        default:
            echo "❌ API Error (" . $statusCode . "): " . $e->getMessage() . "\n";
    }
    
} catch (NetworkExceptionInterface $e) {
    echo "❌ Network Error: " . $e->getMessage() . "\n";
    echo "Please check your internet connection and try again.\n";
    
} catch (RequestExceptionInterface $e) {
    echo "❌ Request Error: " . $e->getMessage() . "\n";
    echo "There was a problem with the HTTP request.\n";
    
} catch (\Throwable $e) {
    echo "❌ Unexpected Error: " . $e->getMessage() . "\n";
    echo "Please contact support if this issue persists.\n";
}
```

## Error Handling with Retry Logic

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageStyle;
use Chudno\Promptchan\Enums\ImageQuality;
use Chudno\Promptchan\Exceptions\ApiException;

function createImageWithRetry(PromptchanClient $client, CreateImageRequest $request, int $maxRetries = 3): ?object
{
    $attempt = 0;
    
    while ($attempt < $maxRetries) {
        try {
            return $client->image()->create($request);
            
        } catch (ApiException $e) {
            $attempt++;
            $statusCode = $e->getCode();
            
            // Retry on server errors or rate limits
            if (in_array($statusCode, [429, 500, 502, 503]) && $attempt < $maxRetries) {
                $delay = min(pow(2, $attempt), 30); // Exponential backoff, max 30 seconds
                echo "Attempt {$attempt} failed (HTTP {$statusCode}). Retrying in {$delay} seconds...\n";
                sleep($delay);
                continue;
            }
            
            // Don't retry on client errors
            throw $e;
        }
    }
    
    return null;
}

// Usage
$client = new PromptchanClient('your-api-key-here');

$request = new CreateImageRequest(
    prompt: 'Majestic mountain landscape',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA
);

try {
    $response = createImageWithRetry($client, $request);
    
    if ($response) {
        echo "✅ Image created successfully after retries!\n";
        echo "Gems used: {$response->gems}\n";
    } else {
        echo "❌ Failed to create image after all retry attempts.\n";
    }
    
} catch (ApiException $e) {
    echo "❌ Final error: " . $e->getMessage() . "\n";
}
```

## Chat Error Handling

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\{ChatRequest, CharacterData};
use Chudno\Promptchan\Exceptions\{ApiException, ValidationException};

$client = new PromptchanClient('your-api-key-here');

$character = new CharacterData(
    name: 'Luna',
    personality: 'Friendly and helpful',
    scenario: 'A cozy library',
    age: 25,
    gender: 'female'
);

$request = new ChatRequest(
    message: 'Hello! How are you today?',
    characterData: $character,
    isRoleplay: true,
    userName: 'User'
);

try {
    $response = $client->chat()->sendMessage($request);
    echo "💬 Chat response: " . $response->message . "\n";
    
} catch (ValidationException $e) {
    echo "❌ Invalid chat request: " . $e->getMessage() . "\n";
    echo "Please check:\n";
    echo "- Message is not empty\n";
    echo "- Character data is properly formatted\n";
    echo "- All required fields are provided\n";
    
} catch (ApiException $e) {
    echo "❌ Chat API error: " . $e->getMessage() . "\n";
}
```

## Video Generation Error Handling

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitRequest;
use Chudno\Promptchan\Enums\{VideoQuality, VideoAspect};
use Chudno\Promptchan\Exceptions\{ApiException, ValidationException};

$client = new PromptchanClient('your-api-key-here');

$request = new VideoSubmitRequest(
    prompt: 'Dancing in the rain',
    quality: VideoQuality::HIGH,
    aspect: VideoAspect::PORTRAIT,
    audioEnabled: true
);

try {
    // Submit video request
    $submitResponse = $client->video()->submit($request);
    echo "✅ Video request submitted: {$submitResponse->requestId}\n";
    
    // Check status
    $status = $client->video()->getStatus($submitResponse->requestId);
    echo "📊 Status: {$status->status}\n";
    
    // Get result if completed
    if ($status->status === 'Completed') {
        $result = $client->video()->getResult($submitResponse->requestId);
        echo "🎬 Video URL: {$result->videoUrl}\n";
    }
    
} catch (ValidationException $e) {
    echo "❌ Invalid video request: " . $e->getMessage() . "\n";
    
} catch (ApiException $e) {
    $statusCode = $e->getCode();
    
    if ($statusCode === 404) {
        echo "❌ Video request not found. Please check the request ID.\n";
    } else {
        echo "❌ Video API error: " . $e->getMessage() . "\n";
    }
}
```

## Exception Types

### ValidationException
Thrown when request parameters are invalid:
- Empty or invalid prompts
- Invalid enum values
- Missing required fields
- Parameters outside allowed ranges

### ApiException
Thrown for API-related errors:
- Authentication failures (401)
- Insufficient credits (402)
- Rate limiting (429)
- Server errors (5xx)
- Not found errors (404)

### PSR HTTP Exceptions
- `NetworkExceptionInterface`: Network connectivity issues
- `RequestExceptionInterface`: HTTP request problems

## Best Practices

1. **Always wrap API calls in try-catch blocks**
2. **Handle different exception types appropriately**
3. **Implement retry logic for transient errors**
4. **Log errors for debugging and monitoring**
5. **Provide user-friendly error messages**
6. **Check API response status before processing**
7. **Validate input parameters before making requests**