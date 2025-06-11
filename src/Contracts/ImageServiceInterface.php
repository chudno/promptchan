<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Contracts;

use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\DataTransferObjects\CreateImageResponse;

interface ImageServiceInterface
{
    /**
     * Create an image using the provided request parameters.
     *
     * @param CreateImageRequest $request
     *
     * @return CreateImageResponse
     *
     * @throws \Chudno\Promptchan\Exceptions\ApiException
     * @throws \Chudno\Promptchan\Exceptions\ValidationException
     */
    public function create(CreateImageRequest $request): CreateImageResponse;
}
