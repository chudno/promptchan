<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Contracts;

use Chudno\Promptchan\DataTransferObjects\ChatRequest;
use Chudno\Promptchan\DataTransferObjects\ChatResponse;

interface ChatServiceInterface
{
    /**
     * Send a message to the AI companion
     *
     * @param ChatRequest $request
     * @return ChatResponse
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     * @throws \Chudno\Promptchan\Exceptions\ValidationException
     */
    public function sendMessage(ChatRequest $request): ChatResponse;
}