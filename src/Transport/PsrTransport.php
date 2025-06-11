<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Transport;

use Chudno\Promptchan\Exceptions\ApiException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final readonly class PsrTransport implements TransportInterface
{
    public function __construct(
        private ClientInterface $httpClient
    ) {
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new ApiException(
                'HTTP Client Error: ' . $e->getMessage(),
                0,
                ['exception_class' => get_class($e)]
            );
        } catch (\Throwable $e) {
            throw new ApiException(
                'Unexpected error: ' . $e->getMessage(),
                0,
                ['exception_class' => get_class($e)]
            );
        }
    }
}
