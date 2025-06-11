<?php

declare(strict_types=1);

namespace Chudno\Promptchan;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\Contracts\ChatServiceInterface;
use Chudno\Promptchan\Contracts\ImageServiceInterface;
use Chudno\Promptchan\Contracts\VideoServiceInterface;
use Chudno\Promptchan\Http\ApiClient;
use Chudno\Promptchan\Http\PsrHttpClient;
use Chudno\Promptchan\Services\ChatService;
use Chudno\Promptchan\Services\ImageService;
use Chudno\Promptchan\Services\VideoService;
use Chudno\Promptchan\Transport\PsrTransport;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class PromptchanClient
{
    private readonly ApiClientInterface $apiClient;
    private readonly ImageServiceInterface $imageService;
    private readonly ChatServiceInterface $chatService;
    private readonly VideoServiceInterface $videoService;

    public function __construct(
        string $apiKey,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?LoggerInterface $logger = null,
        string $baseUri = 'https://api.promptchan.ai'
    ) {
        // Use provided dependencies or auto-discover
        $httpClient ??= Psr18ClientDiscovery::find();
        $requestFactory ??= Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory ??= Psr17FactoryDiscovery::findStreamFactory();
        $logger ??= new NullLogger();

        // Create transport and HTTP client
        $transport = new PsrTransport($httpClient);
        $psrHttpClient = new PsrHttpClient($transport, $requestFactory, $streamFactory, $logger);

        // Create API client with configuration
        $this->apiClient = new ApiClient($psrHttpClient, $baseUri, $apiKey);

        // Initialize services
        $this->imageService = new ImageService($this->apiClient, $logger);
        $this->chatService = new ChatService($this->apiClient, $logger);
        $this->videoService = new VideoService($this->apiClient, $logger);
    }

    public function images(): ImageServiceInterface
    {
        return $this->imageService;
    }

    public function chat(): ChatServiceInterface
    {
        return $this->chatService;
    }

    public function video(): VideoServiceInterface
    {
        return $this->videoService;
    }

    public function getLastStatusCode(): ?int
    {
        return $this->apiClient->getLastStatusCode();
    }

    /**
     * @return array<string, mixed>
     */
    public function getLastHeaders(): array
    {
        return $this->apiClient->getLastHeaders();
    }
}
