<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Procurement\Entity\Customer\Request;

use App\Tests\Builder\Customer\RequestBuilder;
use Monolog\Test\TestCase;

class AddCriteriaTest extends TestCase
{
    public function testSuccess(): void
    {
        $request = (new RequestBuilder())->build();
        $request->addCriteria($name = 'processor', $percent = 20.0);
        self::assertNotEmpty($request->getCriterias());
        self::assertArrayHasKey(1, $request->getCriterias());
        $criteria = $request->getCriterias()[1];
        self::assertEquals($name, $criteria->getName());
        self::assertEquals($percent, $criteria->getPercent());
    }

    public function testFailed(): void
    {
        $request = (new RequestBuilder())->withCriteria('processor')->build();
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('processor criteria is already added.');
        $request->addCriteria('processor', 20.0);
    }
}
