<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum ImageSize: string
{
    CASE S512x512 = '512x512';
    CASE S512x768 = '512x768';
    CASE S768x512 = '768x512';

    public function getLabel(): string
    {
        return match($this) {
            self::S512x512 => '512x512',
            self::S512x768 => '512x768',
            self::S768x512 => '768x512',
        };
    }
}