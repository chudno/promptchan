# Video Generation Example

This example demonstrates how to create AI-generated videos using the Promptchan SDK.

## Basic Usage

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitRequest;
use Chudno\Promptchan\Enums\VideoQuality;
use Chudno\Promptchan\Enums\VideoAspect;
use Chudno\Promptchan\Enums\VideoStatus;

// Initialize the client
$client = new PromptchanClient('your-api-key-here');

// Create a video request
$request = new VideoSubmitRequest(
    prompt: 'Beautiful woman dancing in a flowing dress',
    quality: VideoQuality::STANDARD,
    aspect: VideoAspect::PORTRAIT
);

// Submit the video request
$submitResponse = $client->video()->submit($request);

echo "Video request submitted!\n";
echo "Request ID: {$submitResponse->requestId}\n";
```

## Checking Video Status

```php
$requestId = $submitResponse->requestId;

// Poll for status updates
do {
    $statusResponse = $client->video()->getStatus($requestId);
    
    echo "Status: {$statusResponse->status->value}\n";
    echo "Progress: {$statusResponse->progress}%\n";
    
    if ($statusResponse->status === VideoStatus::COMPLETED) {
        echo "Video generation completed!\n";
        break;
    }
    
    if ($statusResponse->status === VideoStatus::FAILED) {
        echo "Video generation failed!\n";
        break;
    }
    
    sleep(5); // Wait 5 seconds before next check
    
} while ($statusResponse->status === VideoStatus::PROCESSING);
```

## Getting the Final Result

```php
if ($statusResponse->status === VideoStatus::COMPLETED) {
    $resultResponse = $client->video()->getResult($requestId);
    
    echo "Video URL: {$resultResponse->videoUrl}\n";
    
    if ($resultResponse->thumbnailUrl !== null) {
        echo "Thumbnail URL: {$resultResponse->thumbnailUrl}\n";
    }
}
```

## Advanced Options

### High Quality with Audio

```php
$request = new VideoSubmitRequest(
    prompt: 'Elegant woman walking on a beach at sunset',
    quality: VideoQuality::HIGH,
    aspect: VideoAspect::LANDSCAPE,
    audioEnabled: true,
    seed: 98765,
    ageSlider: 28.0
);

$response = $client->video()->submit($request);
```

### Custom Seed for Reproducible Results

```php
$request = new VideoSubmitRequest(
    prompt: 'Woman in vintage dress in a garden',
    quality: VideoQuality::ULTRA,
    seed: 12345  // Same seed = same result
);
```

## Available Quality Levels

```php
use Chudno\Promptchan\Enums\VideoQuality;

// Available quality levels:
VideoQuality::STANDARD      // Standard quality, faster generation
VideoQuality::HIGH          // High quality, balanced
VideoQuality::ULTRA         // Ultra quality, best results
```

## Available Aspect Ratios

```php
use Chudno\Promptchan\Enums\VideoAspect;

// Available aspect ratios:
VideoAspect::PORTRAIT       // 9:16 (vertical)
VideoAspect::LANDSCAPE      // 16:9 (horizontal)
VideoAspect::SQUARE         // 1:1 (square)
```

## Video Status Types

```php
use Chudno\Promptchan\Enums\VideoStatus;

// Possible status values:
VideoStatus::PENDING        // Request received, waiting to start
VideoStatus::PROCESSING     // Video is being generated
VideoStatus::COMPLETED      // Video generation finished
VideoStatus::FAILED         // Generation failed
```

## Complete Example with Error Handling

```php
try {
    // Submit video request
    $request = new VideoSubmitRequest(
        prompt: 'Beautiful woman in flowing dress dancing gracefully',
        quality: VideoQuality::HIGH,
        aspect: VideoAspect::PORTRAIT,
        audioEnabled: true
    );
    
    $submitResponse = $client->video()->submit($request);
    $requestId = $submitResponse->requestId;
    
    echo "Video submitted with ID: {$requestId}\n";
    
    // Poll for completion
    $maxAttempts = 20;
    $attempt = 0;
    
    do {
        $attempt++;
        echo "Checking status (attempt {$attempt}/{$maxAttempts})...\n";
        
        $statusResponse = $client->video()->getStatus($requestId);
        
        echo "Status: {$statusResponse->status->value}\n";
        echo "Progress: {$statusResponse->progress}%\n";
        
        if ($statusResponse->estimatedTime !== null) {
            echo "Estimated time: {$statusResponse->estimatedTime} seconds\n";
        }
        
        if ($statusResponse->status === VideoStatus::COMPLETED) {
            // Get final result
            $resultResponse = $client->video()->getResult($requestId);
            echo "✅ Video completed: {$resultResponse->videoUrl}\n";
            break;
        }
        
        if ($statusResponse->status === VideoStatus::FAILED) {
            echo "❌ Video generation failed\n";
            break;
        }
        
        if ($attempt < $maxAttempts) {
            sleep(10); // Wait 10 seconds
        }
        
    } while ($attempt < $maxAttempts && $statusResponse->status === VideoStatus::PROCESSING);
    
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
    echo "Status Code: {$client->getLastStatusCode()}\n";
}
```

## Response Structures

### VideoSubmitResponse
- `requestId` - Unique identifier for tracking
- `status` - Initial status (usually PENDING)

### VideoStatusResponse
- `requestId` - Request identifier
- `status` - Current status
- `progress` - Completion percentage (0-100)
- `estimatedTime` - Estimated remaining time in seconds

### VideoResultResponse
- `requestId` - Request identifier
- `videoUrl` - Direct URL to the generated video
- `thumbnailUrl` - URL to video thumbnail (if available)
- `status` - Final status

## Tips for Better Video Results

1. **Be descriptive**: "Woman dancing gracefully in flowing red dress" vs "woman dancing"
2. **Specify movement**: Include action words like "walking", "dancing", "turning"
3. **Set appropriate quality**: Higher quality takes longer but looks better
4. **Choose right aspect ratio**: Portrait for mobile, landscape for desktop
5. **Use audio wisely**: Enable only when needed (increases generation time)
6. **Be patient**: Video generation can take several minutes