<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

final readonly class CreateImageResponse
{
    public function __construct(
        public string $image,
        public int $gems,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            image: $data['image'] ?? throw new \InvalidArgumentException('Missing image field'),
            gems: $data['gems'] ?? throw new \InvalidArgumentException('Missing gems field'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'image' => $this->image,
            'gems' => $this->gems,
        ];
    }

    public function getImageData(): string
    {
        // Remove data:image/png;base64, prefix if present
        if (str_starts_with($this->image, 'data:image/')) {
            $parts = explode(',', $this->image, 2);

            return $parts[1] ?? $this->image;
        }

        return $this->image;
    }

    public function getImageMimeType(): string
    {
        $imageData = base64_decode($this->getImageData(), true);

        if ($imageData === false) {
            throw new \InvalidArgumentException('Invalid base64 image data');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($imageData);

        return $mimeType !== false ? $mimeType : 'application/octet-stream';
    }

    /**
     * @return array{width: int, height: int}
     */
    public function getImageSize(): array
    {
        $imageData = base64_decode($this->getImageData(), true);

        if ($imageData === false) {
            throw new \InvalidArgumentException('Invalid base64 image data');
        }

        $size = getimagesizefromstring($imageData);

        if ($size === false) {
            throw new \RuntimeException('Unable to determine image size');
        }

        return [
            'width' => $size[0],
            'height' => $size[1],
            'type' => $size[2],
            'mime' => $size['mime'],
        ];
    }
}
