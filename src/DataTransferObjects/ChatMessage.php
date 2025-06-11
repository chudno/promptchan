<?php

declare(strict_types=1);

namespace Chudno\Promptchan\DataTransferObjects;

final readonly class ChatMessage
{
    public function __construct(
        public string $role,
        public string $content,
        public ?\DateTimeInterface $sendDate = null,
    ) {
        $this->validateRole();
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'role' => $this->role,
            'content' => $this->content,
        ];

        if ($this->sendDate !== null) {
            $data['send_date'] = $this->sendDate->format('c');
        }

        return $data;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $sendDate = null;
        if (isset($data['send_date'])) {
            $sendDate = new \DateTimeImmutable($data['send_date']);
        }

        return new self(
            role: $data['role'] ?? throw new \InvalidArgumentException('Missing role field'),
            content: $data['content'] ?? throw new \InvalidArgumentException('Missing content field'),
            sendDate: $sendDate,
        );
    }

    public static function user(string $content, ?\DateTimeInterface $sendDate = null): self
    {
        return new self('user', $content, $sendDate);
    }

    public static function assistant(string $content, ?\DateTimeInterface $sendDate = null): self
    {
        return new self('assistant', $content, $sendDate);
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isAssistant(): bool
    {
        return $this->role === 'assistant';
    }

    private function validateRole(): void
    {
        $allowedRoles = ['user', 'assistant'];
        if (!in_array($this->role, $allowedRoles, true)) {
            throw new \InvalidArgumentException(
                sprintf('Invalid role. Allowed roles: %s', implode(', ', $allowedRoles))
            );
        }
    }

    public function withContent(string $content): self
    {
        return new self(
            role: $this->role,
            content: $content,
            sendDate: $this->sendDate,
        );
    }

    public function withSendDate(\DateTimeInterface $sendDate): self
    {
        return new self(
            role: $this->role,
            content: $this->content,
            sendDate: $sendDate,
        );
    }

    public function getWordCount(): int
    {
        return str_word_count($this->content);
    }

    public function getCharacterCount(): int
    {
        return mb_strlen($this->content);
    }

    public function isEmpty(): bool
    {
        return trim($this->content) === '';
    }
}
