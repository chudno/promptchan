<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Services;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\Contracts\ChatServiceInterface;
use Chudno\Promptchan\DataTransferObjects\ChatRequest;
use Chudno\Promptchan\DataTransferObjects\ChatResponse;

final class ChatService implements ChatServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
        private readonly \Psr\Log\LoggerInterface $logger
    ) {
    }

    public function sendMessage(ChatRequest $request): ChatResponse
    {
        $responseData = $this->apiClient->post('api/external/chat', $request->toArray());

        return ChatResponse::fromArray($responseData);
    }
}
