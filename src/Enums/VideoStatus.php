<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum VideoStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::PENDING => 'Video generation request is queued and waiting to be processed',
            self::PROCESSING => 'Video is currently being generated',
            self::COMPLETED => 'Video generation has completed successfully',
            self::FAILED => 'Video generation failed due to an error',
            self::CANCELLED => 'Video generation was cancelled',
        };
    }

    public function isFinished(): bool
    {
        return match ($this) {
            self::COMPLETED, self::FAILED, self::CANCELLED => true,
            self::PENDING, self::PROCESSING => false,
        };
    }

    public function isSuccessful(): bool
    {
        return $this === self::COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this === self::PROCESSING;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function canBeCancelled(): bool
    {
        return match ($this) {
            self::PENDING, self::PROCESSING => true,
            self::COMPLETED, self::FAILED, self::CANCELLED => false,
        };
    }

    public function getProgressPercentage(): int
    {
        return match ($this) {
            self::PENDING => 0,
            self::PROCESSING => 50,
            self::COMPLETED => 100,
            self::FAILED, self::CANCELLED => 0,
        };
    }
}