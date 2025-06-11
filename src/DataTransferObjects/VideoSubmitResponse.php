<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

final readonly class VideoSubmitResponse
{
    public function __construct(
        public string $requestId,
        public string $message = 'Video generation request submitted successfully',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            requestId: $data['request_id'] ?? throw new \InvalidArgumentException('Missing request_id field'),
            message: $data['message'] ?? 'Video generation request submitted successfully',
        );
    }

    public function toArray(): array
    {
        return [
            'request_id' => $this->requestId,
            'message' => $this->message,
        ];
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isSuccessful(): bool
    {
        return $this->requestId !== '';
    }
}