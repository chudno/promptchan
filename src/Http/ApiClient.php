<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Http;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\Contracts\HttpClientInterface;

final class ApiClient implements ApiClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $baseUri,
        private readonly string $apiKey = ''
    ) {
    }

    /**
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function get(string $endpoint, array $headers = []): array
    {
        $url = $this->buildUrl($endpoint);
        $headers = $this->addAuthHeaders($headers);

        return $this->httpClient->get($url, $headers);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function post(string $endpoint, array $data = [], array $headers = []): array
    {
        $url = $this->buildUrl($endpoint);
        $headers = $this->addAuthHeaders($headers);

        return $this->httpClient->post($url, $data, $headers);
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function put(string $endpoint, array $data = [], array $headers = []): array
    {
        $url = $this->buildUrl($endpoint);
        $headers = $this->addAuthHeaders($headers);

        return $this->httpClient->put($url, $data, $headers);
    }

    /**
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    public function delete(string $endpoint, array $headers = []): array
    {
        $url = $this->buildUrl($endpoint);
        $headers = $this->addAuthHeaders($headers);

        return $this->httpClient->delete($url, $headers);
    }

    public function getLastStatusCode(): ?int
    {
        return $this->httpClient->getLastStatusCode();
    }

    /**
     * @return array<string, mixed>
     */
    public function getLastHeaders(): array
    {
        return $this->httpClient->getLastHeaders();
    }

    private function buildUrl(string $endpoint): string
    {
        $baseUri = rtrim($this->baseUri, '/');
        $endpoint = ltrim($endpoint, '/');

        return $baseUri . '/' . $endpoint;
    }

    /**
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     */
    private function addAuthHeaders(array $headers): array
    {
        if ($this->apiKey !== '') {
            $headers['Authorization'] = 'Bearer ' . $this->apiKey;
        }

        return $headers;
    }
}
