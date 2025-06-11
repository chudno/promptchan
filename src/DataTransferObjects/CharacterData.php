<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

final readonly class CharacterData
{
    public function __construct(
        public string $name,
        public string $personality,
        public string $scenario,
        public string $sexuality = 'heterosexual',
        public int $openness = 1,
        public int $emotions = 1,
        public int $age = 25,
        public string $gender = 'female',
    ) {
        $this->validateOpenness();
        $this->validateEmotions();
        $this->validateAge();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'personality' => $this->personality,
            'scenario' => $this->scenario,
            'sexuality' => $this->sexuality,
            'openness' => $this->openness,
            'emotions' => $this->emotions,
            'age' => $this->age,
            'gender' => $this->gender,
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? throw new \InvalidArgumentException('Missing name field'),
            personality: $data['personality'] ?? throw new \InvalidArgumentException('Missing personality field'),
            scenario: $data['scenario'] ?? throw new \InvalidArgumentException('Missing scenario field'),
            sexuality: $data['sexuality'] ?? 'heterosexual',
            openness: $data['openness'] ?? 1,
            emotions: $data['emotions'] ?? 1,
            age: $data['age'] ?? 25,
            gender: $data['gender'] ?? 'female',
        );
    }

    private function validateOpenness(): void
    {
        if ($this->openness < 0 || $this->openness > 2) {
            throw new \InvalidArgumentException(
                sprintf('Openness must be between 0 and 2, got %d', $this->openness)
            );
        }
    }

    private function validateEmotions(): void
    {
        if ($this->emotions < 0 || $this->emotions > 2) {
            throw new \InvalidArgumentException(
                sprintf('Emotions must be between 0 and 2, got %d', $this->emotions)
            );
        }
    }

    private function validateAge(): void
    {
        if ($this->age < 18) {
            throw new \InvalidArgumentException(
                sprintf('Age must be at least 18, got %d', $this->age)
            );
        }
    }

    public function withName(string $name): self
    {
        return new self(
            name: $name,
            personality: $this->personality,
            scenario: $this->scenario,
            sexuality: $this->sexuality,
            openness: $this->openness,
            emotions: $this->emotions,
            age: $this->age,
            gender: $this->gender,
        );
    }

    public function withPersonality(string $personality): self
    {
        return new self(
            name: $this->name,
            personality: $personality,
            scenario: $this->scenario,
            sexuality: $this->sexuality,
            openness: $this->openness,
            emotions: $this->emotions,
            age: $this->age,
            gender: $this->gender,
        );
    }

    public function withScenario(string $scenario): self
    {
        return new self(
            name: $this->name,
            personality: $this->personality,
            scenario: $scenario,
            sexuality: $this->sexuality,
            openness: $this->openness,
            emotions: $this->emotions,
            age: $this->age,
            gender: $this->gender,
        );
    }

    public function getOpennessLevel(): string
    {
        return match ($this->openness) {
            0 => 'Conservative',
            1 => 'Moderate',
            2 => 'Open',
            default => 'Unknown',
        };
    }

    public function getEmotionalLevel(): string
    {
        return match ($this->emotions) {
            0 => 'Reserved',
            1 => 'Balanced',
            2 => 'Expressive',
            default => 'Unknown',
        };
    }
}
