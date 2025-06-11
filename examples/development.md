# Development Guide

This guide covers development workflows, testing, and code quality tools for the Promptchan SDK.

## Setting Up Development Environment

### Prerequisites

- PHP 8.1 or higher
- Composer
- Git

### Installation

```bash
# Clone the repository
git clone https://github.com/chudno/promptchan.git
cd promptchan

# Install dependencies
composer install

# Install development dependencies
composer install --dev
```

## Running Tests

### Basic Test Execution

```bash
# Run all tests
composer test

# Run tests with verbose output
composer test -- --verbose

# Run specific test file
vendor/bin/phpunit tests/Unit/PromptchanClientTest.php

# Run tests with filter
vendor/bin/phpunit --filter testImageGeneration
```

### Test Coverage

```bash
# Generate test coverage report
composer test-coverage

# Generate HTML coverage report
vendor/bin/phpunit --coverage-html coverage/

# Generate text coverage report
vendor/bin/phpunit --coverage-text
```

### Writing Tests

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\{ImageStyle, ImageQuality};

final class ImageGenerationTest extends TestCase
{
    private PromptchanClient $client;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new PromptchanClient('test-api-key');
    }
    
    public function testCanCreateImageRequest(): void
    {
        $request = new CreateImageRequest(
            prompt: 'Test prompt',
            style: ImageStyle::XL_REALISTIC,
            quality: ImageQuality::ULTRA
        );
        
        $this->assertInstanceOf(CreateImageRequest::class, $request);
        $this->assertEquals('Test prompt', $request->prompt);
        $this->assertEquals(ImageStyle::XL_REALISTIC, $request->style);
    }
    
    public function testImageRequestValidation(): void
    {
        $this->expectException(ValidationException::class);
        
        new CreateImageRequest(
            prompt: '', // Empty prompt should throw exception
            style: ImageStyle::XL_REALISTIC
        );
    }
}
```

## Code Quality Tools

### Static Analysis with PHPStan

```bash
# Run PHPStan analysis
composer phpstan

# Run with specific level
vendor/bin/phpstan analyse --level=8

# Generate baseline
vendor/bin/phpstan analyse --generate-baseline
```

### Code Style with PHP-CS-Fixer

```bash
# Check code style
composer cs-check

# Fix code style issues
composer cs-fix

# Dry run (show what would be fixed)
vendor/bin/php-cs-fixer fix --dry-run --diff
```

### Code Refactoring with Rector

```bash
# Run Rector analysis
composer rector

# Dry run (show what would be changed)
vendor/bin/rector --dry-run

# Process specific file
vendor/bin/rector process src/PromptchanClient.php
```

### Run All Quality Checks

```bash
# Run all quality checks at once
composer quality

# This runs:
# - PHPStan static analysis
# - PHP-CS-Fixer code style check
# - PHPUnit tests
```

## Configuration Files

### PHPUnit Configuration (`phpunit.xml`)

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         verbose="true">
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">tests/Unit</directory>
        </testsuite>
    </testsuites>
    <coverage>
        <include>
            <directory suffix=".php">src</directory>
        </include>
    </coverage>
</phpunit>
```

### PHPStan Configuration (`phpstan.neon`)

```neon
parameters:
    level: 8
    paths:
        - src
        - tests
    ignoreErrors:
        - '#Call to an undefined method#'
    checkMissingIterableValueType: false
```

### PHP-CS-Fixer Configuration (`.php-cs-fixer.php`)

```php
<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PHP81Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'declare_strict_types' => true,
    ])
    ->setFinder($finder);
```

## Continuous Integration

### GitHub Actions Workflow

```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    strategy:
      matrix:
        php-version: [8.1, 8.2, 8.3]
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: ${{ matrix.php-version }}
        extensions: mbstring, xml, ctype, json
        coverage: xdebug
    
    - name: Install dependencies
      run: composer install --prefer-dist --no-progress
    
    - name: Run tests
      run: composer test
    
    - name: Run static analysis
      run: composer phpstan
    
    - name: Check code style
      run: composer cs-check
```

## Development Workflow

### 1. Feature Development

```bash
# Create feature branch
git checkout -b feature/new-feature

# Make changes
# ...

# Run quality checks
composer quality

# Commit changes
git add .
git commit -m "Add new feature"

# Push branch
git push origin feature/new-feature
```

### 2. Before Committing

```bash
# Always run these before committing:
composer test          # Ensure tests pass
composer phpstan       # Check static analysis
composer cs-fix        # Fix code style
composer rector        # Apply refactoring rules
```

### 3. Release Process

```bash
# Update version in composer.json
# Update CHANGELOG.md
# Run full test suite
composer quality

# Tag release
git tag v1.0.0
git push origin v1.0.0
```

## Debugging

### Enable Debug Logging

```php
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Chudno\Promptchan\PromptchanClient;

$logger = new Logger('promptchan-debug');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

$client = new PromptchanClient('your-api-key', logger: $logger);

// All HTTP requests/responses will be logged
$response = $client->image()->create($request);
```

### Using Xdebug

```bash
# Install Xdebug
pecl install xdebug

# Add to php.ini
zend_extension=xdebug
xdebug.mode=debug
xdebug.start_with_request=yes
```

## Performance Testing

### Benchmarking

```php
<?php

use Chudno\Promptchan\PromptchanClient;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\Enums\{ImageStyle, ImageQuality};

$client = new PromptchanClient('your-api-key');

$request = new CreateImageRequest(
    prompt: 'Performance test image',
    style: ImageStyle::XL_REALISTIC,
    quality: ImageQuality::ULTRA
);

$startTime = microtime(true);
$response = $client->image()->create($request);
$endTime = microtime(true);

$duration = $endTime - $startTime;
echo "Request completed in: {$duration} seconds\n";
echo "Memory usage: " . memory_get_peak_usage(true) / 1024 / 1024 . " MB\n";
```

## Contributing Guidelines

1. **Follow PSR-12 coding standards**
2. **Write tests for new features**
3. **Maintain 90%+ test coverage**
4. **Use strict types declarations**
5. **Document public APIs**
6. **Run quality checks before submitting**
7. **Keep commits atomic and well-described**

## Useful Commands Reference

```bash
# Development
composer install --dev          # Install dev dependencies
composer dump-autoload          # Regenerate autoloader
composer validate               # Validate composer.json

# Testing
composer test                   # Run tests
composer test-coverage          # Run tests with coverage
phpunit --group=integration     # Run specific test group

# Code Quality
composer phpstan               # Static analysis
composer cs-fix                # Fix code style
composer rector                # Refactor code
composer quality               # Run all checks

# Debugging
composer show                  # Show installed packages
composer outdated              # Show outdated packages
composer why package/name      # Show why package is installed
```