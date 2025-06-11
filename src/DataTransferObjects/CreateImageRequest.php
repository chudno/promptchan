<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

use Chudno\Promptchan\Enums\ImagePose;
use Chudno\Promptchan\Enums\ImageQuality;
use Chudno\Promptchan\Enums\ImageSize; // Added ImageSize enum
use Chudno\Promptchan\Enums\ImageStyle;

final readonly class CreateImageRequest
{
    public function __construct(
        public string $prompt,
        public ImageStyle $style = ImageStyle::XL_REALISTIC,
        public ?ImagePose $pose = null,
        public ?string $filter = null,
        public ?string $emotion = null,
        public ?string $detail = null,
        public ?string $negativePrompt = null,
        public ?int $seed = null,
        public ImageQuality $quality = ImageQuality::ULTRA,
        public float $creativity = 0.5,
        public ImageSize $imageSize = ImageSize::S512x512, // Changed to ImageSize enum
        public bool $faceRestoration = false,
        public float $ageSlider = 25.0,
        public float $weightSlider = 0.5,
        public float $breastSlider = 0.5,
        public float $assSlider = 0.5,
    ) {
        $this->validateImageSize();
        $this->validateSliders();
        $this->validateCreativity();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'prompt' => $this->prompt,
            'style' => $this->style->value,
            'quality' => $this->quality->value,
            'creativity' => $this->creativity,
            'image_size' => $this->imageSize->value, // Changed to use enum value
            'face_restoration' => $this->faceRestoration,
            'age_slider' => $this->ageSlider,
            'weight_slider' => $this->weightSlider,
            'breast_slider' => $this->breastSlider,
            'ass_slider' => $this->assSlider,
        ];

        if ($this->pose !== null) {
            $data['pose'] = $this->pose->value;
        }

        if ($this->filter !== null) {
            $data['filter'] = $this->filter;
        }

        if ($this->emotion !== null) {
            $data['emotion'] = $this->emotion;
        }

        if ($this->detail !== null) {
            $data['detail'] = $this->detail;
        }

        if ($this->negativePrompt !== null) {
            $data['negative_prompt'] = $this->negativePrompt;
        }

        if ($this->seed !== null) {
            $data['seed'] = $this->seed;
        }

        return $data;
    }

    private function validateImageSize(): void
    {
        // Validation is now handled by the enum type hint
        // We can keep this method for potential future complex validation logic if needed
        // or remove it if it's no longer necessary.
        // For now, let's keep it empty as the enum handles basic validation.
    }

    private function validateSliders(): void
    {
        $normalizedSliders = [
            'weightSlider' => $this->weightSlider,
            'breastSlider' => $this->breastSlider,
            'assSlider' => $this->assSlider,
        ];

        foreach ($normalizedSliders as $name => $value) {
            if ($value < 0.0 || $value > 1.0) {
                throw new \InvalidArgumentException(
                    sprintf('%s must be between 0.0 and 1.0, got %f', $name, $value)
                );
            }
        }

        if ($this->ageSlider < 18.0 || $this->ageSlider > 100.0) { // Assuming a reasonable upper limit for age
            throw new \InvalidArgumentException(
                sprintf('ageSlider must be between 18.0 and 100.0, got %f', $this->ageSlider)
            );
        }
    }

    private function validateCreativity(): void
    {
        if ($this->creativity < 0.0 || $this->creativity > 1.0) {
            throw new \InvalidArgumentException(
                sprintf('Creativity must be between 0.0 and 1.0, got %f', $this->creativity)
            );
        }
    }
}
