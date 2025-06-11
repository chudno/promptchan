<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Exceptions;

class ApiException extends \Exception
{
    public function __construct(
        string $message = '',
        private readonly int $statusCode = 0,
        private readonly array $responseData = [],
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseData(): array
    {
        return $this->responseData;
    }

    public function hasResponseData(): bool
    {
        return $this->responseData !== [];
    }

    public function getErrorCode(): ?string
    {
        return $this->responseData['error_code'] ?? null;
    }

    public function getErrorMessage(): ?string
    {
        return $this->responseData['error_message'] ?? $this->responseData['message'] ?? null;
    }

    public function getErrorDetails(): ?array
    {
        return $this->responseData['details'] ?? null;
    }

    public function isClientError(): bool
    {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    public function isServerError(): bool
    {
        return $this->statusCode >= 500;
    }

    public function isAuthenticationError(): bool
    {
        return $this->statusCode === 401;
    }

    public function isAuthorizationError(): bool
    {
        return $this->statusCode === 403;
    }

    public function isNotFoundError(): bool
    {
        return $this->statusCode === 404;
    }

    public function isRateLimitError(): bool
    {
        return $this->statusCode === 429;
    }

    public function isBadRequestError(): bool
    {
        return $this->statusCode === 400;
    }

    public function __toString(): string
    {
        $message = sprintf(
            'API Exception [%d]: %s',
            $this->statusCode,
            $this->getMessage()
        );

        if ($this->hasResponseData()) {
            $message .= sprintf(' (Response: %s)', json_encode($this->responseData));
        }

        return $message;
    }
}