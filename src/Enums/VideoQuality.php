<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum VideoQuality: string
{
    case STANDARD = 'Standard';
    case HIGH = 'High';
    case MAX = 'Max';

    public function getLabel(): string
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::STANDARD => 'Standard quality video generation',
            self::HIGH => 'High quality video generation',
            self::MAX => 'Maximum quality video generation',
        };
    }

    public function getGemsCost(): int
    {
        return match ($this) {
            self::STANDARD => 5,
            self::HIGH => 10,
            self::MAX => 15,
        };
    }
}