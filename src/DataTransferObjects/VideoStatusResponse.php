<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

use Chudno\Promptchan\Enums\VideoStatus;

final readonly class VideoStatusResponse
{
    public function __construct(
        public string $requestId,
        public VideoStatus $status,
        public ?string $message = null,
        public ?int $progress = null,
        public ?\DateTimeInterface $createdAt = null,
        public ?\DateTimeInterface $updatedAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $status = VideoStatus::from(
            $data['status'] ?? throw new \InvalidArgumentException('Missing status field')
        );

        $createdAt = null;
        if (isset($data['created_at'])) {
            $createdAt = new \DateTimeImmutable($data['created_at']);
        }

        $updatedAt = null;
        if (isset($data['updated_at'])) {
            $updatedAt = new \DateTimeImmutable($data['updated_at']);
        }

        return new self(
            requestId: $data['request_id'] ?? throw new \InvalidArgumentException('Missing request_id field'),
            status: $status,
            message: $data['message'] ?? null,
            progress: $data['progress'] ?? null,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'request_id' => $this->requestId,
            'status' => $this->status->value,
        ];

        if ($this->message !== null) {
            $data['message'] = $this->message;
        }

        if ($this->progress !== null) {
            $data['progress'] = $this->progress;
        }

        if ($this->createdAt !== null) {
            $data['created_at'] = $this->createdAt->format('c');
        }

        if ($this->updatedAt !== null) {
            $data['updated_at'] = $this->updatedAt->format('c');
        }

        return $data;
    }

    public function isFinished(): bool
    {
        return $this->status->isFinished();
    }

    public function isSuccessful(): bool
    {
        return $this->status->isSuccessful();
    }

    public function isFailed(): bool
    {
        return $this->status->isFailed();
    }

    public function isPending(): bool
    {
        return $this->status->isPending();
    }

    public function isProcessing(): bool
    {
        return $this->status->isProcessing();
    }

    public function getProgressPercentage(): int
    {
        return $this->progress ?? $this->status->getProgressPercentage();
    }

    public function getElapsedTime(): ?\DateInterval
    {
        if ($this->createdAt === null || $this->updatedAt === null) {
            return null;
        }

        return $this->createdAt->diff($this->updatedAt);
    }

    public function getElapsedTimeInSeconds(): ?int
    {
        $interval = $this->getElapsedTime();
        if ($interval === null) {
            return null;
        }

        return $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->d * 86400);
    }
}
