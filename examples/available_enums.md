# Available Enums

This document describes all available enums in the Promptchan SDK and their usage.

## Image Enums

### ImageSize

Defines the dimensions for image generation:

```php
use Chudno\Promptchan\Enums\ImageSize;

// Available sizes:
ImageSize::S512x512  // 512x512 pixels
ImageSize::S512x768  // 512x768 pixels
ImageSize::S768x512  // 768x512 pixels
```

**Usage Example:**
```php
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageSize;

$request = new CreateImageRequest(
    prompt: 'A cute cat',
    imageSize: ImageSize::S512x512 // Use 512x512 size
);
```

### ImageStyle

Defines the artistic style for image generation:

```php
use Chudno\Promptchan\Enums\ImageStyle;

// Available styles:
ImageStyle::XL_STYLISED_ANIME_XL  // Anime/manga style with enhanced details
ImageStyle::XL_REALISTIC          // Photorealistic style
ImageStyle::XL_PLUS              // Enhanced realistic style with more details
```

**Usage Example:**
```php
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageStyle;

$request = new CreateImageRequest(
    prompt: 'Beautiful woman in a garden',
    style: ImageStyle::XL_REALISTIC  // Use realistic style
);
```

### ImageQuality

Defines the quality level for image generation:

```php
use Chudno\Promptchan\Enums\ImageQuality;

// Available qualities (from lowest to highest):
ImageQuality::ULTRA    // Standard quality, faster generation
ImageQuality::EXTREME  // High quality, balanced speed/quality
ImageQuality::MAX      // Maximum quality, slower generation
```

**Usage Example:**
```php
$request = new CreateImageRequest(
    prompt: 'Sunset landscape',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::MAX  // Use maximum quality
);
```

### ImagePose

Defines character poses for image generation:

```php
use Chudno\Promptchan\Enums\ImagePose;

// Available poses:
ImagePose::STANDING   // Character in standing position
// Additional poses may be available - check the enum class for complete list
```

**Usage Example:**
```php
$request = new CreateImageRequest(
    prompt: 'Elegant woman in evening dress',
    style: ImageStyle::XL_REALISTIC,
    pose: ImagePose::STANDING
);
```

## Video Enums

### VideoQuality

Defines the quality level for video generation:

```php
use Chudno\Promptchan\Enums\VideoQuality;

// Available qualities:
VideoQuality::STANDARD  // Standard definition, faster processing
VideoQuality::HIGH      // High definition, balanced quality/speed
VideoQuality::MAX       // Maximum quality, slower processing
```

**Usage Example:**
```php
use Chudno\Promptchan\DataTransferObjects\VideoSubmitRequest;
use Chudno\Promptchan\Enums\VideoQuality;

$request = new VideoSubmitRequest(
    prompt: 'Dancing in the rain',
    quality: VideoQuality::HIGH
);
```

### VideoAspect

Defines the aspect ratio for video generation:

```php
use Chudno\Promptchan\Enums\VideoAspect;

// Available aspect ratios:
VideoAspect::PORTRAIT  // Vertical orientation (9:16)
VideoAspect::WIDE      // Horizontal orientation (16:9)
```

**Usage Example:**
```php
$request = new VideoSubmitRequest(
    prompt: 'Ocean waves',
    quality: VideoQuality::HIGH,
    aspect: VideoAspect::WIDE  // Use wide aspect ratio
);
```

### VideoStatus

Represents the status of video generation requests:

```php
use Chudno\Promptchan\Enums\VideoStatus;

// Available statuses:
VideoStatus::PENDING     // Request is queued for processing
VideoStatus::PROCESSING  // Video is being generated
VideoStatus::COMPLETED   // Video generation completed successfully
VideoStatus::FAILED      // Video generation failed
```

**Usage Example:**
```php
$status = $client->video()->getStatus($requestId);

switch ($status->status) {
    case VideoStatus::PENDING:
        echo "Video is queued for processing...\n";
        break;
    case VideoStatus::PROCESSING:
        echo "Video is being generated...\n";
        break;
    case VideoStatus::COMPLETED:
        echo "Video is ready!\n";
        $result = $client->video()->getResult($requestId);
        break;
    case VideoStatus::FAILED:
        echo "Video generation failed.\n";
        break;
}
```

## Logging Enums

### LogType

Defines types of log entries for debugging:

```php
use Chudno\Promptchan\Enums\LogType;

// Available log types:
LogType::REQUEST   // HTTP request logging
LogType::RESPONSE  // HTTP response logging
LogType::ERROR     // Error logging
```

## Complete Usage Example

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\{CreateImageRequest, VideoSubmitRequest};
use Chudno\Promptchan\Enums\{
    ImageStyle,
    ImageQuality,
    ImagePose,
    ImageSize, // Added ImageSize
    VideoQuality,
    VideoAspect,
    VideoStatus
};

$client = new PromptchanClient('your-api-key-here');

// Image generation with all enum options
$imageRequest = new CreateImageRequest(
    prompt: 'Beautiful anime character in magical forest',
    style: ImageStyle::XL_STYLISED_ANIME_XL,
    pose: ImagePose::STANDING,
    quality: ImageQuality::EXTREME,
    imageSize: ImageSize::S512x512 // Added ImageSize example
);

$imageResponse = $client->image()->create($imageRequest);
echo "Image created with {$imageResponse->gems} gems\n";

// Video generation with enum options
$videoRequest = new VideoSubmitRequest(
    prompt: 'Character walking through enchanted forest',
    quality: VideoQuality::HIGH,
    aspect: VideoAspect::PORTRAIT,
    audioEnabled: true
);

$videoSubmit = $client->video()->submit($videoRequest);
echo "Video request submitted: {$videoSubmit->requestId}\n";

// Check video status
$videoStatus = $client->video()->getStatus($videoSubmit->requestId);
echo "Video status: {$videoStatus->status}\n";

if ($videoStatus->status === VideoStatus::COMPLETED) {
    $videoResult = $client->video()->getResult($videoSubmit->requestId);
    echo "Video ready: {$videoResult->videoUrl}\n";
}
```

## Enum Value Reference

### Quick Reference Table

| Enum | Values | Description |
|------|--------|-------------|
| **ImageStyle** | `XL_STYLISED_ANIME_XL`, `XL_REALISTIC`, `XL_PLUS` | Artistic styles for images |
| **ImageQuality** | `ULTRA`, `EXTREME`, `MAX` | Quality levels (low to high) |
| **ImagePose** | `STANDING` | Character poses |
| **VideoQuality** | `STANDARD`, `HIGH`, `MAX` | Video quality levels |
| **VideoAspect** | `PORTRAIT`, `WIDE` | Video aspect ratios |
| **VideoStatus** | `PENDING`, `PROCESSING`, `COMPLETED`, `FAILED` | Video generation status |
| **LogType** | `REQUEST`, `RESPONSE`, `ERROR` | Log entry types |

## Tips

1. **Use type hints**: Always import and use the enum classes for better IDE support
2. **Quality vs Speed**: Higher quality settings take longer to process
3. **Style Selection**: Choose the style that best matches your desired output
4. **Video Status**: Always check video status before attempting to get results
5. **Aspect Ratios**: Choose aspect ratio based on your intended use (social media, web, etc.)