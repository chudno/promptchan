<?php

declare(strict_types=1);

namespace Chudno\Promptchan\Tests\Unit\Services;

use Chudno\Promptchan\Contracts\ApiClientInterface;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitRequest;
use Chudno\Promptchan\DataTransferObjects\VideoSubmitResponse;
use Chudno\Promptchan\DataTransferObjects\VideoStatusResponse;
use Chudno\Promptchan\DataTransferObjects\VideoResultResponse;
use Chudno\Promptchan\Enums\VideoAspect;
use Chudno\Promptchan\Enums\VideoQuality;
use Chudno\Promptchan\Enums\VideoStatus;
use Chudno\Promptchan\Exceptions\ApiException;
use Chudno\Promptchan\Services\VideoService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class VideoServiceTest extends TestCase
{
    private ApiClientInterface $apiClientMock;
    private LoggerInterface $loggerMock;
    private VideoService $videoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiClientMock = $this->createMock(ApiClientInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->videoService = new VideoService($this->apiClientMock, $this->loggerMock);
    }

    /** @test */
    public function it_can_submit_video_successfully(): void
    {
        $requestDto = new VideoSubmitRequest(
            prompt: 'A dancing cat',
            aspect: VideoAspect::PORTRAIT,
            quality: VideoQuality::HIGH
        );

        $expectedResponseData = ['request_id' => 'test_request_id'];

        $this->apiClientMock
            ->expects($this->once())
            ->method('post')
            ->with('api/external/video_v2/submit', $requestDto->toArray())
            ->willReturn($expectedResponseData);

        $response = $this->videoService->submit($requestDto);

        $this->assertInstanceOf(VideoSubmitResponse::class, $response);
        $this->assertEquals('test_request_id', $response->requestId);
    }

    /** @test */
    public function it_handles_api_exception_during_video_submission(): void
    {
        $requestDto = new VideoSubmitRequest(
            prompt: 'A dancing cat',
            aspect: VideoAspect::PORTRAIT,
            quality: VideoQuality::HIGH
        );

        $this->apiClientMock
            ->expects($this->once())
            ->method('post')
            ->with('api/external/video_v2/submit', $requestDto->toArray())
            ->willThrowException(new ApiException('Submit Error', 500));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Submit Error');
        $this->expectExceptionCode(500);

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with(
                'API Error during video submission',
                $this->callback(function ($context) {
                    return isset($context['exception']) &&
                           $context['exception'] instanceof ApiException &&
                           $context['exception']->getMessage() === 'Submit Error' &&
                           $context['exception']->getCode() === 500;
                })
            );

        $this->videoService->submit($requestDto);
    }

    /** @test */
    public function it_can_get_video_status_successfully(): void
    {
        $requestId = 'test_request_id';
        $expectedResponseData = ['request_id' => $requestId, 'status' => VideoStatus::COMPLETED->value, 'progress' => 100];

        $this->apiClientMock
            ->expects($this->once())
            ->method('get')
            ->with("api/external/video_v2/status/{$requestId}")
            ->willReturn($expectedResponseData);

        $response = $this->videoService->getStatus($requestId);

        $this->assertInstanceOf(VideoStatusResponse::class, $response);
        $this->assertEquals(VideoStatus::COMPLETED, $response->status);
        $this->assertEquals(100, $response->progress);
    }

    /** @test */
    public function it_handles_api_exception_during_video_status_retrieval(): void
    {
        $requestId = 'test_request_id';

        $this->apiClientMock
            ->expects($this->once())
            ->method('get')
            ->with("api/external/video_v2/status/{$requestId}")
            ->willThrowException(new ApiException('Status Error', 501));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Status Error');
        $this->expectExceptionCode(501);

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with(
                'API Error during video status retrieval',
                $this->callback(function ($context) {
                    return isset($context['exception']) &&
                           $context['exception'] instanceof ApiException &&
                           $context['exception']->getMessage() === 'Status Error' &&
                           $context['exception']->getCode() === 501;
                })
            );

        $this->videoService->getStatus($requestId);
    }

    /** @test */
    public function it_can_get_video_result_successfully(): void
    {
        $requestId = 'test_request_id';
        $expectedResponseData = ['request_id' => $requestId, 'status' => VideoStatus::COMPLETED->value, 'video_url' => 'http://example.com/video.mp4'];

        $this->apiClientMock
            ->expects($this->once())
            ->method('get')
            ->with("api/external/video_v2/result/{$requestId}")
            ->willReturn($expectedResponseData);

        $response = $this->videoService->getResult($requestId);

        $this->assertInstanceOf(VideoResultResponse::class, $response);
        $this->assertEquals('http://example.com/video.mp4', $response->videoUrl);
    }

    /** @test */
    public function it_handles_api_exception_during_video_result_retrieval(): void
    {
        $requestId = 'test_request_id';

        $this->apiClientMock
            ->expects($this->once())
            ->method('get')
            ->with("api/external/video_v2/result/{$requestId}")
            ->willThrowException(new ApiException('Result Error', 502));

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Result Error');
        $this->expectExceptionCode(502);

        $this->loggerMock
            ->expects($this->once())
            ->method('error')
            ->with(
                'API Error during video result retrieval',
                $this->callback(function ($context) {
                    return isset($context['exception']) &&
                           $context['exception'] instanceof ApiException &&
                           $context['exception']->getMessage() === 'Result Error' &&
                           $context['exception']->getCode() === 502;
                })
            );

        $this->videoService->getResult($requestId);
    }
}