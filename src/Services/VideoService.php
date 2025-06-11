<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Services;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\Contracts\VideoServiceInterface;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitRequest;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitResponse;
use Chudno\Promptchan\DataTransferObjects\VideoStatusResponse;
use Chudno\Promptchan\DataTransferObjects\VideoResultResponse;

final class VideoService implements VideoServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient
    ) {
    }

    public function submit(VideoSubmitRequest $request): VideoSubmitResponse
    {
        $responseData = $this->apiClient->post('api/external/video_v2/submit', $request->toArray());

        return VideoSubmitResponse::fromArray($responseData);
    }

    public function getStatus(string $requestId): VideoStatusResponse
    {
        $responseData = $this->apiClient->get("api/external/video_v2/status/{$requestId}");

        return VideoStatusResponse::fromArray($responseData);
    }

    public function getResult(string $requestId): VideoResultResponse
    {
        $responseData = $this->apiClient->get("api/external/video_v2/result/{$requestId}");

        return VideoResultResponse::fromArray($responseData);
    }
}
