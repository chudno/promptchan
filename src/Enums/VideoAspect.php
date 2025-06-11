<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum VideoAspect: string
{
    case PORTRAIT = 'Portrait';
    case WIDE = 'Wide';

    public function getLabel(): string
    {
        return $this->value;
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::PORTRAIT => 'Vertical video format (9:16)',
            self::WIDE => 'Horizontal video format (16:9)',
        };
    }

    /**
     * @return array{width: int, height: int}
     */
    public function getDimensions(): array
    {
        return match ($this) {
            self::PORTRAIT => ['width' => 720, 'height' => 1280],
            self::WIDE => ['width' => 1280, 'height' => 720],
        };
    }

    public function getRatio(): string
    {
        return match ($this) {
            self::PORTRAIT => '9:16',
            self::WIDE => '16:9',
        };
    }
}
