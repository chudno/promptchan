<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Enums;

enum ImageStyle: string
{
    case XL_STYLISED_ANIME_XL = 'XL Stylised (Anime XL)';
    case XL_REALISTIC = 'XL Realistic';
    case XL_PLUS = 'XL+';

    public function getLabel(): string
    {
        return match ($this) {
            self::XL_STYLISED_ANIME_XL => 'XL Stylised (Anime XL)',
            self::XL_REALISTIC => 'XL Realistic',
            self::XL_PLUS => 'XL+',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::XL_STYLISED_ANIME_XL => 'Anime-style image generation with stylized aesthetics',
            self::XL_REALISTIC => 'Photorealistic image generation',
            self::XL_PLUS => 'Enhanced quality image generation',
        };
    }
}