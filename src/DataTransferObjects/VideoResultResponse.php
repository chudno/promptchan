<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

use Chudno\Promptchan\Enums\VideoStatus;

final readonly class VideoResultResponse
{
    public function __construct(
        public string $requestId,
        public VideoStatus $status,
        public ?string $videoUrl = null,
        public ?string $thumbnailUrl = null,
        public ?int $duration = null,
        public ?int $fileSize = null,
        public ?string $format = null,
        public ?string $resolution = null,
        public ?string $message = null,
        public ?\DateTimeInterface $createdAt = null,
        public ?\DateTimeInterface $completedAt = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $status = VideoStatus::from(
            $data['status'] ?? throw new \InvalidArgumentException('Missing status field')
        );

        $createdAt = null;
        if (isset($data['created_at'])) {
            $createdAt = new \DateTimeImmutable($data['created_at']);
        }

        $completedAt = null;
        if (isset($data['completed_at'])) {
            $completedAt = new \DateTimeImmutable($data['completed_at']);
        }

        return new self(
            requestId: $data['request_id'] ?? throw new \InvalidArgumentException('Missing request_id field'),
            status: $status,
            videoUrl: $data['video_url'] ?? null,
            thumbnailUrl: $data['thumbnail_url'] ?? null,
            duration: $data['duration'] ?? null,
            fileSize: $data['file_size'] ?? null,
            format: $data['format'] ?? null,
            resolution: $data['resolution'] ?? null,
            message: $data['message'] ?? null,
            createdAt: $createdAt,
            completedAt: $completedAt,
        );
    }

    public function toArray(): array
    {
        $data = [
            'request_id' => $this->requestId,
            'status' => $this->status->value,
        ];

        if ($this->videoUrl !== null) {
            $data['video_url'] = $this->videoUrl;
        }

        if ($this->thumbnailUrl !== null) {
            $data['thumbnail_url'] = $this->thumbnailUrl;
        }

        if ($this->duration !== null) {
            $data['duration'] = $this->duration;
        }

        if ($this->fileSize !== null) {
            $data['file_size'] = $this->fileSize;
        }

        if ($this->format !== null) {
            $data['format'] = $this->format;
        }

        if ($this->resolution !== null) {
            $data['resolution'] = $this->resolution;
        }

        if ($this->message !== null) {
            $data['message'] = $this->message;
        }

        if ($this->createdAt !== null) {
            $data['created_at'] = $this->createdAt->format('c');
        }

        if ($this->completedAt !== null) {
            $data['completed_at'] = $this->completedAt->format('c');
        }

        return $data;
    }

    public function isReady(): bool
    {
        return $this->status->isSuccessful() && $this->videoUrl !== null;
    }

    public function hasVideo(): bool
    {
        return $this->videoUrl !== null;
    }

    public function hasThumbnail(): bool
    {
        return $this->thumbnailUrl !== null;
    }

    public function getDurationInSeconds(): ?int
    {
        return $this->duration;
    }

    public function getDurationFormatted(): ?string
    {
        if ($this->duration === null) {
            return null;
        }

        $minutes = intval($this->duration / 60);
        $seconds = $this->duration % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getFileSizeFormatted(): ?string
    {
        if ($this->fileSize === null) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->fileSize;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return sprintf('%.2f %s', $size, $units[$unitIndex]);
    }

    public function getProcessingTime(): ?\DateInterval
    {
        if ($this->createdAt === null || $this->completedAt === null) {
            return null;
        }

        return $this->createdAt->diff($this->completedAt);
    }

    public function getProcessingTimeInSeconds(): ?int
    {
        $interval = $this->getProcessingTime();
        if ($interval === null) {
            return null;
        }

        return $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->d * 86400);
    }


}