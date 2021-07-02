<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Customer\Request;

use App\Tests\Builder\Customer\RequestBuilder;
use Monolog\Test\TestCase;

class PublishTest extends TestCase
{
    public function testSuccess(): void
    {
        $request = (new RequestBuilder())->build();
        $request->publish();
        self::assertFalse($request->isDraft());
        self::assertTrue($request->isPublished());
    }

    public function testFailed(): void
    {
        $request = (new RequestBuilder())->published()->build();
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Request For Proposal is already published');
        $request->publish();
    }
}
