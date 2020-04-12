<?php

namespace Bambamboole\LaravelCms\Tests\Unit\Backend\Resources;

use Bambamboole\LaravelCms\Backend\Resources\ResourceRepository;
use Illuminate\Config\Repository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResourceRepositoryTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_on_an_unknown_key()
    {
        $configMock = \Mockery::mock(Repository::class)
            ->shouldReceive('get')
            ->with('cms.resources')
            ->andReturn([])
            ->getMock();
        $repository = new ResourceRepository($configMock);

        $this->expectException(NotFoundHttpException::class);

        $repository->getResourceInstanceByIdentifier('unknown');
    }

    /** @test */
    public function it_instantiates_the_resource_if_key_is_found()
    {
        $configMock = \Mockery::mock(Repository::class)
            ->shouldReceive('get')
            ->with('cms.resources')
            ->andReturn(['test' => TestResource::class])
            ->getMock();
        $repository = new ResourceRepository($configMock);

        $resourceInstance = $repository->getResourceInstanceByIdentifier('test');

        $this->assertInstanceOf(TestResource::class, $resourceInstance);
    }
}

class TestResource
{
}
