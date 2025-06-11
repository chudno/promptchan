<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Transport;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface TransportInterface
{
    /**
     * Send HTTP request and return response
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface;
}