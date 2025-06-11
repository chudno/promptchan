<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Contracts;

interface HttpClientInterface
{
    /**
     * Send a GET request.
     *
     * @param string               $url
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     *
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function get(string $url, array $headers = []): array;

    /**
     * Send a POST request.
     *
     * @param string               $url
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     *
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function post(string $url, array $data = [], array $headers = []): array;

    /**
     * Send a PUT request.
     *
     * @param string               $url
     * @param array<string, mixed> $data
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     *
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function put(string $url, array $data = [], array $headers = []): array;

    /**
     * Send a DELETE request.
     *
     * @param string               $url
     * @param array<string, mixed> $headers
     *
     * @return array<string, mixed>
     *
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function delete(string $url, array $headers = []): array;

    /**
     * Get the last response status code.
     *
     * @return int|null
     */
    public function getLastStatusCode(): ?int;

    /**
     * Get the last response headers.
     *
     * @return array<string, array<string>>
     */
    public function getLastHeaders(): array;
}
