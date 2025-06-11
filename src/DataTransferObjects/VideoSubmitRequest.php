<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

use Chudno\Promptchan\Enums\VideoAspect;
use Chudno\Promptchan\Enums\VideoQuality;

final readonly class VideoSubmitRequest
{
    public function __construct(
        public string $prompt,
        public VideoQuality $quality = VideoQuality::STANDARD,
        public VideoAspect $aspect = VideoAspect::PORTRAIT,
        public bool $audioEnabled = false,
        public ?int $seed = null,
        public float $ageSlider = 25.0,
    ) {
        $this->validateAgeSlider();
    }

    public function toArray(): array
    {
        $data = [
            'prompt' => $this->prompt,
            'video_quality' => $this->quality->value,
            'aspect' => $this->aspect->value,
            'audioEnabled' => $this->audioEnabled,
            'age_slider' => $this->ageSlider,
        ];

        if ($this->seed !== null) {
            $data['seed'] = $this->seed;
        }

        return $data;
    }

    private function validateAgeSlider(): void
    {
        if ($this->ageSlider < 18.0) {
            throw new \InvalidArgumentException(
                sprintf('Age slider must be at least 18.0, got %f', $this->ageSlider)
            );
        }
    }

    public function withPrompt(string $prompt): self
    {
        return new self(
            prompt: $prompt,
            quality: $this->quality,
            aspect: $this->aspect,
            audioEnabled: $this->audioEnabled,
            seed: $this->seed,
            ageSlider: $this->ageSlider,
        );
    }

    public function withQuality(VideoQuality $quality): self
    {
        return new self(
            prompt: $this->prompt,
            quality: $quality,
            aspect: $this->aspect,
            audioEnabled: $this->audioEnabled,
            seed: $this->seed,
            ageSlider: $this->ageSlider,
        );
    }

    public function withAspect(VideoAspect $aspect): self
    {
        return new self(
            prompt: $this->prompt,
            quality: $this->quality,
            aspect: $aspect,
            audioEnabled: $this->audioEnabled,
            seed: $this->seed,
            ageSlider: $this->ageSlider,
        );
    }

    public function withAudio(bool $audioEnabled = true): self
    {
        return new self(
            prompt: $this->prompt,
            quality: $this->quality,
            aspect: $this->aspect,
            audioEnabled: $audioEnabled,
            seed: $this->seed,
            ageSlider: $this->ageSlider,
        );
    }

    public function withSeed(int $seed): self
    {
        return new self(
            prompt: $this->prompt,
            quality: $this->quality,
            aspect: $this->aspect,
            audioEnabled: $this->audioEnabled,
            seed: $seed,
            ageSlider: $this->ageSlider,
        );
    }

    public function withAgeSlider(float $ageSlider): self
    {
        return new self(
            prompt: $this->prompt,
            quality: $this->quality,
            aspect: $this->aspect,
            audioEnabled: $this->audioEnabled,
            seed: $this->seed,
            ageSlider: $ageSlider,
        );
    }

    public function getEstimatedGemsCost(): int
    {
        $baseCost = $this->quality->getGemsCost();
        $audioCost = $this->audioEnabled ? 2 : 0;
        
        return $baseCost + $audioCost;
    }
}