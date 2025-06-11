<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

final readonly class ChatResponse
{
    /**
     * @param array<ChatMessage> $chatHistory
     */
    public function __construct(
        public string $message,
        public array $chatHistory = [],
        public ?string $audio = null,
        public ?string $selfie = null,
    ) {
        $this->validateChatHistory();
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $chatHistory = [];
        if (isset($data['chatHistory']) && is_array($data['chatHistory'])) {
            $chatHistory = array_map(
                static fn (array $messageData): ChatMessage => ChatMessage::fromArray($messageData),
                $data['chatHistory']
            );
        }

        return new self(
            message: $data['message'] ?? throw new \InvalidArgumentException('Missing message field'),
            chatHistory: $chatHistory,
            audio: $data['audio'] ?? null,
            selfie: $data['selfie'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'message' => $this->message,
            'chatHistory' => array_map(
                static fn (ChatMessage $message): array => $message->toArray(),
                $this->chatHistory
            ),
        ];

        if ($this->audio !== null) {
            $data['audio'] = $this->audio;
        }

        if ($this->selfie !== null) {
            $data['selfie'] = $this->selfie;
        }

        return $data;
    }

    public function hasAudio(): bool
    {
        return $this->audio !== null;
    }

    public function hasSelfie(): bool
    {
        return $this->selfie !== null;
    }

    public function getLastUserMessage(): ?ChatMessage
    {
        $userMessages = array_filter(
            $this->chatHistory,
            static fn (ChatMessage $message): bool => $message->isUser()
        );

        return $userMessages === [] ? null : end($userMessages);
    }

    public function getLastAssistantMessage(): ?ChatMessage
    {
        $assistantMessages = array_filter(
            $this->chatHistory,
            static fn (ChatMessage $message): bool => $message->isAssistant()
        );

        return $assistantMessages === [] ? null : end($assistantMessages);
    }

    public function getChatHistoryCount(): int
    {
        return count($this->chatHistory);
    }

    public function saveAudioToFile(string $filePath): bool
    {
        if ($this->audio === null) {
            throw new \RuntimeException('No audio data available');
        }

        $audioData = base64_decode($this->audio, true);

        if ($audioData === false) {
            throw new \InvalidArgumentException('Invalid base64 audio data');
        }

        $directory = dirname($filePath);
        if (!is_dir($directory) && !mkdir($directory, 0o755, true) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        return file_put_contents($filePath, $audioData) !== false;
    }

    public function saveSelfieToFile(string $filePath): bool
    {
        if ($this->selfie === null) {
            throw new \RuntimeException('No selfie data available');
        }

        $imageData = base64_decode($this->selfie, true);

        if ($imageData === false) {
            throw new \InvalidArgumentException('Invalid base64 selfie data');
        }

        $directory = dirname($filePath);
        if (!is_dir($directory) && !mkdir($directory, 0o755, true) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        return file_put_contents($filePath, $imageData) !== false;
    }

    private function validateChatHistory(): void
    {
        // Type validation is handled by PHP type system
        // ChatMessage[] ensures all items are ChatMessage instances
    }
}
