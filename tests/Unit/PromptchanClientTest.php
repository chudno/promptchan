<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Tests\Unit;

use Chudno\Promptchan\Contracts\ChatServiceInterface;
use Chudno\Promptchan\Contracts\ImageServiceInterface;
use Chudno\Promptchan\Contracts\VideoServiceInterface;
use Chudno\Promptchan\PromptchanClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class PromptchanClientTest extends TestCase
{
    public function test_can_create_client(): void
    {
        $client = new PromptchanClient('test-api-key');

        $this->assertInstanceOf(PromptchanClient::class, $client);
    }

    public function test_can_get_image_service(): void
    {
        $client = new PromptchanClient('test-api-key');

        $this->assertInstanceOf(ImageServiceInterface::class, $client->images());
    }

    public function test_can_get_chat_service(): void
    {
        $client = new PromptchanClient('test-api-key');

        $this->assertInstanceOf(ChatServiceInterface::class, $client->chat());
    }

    public function test_can_get_video_service(): void
    {
        $client = new PromptchanClient('test-api-key');

        $this->assertInstanceOf(VideoServiceInterface::class, $client->video());
    }

    public function test_initial_status_code_is_null(): void
    {
        $client = new PromptchanClient('test-api-key');

        $this->assertNull($client->getLastStatusCode());
    }

    public function test_initial_headers_are_empty(): void
    {
        $client = new PromptchanClient('test-api-key');

        $this->assertEmpty($client->getLastHeaders());
    }

    public function test_can_create_client_with_logger(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $client = new PromptchanClient('test-api-key', logger: $logger);

        $this->assertInstanceOf(PromptchanClient::class, $client);
    }

    public function test_can_create_client_with_null_logger(): void
    {
        $client = new PromptchanClient('test-api-key', logger: new NullLogger());

        $this->assertInstanceOf(PromptchanClient::class, $client);
    }
}
