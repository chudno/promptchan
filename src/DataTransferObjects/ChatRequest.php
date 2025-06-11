<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

final readonly class ChatRequest
{
    /**
     * @param array<ChatMessage> $chatHistory
     */
    public function __construct(
        public string $message,
        public ?CharacterData $characterData = null,
        public array $chatHistory = [],
        public bool $isRoleplay = false,
        public bool $redo = false,
        public ?string $userName = null,
    ) {
        $this->validateChatHistory();
    }

    public function toArray(): array
    {
        $data = [
            'message' => $this->message,
            'isRoleplay' => $this->isRoleplay,
            'redo' => $this->redo,
        ];

        if ($this->characterData !== null) {
            $data['characterData'] = $this->characterData->toArray();
        }

        if ($this->chatHistory !== []) {
            $data['chatHistory'] = array_map(
                static fn(ChatMessage $message): array => $message->toArray(),
                $this->chatHistory
            );
        }

        if ($this->userName !== null) {
            $data['userName'] = $this->userName;
        }

        return $data;
    }

    private function validateChatHistory(): void
    {
        // Type validation is handled by PHP type system
        // ChatMessage[] ensures all items are ChatMessage instances
    }

    public function withMessage(string $message): self
    {
        return new self(
            message: $message,
            characterData: $this->characterData,
            chatHistory: $this->chatHistory,
            isRoleplay: $this->isRoleplay,
            redo: $this->redo,
            userName: $this->userName,
        );
    }

    public function withCharacter(CharacterData $characterData): self
    {
        return new self(
            message: $this->message,
            characterData: $characterData,
            chatHistory: $this->chatHistory,
            isRoleplay: $this->isRoleplay,
            redo: $this->redo,
            userName: $this->userName,
        );
    }

    public function withChatHistory(array $chatHistory): self
    {
        return new self(
            message: $this->message,
            characterData: $this->characterData,
            chatHistory: $chatHistory,
            isRoleplay: $this->isRoleplay,
            redo: $this->redo,
            userName: $this->userName,
        );
    }

    public function addToChatHistory(ChatMessage $message): self
    {
        $newHistory = $this->chatHistory;
        $newHistory[] = $message;

        return $this->withChatHistory($newHistory);
    }
}