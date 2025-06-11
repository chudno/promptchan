<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Exceptions;

final class ValidationException extends ApiException
{
    /**
     * @param array<string, array<string>> $errors
     */
    public function __construct(
        string $message = 'Validation failed',
        private readonly array $errors = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, 422, ['errors' => $errors], $previous);
    }

    /**
     * @return array<string, array<string>>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    /**
     * @return array<string>
     */
    public function getErrorsForField(string $field): array
    {
        return $this->errors[$field] ?? [];
    }

    public function hasErrorsForField(string $field): bool
    {
        return isset($this->errors[$field]) && $this->errors[$field] !== [];
    }

    /**
     * @return array<string>
     */
    public function getAllErrorMessages(): array
    {
        $messages = [];
        foreach ($this->errors as $fieldErrors) {
            $messages = array_merge($messages, $fieldErrors);
        }
        return $messages;
    }

    public function getFirstErrorMessage(): ?string
    {
        $allMessages = $this->getAllErrorMessages();
        return $allMessages === [] ? null : $allMessages[0];
    }

    /**
     * @return array<string>
     */
    public function getFieldsWithErrors(): array
    {
        return array_keys($this->errors);
    }

    public function getErrorCount(): int
    {
        return count($this->getAllErrorMessages());
    }

    public function __toString(): string
    {
        $message = sprintf(
            'Validation Exception: %s',
            $this->getMessage()
        );

        if ($this->hasErrors()) {
            $message .= sprintf(' (Errors: %s)', json_encode($this->errors));
        }

        return $message;
    }
}