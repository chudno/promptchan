# Promptchan PHP SDK

[![Tests](https://github.com/chudno/promptchan/workflows/Tests/badge.svg)](https://github.com/chudno/promptchan/actions)
[![Static Analysis](https://github.com/chudno/promptchan/workflows/Static%20Analysis/badge.svg)](https://github.com/chudno/promptchan/actions)
[![Code Style](https://github.com/chudno/promptchan/workflows/Code%20Style/badge.svg)](https://github.com/chudno/promptchan/actions)
[![Latest Stable Version](https://poser.pugx.org/chudno/promptchan/v/stable)](https://packagist.org/packages/chudno/promptchan)
[![License](https://poser.pugx.org/chudno/promptchan/license)](https://packagist.org/packages/chudno/promptchan)

A modern, framework-agnostic PHP SDK for the Promptchan API. Generate AI images, chat with AI companions, and create videos with a clean, type-safe interface.

## Features

- 🎨 **AI Image Generation** - Create images with various styles, poses, and filters
- 💬 **AI Chat** - Interactive conversations with AI companions
- 🎬 **Video Generation** - Asynchronous video creation with status tracking
- 🔒 **Type Safety** - Full PHP 8.1+ type declarations with enums
- 📝 **PSR-3 Logging** - Built-in request/response logging support
- 🧪 **Fully Tested** - Comprehensive test suite with >90% coverage
- 🏗️ **Modern Architecture** - Clean, SOLID principles with dependency injection

## Requirements

- PHP 8.1 or higher
- Any PSR-18 HTTP client (Guzzle, Symfony HttpClient, etc.)
- Valid Promptchan API key

## Installation

```bash
composer require chudno/promptchan

# Install a PSR-18 HTTP client (choose one):
composer require guzzlehttp/guzzle  # Recommended
# OR
composer require symfony/http-client nyholm/psr7
# OR  
composer require react/http
```

## Quick Start

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\ImageStyle;
use Chudno\Promptchan\Enums\ImageQuality;

// Initialize the client (auto-discovers HTTP client)
$client = new PromptchanClient('your-api-key');

// Generate an image
$request = new CreateImageRequest(
    prompt: 'Beautiful sunset over mountains',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA
);

$response = $client->images()->create($request);
echo "Generated image: " . $response->image;
echo "Remaining gems: " . $response->gems;
```

## Usage Examples

Detailed examples are available in the [examples](examples/) directory:

- **[Image Generation](examples/image_generation.md)** - Complete guide for AI image generation with various styles and parameters
- **[AI Chat](examples/chat_interaction.md)** - Interactive conversations with AI companions and roleplay scenarios
- **[Video Generation](examples/video_generation.md)** - Asynchronous video creation with status tracking
- **[Logging Integration](examples/logging_integration.md)** - Request/response logging with PSR-3 loggers
- **[HTTP Client Setup](examples/http_client_setup.md)** - Configuring custom HTTP clients (Guzzle, Symfony, etc.)
- **[Error Handling](examples/error_handling.md)** - Comprehensive error handling strategies and retry logic
- **[Available Enums](examples/available_enums.md)** - All available enums and their usage examples
- **[Development Guide](examples/development.md)** - Development workflows, testing, and code quality tools
- **[All Examples Overview](examples/README.md)** - Complete list of available examples

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

If you encounter any issues or have questions, please [open an issue](https://github.com/chudno/promptchan/issues) on GitHub.