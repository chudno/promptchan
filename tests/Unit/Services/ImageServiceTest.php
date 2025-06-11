<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Tests\Unit\Services;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\DataTransferObjects\CreateImageRequest;
use Chudno\Promptchan\DataTransferObjects\CreateImageResponse;
use Chudno\Promptchan\Enums\ImageSize;
use Chudno\Promptchan\Enums\ImageStyle;
use Chudno\Promptchan\Enums\ImageQuality;
use Chudno\Promptchan\Services\ImageService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

final class ImageServiceTest extends TestCase
{
    private ApiClientInterface $apiClientMock;
    private ImageService $imageService;
    private LoggerInterface $loggerMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClientMock = $this->createMock(ApiClientInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->imageService = new ImageService($this->apiClientMock, $this->loggerMock);
    }

    /** @test */
    public function it_can_create_image_successfully(): void
    {
        $requestDto = new CreateImageRequest(
            prompt: 'A beautiful cat',
            style: ImageStyle::XL_REALISTIC,
            quality: ImageQuality::ULTRA,
            imageSize: ImageSize::S512x512
        );

        $expectedResponseData = [
            'image' => base64_encode('test_image_data'),
            'gems' => 10,
        ];

        $this->apiClientMock
            ->expects($this->once())
            ->method('post')
            ->with('api/external/create', $requestDto->toArray())
            ->willReturn($expectedResponseData);

        $response = $this->imageService->create($requestDto);

        $this->assertInstanceOf(CreateImageResponse::class, $response);
        $this->assertEquals(base64_encode('test_image_data'), $response->image);
        $this->assertEquals(10, $response->gems);
    }

    /** @test */
    public function it_handles_api_exception_during_image_creation(): void
    {
        $requestDto = new CreateImageRequest(
            prompt: 'A beautiful cat',
            style: ImageStyle::XL_REALISTIC,
            quality: ImageQuality::ULTRA,
            imageSize: ImageSize::S512x512
        );

        $this->apiClientMock
            ->expects($this->once())
            ->method('post')
            ->with('api/external/create', $requestDto->toArray())
            ->willThrowException(new \Chudno\Promptchan\Exceptions\ApiException('API Error', 500));

        $this->expectException(\Chudno\Promptchan\Exceptions\ApiException::class);
        $this->expectExceptionMessage('API Error');
        $this->expectExceptionCode(500);

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with(
                'API Error during image creation',
                $this->callback(function ($context) {
                    return isset($context['exception']) &&
                           $context['exception'] instanceof \Chudno\Promptchan\Exceptions\ApiException &&
                           $context['exception']->getMessage() === 'API Error' &&
                           $context['exception']->getCode() === 500;
                })
            );

        $this->imageService->create($requestDto);
    }
}