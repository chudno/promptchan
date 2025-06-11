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
        private readonly ApiClientInterface $apiClient
    ) {}

    public function create(CreateImageRequest $request): CreateImageResponse
    {
        $responseData = $this->apiClient->post('api/external/create', $request->toArray());

        return CreateImageResponse::fromArray($responseData);
    }
}