<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Http;

use Chudno\Promptchan\Contracts\HttpClientInterface;
use Chudno\Promptchan\Enums\LogType;
use Chudno\Promptchan\Exceptions\ApiException;
use Chudno\Promptchan\Exceptions\ValidationException;
use Chudno\Promptchan\Transport\TransportInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class PsrHttpClient implements HttpClientInterface
{
    private ?int $lastStatusCode = null;

    /**
     * @var array<string, array<string>>
     */
    private array $lastHeaders = [];

    public function __construct(
        private readonly TransportInterface $transport,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly LoggerInterface $logger = new NullLogger()
    ) {
    }

    /**
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function get(string $url, array $headers = []): array
    {
        return $this->makeRequest('GET', $url, null, $headers);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function post(string $url, array $data = [], array $headers = []): array
    {
        return $this->makeRequest('POST', $url, $data, $headers);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function put(string $url, array $data = [], array $headers = []): array
    {
        return $this->makeRequest('PUT', $url, $data, $headers);
    }

    /**
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function delete(string $url, array $headers = []): array
    {
        return $this->makeRequest('DELETE', $url, null, $headers);
    }

    public function getLastStatusCode(): ?int
    {
        return $this->lastStatusCode;
    }

    /**
     * @return array<string, array<string>>
     */
    public function getLastHeaders(): array
    {
        return $this->lastHeaders;
    }

    /**
     * @param array<string, mixed>|null $data
     * @param array<string, mixed>      $headers
     *
     * @return array<string, mixed>
     */
    private function makeRequest(string $method, string $url, ?array $data = null, array $headers = []): array
    {
        $request = $this->buildRequest($method, $url, $data, $headers);

        // Log request
        $this->logger->info('Sending HTTP request', [
            'type' => LogType::SEND_REQUEST->value,
            'method' => $method,
            'url' => $url,
            'headers' => $headers,
            'data' => $data,
        ]);

        $response = $this->transport->sendRequest($request);

        $this->lastStatusCode = $response->getStatusCode();
        $this->lastHeaders = $response->getHeaders();

        $responseData = $this->parseJsonResponse($response);

        if ($response->getStatusCode() >= 400) {
            $this->handleHttpError($response, $responseData);
        } else {
            // Log successful response
            $this->logger->info('HTTP request successful', [
                'type' => LogType::SUCCESS_RESULT->value,
                'method' => $method,
                'url' => $url,
                'status_code' => $response->getStatusCode(),
                'response_data' => $responseData,
            ]);
        }

        return $responseData;
    }

    /**
     * @param array<string, mixed>|null $data
     * @param array<string, mixed>      $headers
     */
    private function buildRequest(string $method, string $url, ?array $data, array $headers): RequestInterface
    {
        $defaultHeaders = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'Promptchan-PHP-SDK/1.0',
        ];

        $allHeaders = array_merge($defaultHeaders, $headers);
        $request = $this->requestFactory->createRequest($method, $url);

        foreach ($allHeaders as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        if ($data !== null && in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
            $body = $this->streamFactory->createStream(json_encode($data, JSON_THROW_ON_ERROR));
            $request = $request->withBody($body);
        }

        return $request;
    }

    /**
     * @return array<string, mixed>
     */
    private function parseJsonResponse(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();

        if ($content === '') {
            return [];
        }

        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            // Log parse error
            $this->logger->error('Failed to parse JSON response', [
                'type' => LogType::PARSE_RESULT_ERROR->value,
                'error' => $e->getMessage(),
                'raw_response' => $content,
                'status_code' => $response->getStatusCode(),
            ]);

            throw new ApiException(
                'Invalid JSON response: ' . $e->getMessage(),
                $response->getStatusCode(),
                ['raw_response' => $content]
            );
        }
    }

    /**
     * @param array<string, mixed> $responseData
     */
    private function handleHttpError(ResponseInterface $response, array $responseData): never
    {
        $statusCode = $response->getStatusCode();
        $message = $responseData['message'] ?? $responseData['error'] ?? 'HTTP Error';

        // Log HTTP error
        $this->logger->warning('HTTP request failed', [
            'type' => LogType::FAIL_RESULT->value,
            'status_code' => $statusCode,
            'message' => $message,
            'response_data' => $responseData,
        ]);

        if ($statusCode === 422 && isset($responseData['errors'])) {
            throw new ValidationException($message, $responseData['errors']);
        }

        throw new ApiException($message, $statusCode, $responseData);
    }
}
