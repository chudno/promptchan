# Image Generation Example

This example demonstrates how to create AI-generated images using the Promptchan SDK.

## Basic Usage

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageStyle;
use Chudno\Promptchan\Enums\ImageQuality;
use Chudno\Promptchan\Enums\ImageSize; // Added ImageSize enum

// Initialize the client
$client = new PromptchanClient('your-api-key-here');

// Create a basic image request
$request = new CreateImageRequest(
    prompt: 'Beautiful woman with long hair in a garden',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA,
    imageSize: ImageSize::S512x512 // Added ImageSize example
);

// Generate the image
$response = $client->image()->create($request);

echo "Image created successfully!\n";
echo "Gems used: {$response->gems}\n";
echo "Image data length: " . strlen($response->image) . " characters\n";
```

## Advanced Options

### Using Poses and Negative Prompts

```php
use Chudno\Promptchan\Enums\ImagePose;

$request = new CreateImageRequest(
    prompt: 'Elegant woman in evening dress at a gala',
    style: ImageStyle::XL_REALISTIC,
    pose: ImagePose::STANDING,
    quality: ImageQuality::ULTRA,
    negativePrompt: 'blurry, low quality, distorted',
    seed: 12345,
    creativity: 0.8,
    imageSize: ImageSize::S512x512, // Changed to ImageSize enum, example uses S512x512, can be S768x512 or S512x768
    faceRestoration: true
);

$response = $client->image()->create($request);

echo "Character image created!\n";
echo "Gems used: {$response->gems}\n";
```

### Customizing Character Appearance

```php
$request = new CreateImageRequest(
    prompt: 'Portrait of a confident businesswoman',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA,
    ageSlider: 30.0,        // Age appearance
    weightSlider: 0.4,      // Body weight (0.0 - 1.0)
    breastSlider: 0.6,      // Breast size (0.0 - 1.0)
    assSlider: 0.5,         // Hip size (0.0 - 1.0)
    faceRestoration: true
);

$response = $client->image()->create($request);
```

## Available Styles

```php
use Chudno\Promptchan\Enums\ImageStyle;

// Available styles:
ImageStyle::XL_REALISTIC     // Most realistic style
ImageStyle::ANIME           // Anime/manga style
ImageStyle::CARTOON         // Cartoon style
// ... other styles
```

## Available Poses

```php
use Chudno\Promptchan\Enums\ImagePose;

// Available poses:
ImagePose::STANDING
ImagePose::SITTING
ImagePose::LYING
// ... other poses
```

## Quality Settings

```php
use Chudno\Promptchan\Enums\ImageQuality;

// Available quality levels:
ImageQuality::STANDARD      // Standard quality
ImageQuality::HIGH          // High quality
ImageQuality::ULTRA         // Ultra quality (best)
```

## Image Sizes

Use the `ImageSize` enum to specify dimensions:

```php
use Chudno\Promptchan\Enums\ImageSize;

// Available sizes:
ImageSize::S512x512  // 512x512 pixels
ImageSize::S512x768  // 512x768 pixels
ImageSize::S768x512  // 768x512 pixels
```

**Example:**
```php
$request = new CreateImageRequest(
    prompt: 'A beautiful landscape',
    imageSize: ImageSize::S768x512 // Landscape format
);
```

## Error Handling

```php
try {
    $response = $client->image()->create($request);
    echo "Success! Gems used: {$response->gems}\n";
    
    // Get image information
    $size = $response->getImageSize();
    echo "Image size: {$size['width']}x{$size['height']}\n";
    echo "MIME type: {$response->getImageMimeType()}\n";
    

    
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
    echo "Status Code: {$client->getLastStatusCode()}\n";
}
```

## Response Structure

The `CreateImageResponse` contains:
- `image` - Base64 encoded image data
- `gems` - Number of gems consumed for generation

### Available Methods:
- `getImageData()` - Get clean base64 data (without data URI prefix)

- `getImageMimeType()` - Get image MIME type
- `getImageSize()` - Get image dimensions and type info

## Tips for Better Results

1. **Be specific in prompts**: Instead of "woman", use "elegant woman in red dress"
2. **Use negative prompts**: Exclude unwanted elements like "blurry, low quality"
3. **Experiment with creativity**: Values 0.5-0.8 usually work well
4. **Enable face restoration**: For better facial details
5. **Use seeds**: For reproducible results
6. **Handle base64 data**: Images come as base64, decode manually if needed
7. **Check image info**: Use `getImageSize()` and `getImageMimeType()` for metadata