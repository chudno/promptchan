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
        private readonly ApiClientInterface $apiClient,
        private readonly \Psr\Log\LoggerInterface $logger
    ) {
    }

    public function submit(VideoSubmitRequest $request): VideoSubmitResponse
    {
        try {
            $responseData = $this->apiClient->post('api/external/video_v2/submit', $request->toArray());

            return VideoSubmitResponse::fromArray($responseData);
        } catch (\Chudno\Promptchan\Exceptions\ApiException $e) {
            $this->logger->error(
                'API Error during video submission',
                ['exception' => $e, 'request_data' => $request->toArray()]
            );
            throw $e;
        }
    }

    public function getStatus(string $requestId): VideoStatusResponse
    {
        try {
            $responseData = $this->apiClient->get("api/external/video_v2/status/{$requestId}");

            return VideoStatusResponse::fromArray($responseData);
        } catch (\Chudno\Promptchan\Exceptions\ApiException $e) {
            $this->logger->error(
                'API Error during video status retrieval',
                ['exception' => $e, 'request_id' => $requestId]
            );
            throw $e;
        }
    }

    public function getResult(string $requestId): VideoResultResponse
    {
        try {
            $responseData = $this->apiClient->get("api/external/video_v2/result/{$requestId}");

            return VideoResultResponse::fromArray($responseData);
        } catch (\Chudno\Promptchan\Exceptions\ApiException $e) {
            $this->logger->error(
                'API Error during video result retrieval',
                ['exception' => $e, 'request_id' => $requestId]
            );
            throw $e;
        }
    }
}
