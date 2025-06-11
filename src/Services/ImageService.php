<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Services;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\Contracts\ImageServiceInterface;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\DataTransferObjects\CreateImageResponse;

final class ImageService implements ImageServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
        private readonly \Psr\Log\LoggerInterface $logger
    ) {
    }

    public function create(CreateImageRequest $request): CreateImageResponse
    {
        try {
            $responseData = $this->apiClient->post('api/external/create', $request->toArray());

            return CreateImageResponse::fromArray($responseData);
        } catch (\Chudno\Promptchan\Exceptions\ApiException $e) {
            $this->logger->error(
                'API Error during image creation',
                ['exception' => $e, 'request_data' => $request->toArray()]
            );
            throw $e;
        }
    }
}
