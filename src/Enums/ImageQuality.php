<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum ImageQuality: string
{
    case ULTRA = 'Ultra';
    case EXTREME = 'Extreme';
    case MAX = 'Max';

    public function getLabel(): string
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::ULTRA => 'High quality image generation',
            self::EXTREME => 'Very high quality image generation',
            self::MAX => 'Maximum quality image generation',
        };
    }

    public function getGemsCost(): int
    {
        return match ($this) {
            self::ULTRA => 1,
            self::EXTREME => 2,
            self::MAX => 3,
        };
    }
}