<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Contracts;

use Chudno\Promptchan\DataTransferObjects\VideoSubmitRequest;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitResponse;
use Chudno\Promptchan\DataTransferObjects\VideoStatusResponse;
use Chudno\Promptchan\DataTransferObjects\VideoResultResponse;

interface VideoServiceInterface
{
    /**
     * Submit a video generation request
     *
     * @param VideoSubmitRequest $request
     * @return VideoSubmitResponse
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     * @throws \Chudno\Promptchan\Exceptions\ValidationException
     */
    public function submit(VideoSubmitRequest $request): VideoSubmitResponse;

    /**
     * Get the status of a video generation request
     *
     * @param string $requestId
     * @return VideoStatusResponse
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function getStatus(string $requestId): VideoStatusResponse;

    /**
     * Get the result of a completed video generation request
     *
     * @param string $requestId
     * @return VideoResultResponse
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     */
    public function getResult(string $requestId): VideoResultResponse;
}